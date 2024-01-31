<?php

/**
 * Register function to get id from options page
 */

function ods_options_id($options_type)
{
	global $wpdb;
	$lastrowId = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type='optionspage' AND post_title = '$options_type' ORDER BY post_date DESC ");
	if (isset($lastrowId[0])) {
		return $lastrowId[0];
	}
}

// END PART



/**
 * function to add new options page
 */

function ods_add_options_page($page_name, $page_slug, $page_parent = 0, $capability = 'manage_options', $meta_input = array(), $parent_slug = 'options-general.php')
{
	$page_title = $page_name;

	if ($parent_slug == 'options-general.php') {
		$page_title = $page_name . ' ' . __('Settings');
	}

	if ($parent_slug == 'reports') {
		$page_title = $page_name . ' ' . __('Report');
	}

	if ($page_slug == 'reports') {
		$page_title = __('Reports', 'oneds-start');
	}

	$menu_title = $page_name;
	$menu_slug = $page_slug;

	$function = function () use ($page_slug, $page_title, $capability, $parent_slug) {
		// check user capabilities
		if (!current_user_can($capability)) {
			return;
		}
?>
		<div class="wrap">
			<h1> <?php echo $page_title; ?> </h1>
			<?php

			global $wpdb;
			$lastrowId = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type='optionspage' AND post_title = '$page_slug' ORDER BY post_date DESC ");

			if (isset($lastrowId[0])) {
				$lastPropertyId = $lastrowId[0];
				$options_post_id = $lastPropertyId;
				$postarray = null;
			} else {
				$options_post_id = 'new_post';
				$postarray = array(
					'post_type'     => 'optionspage',
					'post_status'   => 'publish',
					'post_title'   => $page_slug,
				);
			}

			$submit_value = __('Save');
			$updated_message = __('Options Updated', 'oneds-start');

			if ($parent_slug == 'reports') {
				$submit_value = __('Submit');
				$updated_message = __('Report ready', 'oneds-start');
			}

			acf_form(array(
				'post_id'       => $options_post_id,
				'new_post'      => $postarray,
				'submit_value'  => $submit_value,
				'updated_message' => $updated_message,
			));

			?>
		</div>
<?php

		do_action('page_content_for_' . $page_slug);
	};

	add_submenu_page(
		$parent_slug,
		$page_title,
		$menu_title,
		$capability,
		$menu_slug,
		$function
	);

	global $wpdb;
	$lastrowId = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type='optionspage' AND post_title = '$page_slug' ORDER BY post_date DESC ");

	if (!isset($lastrowId[0])) {
		// Gather post data.
		$new_post = array(
			'post_type'     => 'optionspage',
			'post_status'   => 'publish',
			'post_title'   => $page_slug,
			'post_parent'   => $page_parent,
			'meta_input' => $meta_input,
		);

		// Insert the post into the database.
		wp_insert_post($new_post);
	}
}

// END PART



/**
 * Retrieves the title of a submenu page based on its menu slug.
 */
function ods_get_submenu_page_title_by_menu_slug($menu_slug)
{
	global $submenu;

	foreach ($submenu as $parent_slug => $sub_menu_items) {
		foreach ($sub_menu_items as $menu_item) {
			if ($menu_item[2] === $menu_slug) {
				return $menu_item[0];
			}
		}
	}

	return '';
}

// END PART



function ods_set_custom_option_page_parent()
{
	$current_screen = get_current_screen();

	if ((strpos($current_screen->id, 'reports_page') !== false) || (strpos($current_screen->id, 'settings_page') !== false)) {
		// تعيين الوالدين باستخدام WP_Screen::set_parentage()
		$current_screen->set_parentage('optionspage');
	}
}

add_action('current_screen', 'ods_set_custom_option_page_parent');
