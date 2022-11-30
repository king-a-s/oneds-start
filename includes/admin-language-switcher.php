<?php

/**
 * Parse HTML of wp_dropdown_languages into array
 */

function ods_als_parse_wp_dropdown_languages()
{

	$user_locale = get_user_locale();
	$available_languages = get_available_languages();
	ob_start();
	wp_dropdown_languages(
		[
			'name'                        => 'locale',
			'id'                          => 'locale',
			'selected'                    => $user_locale,
			'languages'                   => $available_languages,
			'show_available_translations' => false,
			'show_option_site_default'    => true,
		]
	);
	$wp_dropdown_languages = ob_get_contents();
	ob_end_clean();
	$languages = [
		'active' => [],
		'available' => []
	];

	$dom = new \DOMDocument();
	$dom->loadHTML(mb_convert_encoding($wp_dropdown_languages, 'HTML-ENTITIES', 'UTF-8'));
	$options = $dom->getElementsByTagName('option');
	for ($i = 0; $i < $options->length; $i++) {
		$language = [
			'value' => $options->item($i)->getAttribute('value'),
			'title' => $options->item($i)->nodeValue,
		];
		if ($options->item($i)->hasAttribute('selected')) {
			$languages['active'] = $language;
		} else {
			$languages['available'][] = $language;
		}
	}

	return $languages;
}
// END PART



/**
 * Add custom icon to the admin bar
 */

function ods_als_admin_css()
{
?>
	<!-- <style>
		#wpadminbar #wp-admin-bar-salc-current-language .ab-icon:before {
			content: "\f326";
			top: 3px;
		}

		@media screen and (max-width: 782px) {
			#wpadminbar li#wp-admin-bar-salc-current-language {
				display: block;
			}

			#wpadminbar #wp-admin-bar-salc-current-language>.ab-item {
				width: 50px;
				text-align: center
			}

			#wpadminbar #wp-admin-bar-salc-current-language>.ab-item .ab-icon:before {
				font: 32px/1 "dashicons";
				top: -1px
			}

			#wpadminbar #wp-admin-bar-salc-current-language>.ab-item img {
				margin: 19px 0
			}

			#wpadminbar #wp-admin-bar-salc-current-language #wp-admin-bar-all .ab-item .ab-icon {
				/* margin-$y: 6px; */
				font-size: 20px !important;
				line-height: 20px !important
			}
		}
	</style> -->

	<style>
		#wpadminbar #wp-admin-bar-salc-current-language .ab-icon:before {
			content: "\f326";
			top: 2px;
		}

		@media screen and (max-width: 782px) {
			#wpadminbar li#wp-admin-bar-salc-current-language {
				display: block
			}

			#wpadminbar #wp-admin-bar-salc-current-language>.ab-item {
				width: 50px;
				text-align: center
			}

			#wpadminbar #wp-admin-bar-salc-current-language>.ab-item .ab-icon:before {
				font: 32px/1 "dashicons";
				top: -1px
			}

			#wpadminbar #wp-admin-bar-salc-current-language>.ab-item img {
				margin: 19px 0
			}

			#wpadminbar #wp-admin-bar-salc-current-language #wp-admin-bar-all .ab-item .ab-icon {
				font-size: 20px !important;
				line-height: 20px !important
			}

			ul#wp-admin-bar-salc-current-language-default {
				position: fixed;
				background: inherit;
				width: 100%;
				right: 0;
				left: 0;
				box-shadow: 0 3px 5px rgb(0 0 0 / 20%);
			}
		}
	</style>
<?php
}
add_action('admin_head', 'ods_als_admin_css');

// END PART



/**
 * Load script
 */

function ods_als_load_script($hook_suffix)
{

	// Check for permissions and if it is admin.
	if (!current_user_can('read') || !is_admin()) {
		return;
	}
	wp_enqueue_script('salc', plugin_dir_url(dirname(__FILE__)) . 'assets/js/als-script.js');
	wp_localize_script('salc', 'props', [
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce("salc_change_user_locale")
	]);
}
add_action('admin_enqueue_scripts', 'ods_als_load_script');

// END PART



/**
 * Add menu to admin bar
 */

function ods_als_admin_menu($admin_bar)
{

	// Check for permissions and if it is admin.
	if (!current_user_can('read') || !is_admin()) {
		return;
	}

	$languages = ods_als_parse_wp_dropdown_languages();

	$admin_bar->add_menu([
		'id'    => 'salc-current-language',
		'parent' => 'top-secondary',
		'title' => '<span class="ab-icon"></span>' . '<span class="ab-label">' . __('Language') . '</span>', //$languages['active']['title'],
		'href'  => '#',
		'meta' => [
			'title' => __('Current dashboard language', 'oneds-start'),
			'onclick'  => "return false;"
		]
	]);

	$admin_bar->add_menu([
		'id'    => 'salc-current-' . sanitize_title($languages['active']['title']),
		'parent' => 'salc-current-language',
		'title' => $languages['active']['title'],
		'href' => '#' . ($languages['active']['value'] ? $languages['active']['value'] : 'en_US'),
	]);

	foreach ($languages['available'] as $la) {
		$admin_bar->add_menu([
			'id'    => 'salc-current-' . sanitize_title($la['title']),
			'parent' => 'salc-current-language',
			'title' => $la['title'],
			'href' => '#' . ($la['value'] ? $la['value'] : 'en_US'),
		]);
	}
}
add_action('admin_bar_menu', 'ods_als_admin_menu', 500);

// END PART



/**
 * Change user locale
 */

function ods_als_change_user_locale_ajax()
{

	if (!isset($_REQUEST['nonce']) || !wp_verify_nonce($_REQUEST['nonce'], "salc_change_user_locale")) {
		wp_die(esc_html(__('Something went wrong, try again.', 'oneds-start')));
	}


	// Check for permissions and if it is admin.
	if (!current_user_can('read') || !is_admin()) {

		wp_die(esc_html(__('You don\'t have permissions to change language.', 'oneds-start')));
	}

	$user_id = \get_current_user_id();

	$lang = isset($_REQUEST['lang']) ? \sanitize_text_field(wp_unslash($_REQUEST['lang'])) : false;

	if (!$user_id || !$lang) {
		\wp_send_json_error('updated', 403);
		wp_die();
	}

	if ($lang === 'site-default') {
		$lang = null;
	}

	wp_update_user(['ID' => $user_id, 'locale' => $lang]);

	\wp_send_json_success('updated', 200);
	wp_die();
}

add_action('wp_ajax_change_user_locale', 'ods_als_change_user_locale_ajax');

// END PART