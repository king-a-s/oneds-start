<?php

/**
 * Remove default Welcome Dashboard Panel and add OneDS Welcome Panel
 */

// OneDS welcome panel function
function ods_admin_welcome_welcome_panel()
{
	// if current screen is not dashboard, return
	if (get_current_screen()->id != 'dashboard') {
		return;
	}

?>
	<script>
		function addSection(className, html) {
			var h1Element = document.querySelector(className + ' h1');
			if (h1Element) {
				var parent = h1Element.parentNode;
				var newElement = document.createElement('div');
				newElement.innerHTML = html;
				parent.insertBefore(newElement, h1Element.nextSibling);
			}
		}

		function ods_admin_welcome_welcome_panel_html() {
			<?php
			$classes = 'welcome-panel';

			// Time like 12:55 pm (local time) not gmt
			$time = current_time('timestamp', 0);
			$time = date_i18n('g:i a', $time);

			// Date like Monday, 12 April
			$date = date_i18n('l, d F', $time);

			$option = (int) get_user_meta(get_current_user_id(), 'show_welcome_panel', true);
			// 0 = hide, 1 = toggled to show or single site creator, 2 = multisite site owner.

			$hide = (0 === $option || (2 === $option && wp_get_current_user()->user_email !== get_option('admin_email')));
			if ($hide) {
				// $classes .= ' hidden';
			}

			?>
			var html = '<div id="welcome-panel" class="<?php echo esc_attr($classes); ?>">';
			html += '<?php wp_nonce_field('welcome-panel-nonce', 'welcomepanelnonce', false); ?>';
			html += '<a class="welcome-panel-close" href="<?php echo esc_url(admin_url('?welcome=0')); ?>" aria-label="<?php esc_attr_e('Dismiss the welcome panel'); ?>"><?php _e('Dismiss'); ?></a>';
			html += '<div class="welcome-panel-content">';
			html += '<div class="welcome-panel-header">'
			html += '<h2><?php /* _e('Welcome to OneDS', 'oneds-start'); */ _e('Welcome', 'oneds-start'); ?>!</h2>';
			html += '<p class="about-description">';
			html += '<?php
						// Welcome phrase depending on the time
						$hour = date('G');
						if ($hour >= 5 && $hour <= 11) {
							_e('Good morning', 'oneds-start');
						} elseif ($hour >= 12 && $hour <= 18) {
							_e('Good afternoon', 'oneds-start');
						} elseif ($hour >= 19 || $hour <= 4) {
							_e('Good evening', 'oneds-start');
						}
						?>';
			html += '</p>';
			html += '</div>';
			html += '<div class="welcome-panel-side-column">';
			html += '<p id="time"><?php echo $time; ?></p>'; // Time like 12:55 PM
			html += '<p id="date"><?php echo $date; ?></p>'; // Date like Monday, 12 April
			html += '</div>';
			html += '</div>';
			html += '</div>';

			return html;
		}

		addSection('.wrap', ods_admin_welcome_welcome_panel_html());
	</script>

	<style>
		.welcome-panel {
			box-shadow: 0 1px 1px rgb(0 0 0 / 4%);
		}

		.welcome-panel .welcome-panel-close {
			display: none;
			color: #000 !important;
		}

		.welcome-panel-header {
			padding: 24px 24px 36px 24px;
		}

		.welcome-panel-side-column {
			padding: 24px 24px 36px 24px;
			text-align: center;
			min-width: 25%;
			background: #fff;
			color: #334155;
		}

		.welcome-panel-content {
			flex-direction: inherit;
			min-height: 120px;
			color: #f0f2f5;
		}

		.welcome-panel h2 {
			margin: 0;
			font-size: 48px;
			font-weight: 600;
			line-height: 1.25;
			color: #fff;
		}

		p#time {
			font-size: 48px;
			margin: 0;
		}

		p#date {
			font-size: 24px;
			margin: 0;
		}
	</style>

	<script>
		function realTimeClock() {
			// first get currentTime from wordpress
			<?php
			// Time like 12:55 pm (local time) not gmt
			$time = current_time('timestamp', 0);
			$hour = date_i18n('H', $time);
			$minute = date_i18n('i', $time);
			$ampm = date_i18n('a', $time);

			// Date like Monday, 12 April
			$date = date_i18n('l, d F', $time);
			?>

			// set start currentTime based on time from php
			var currentTime = new Date();
			var separator = ":";
			var hours = <?php echo $hour; ?>;
			var minutes = <?php echo $minute; ?>;
			var ampm = "<?php echo $ampm; ?>";

			// set hours and minutes based on currentTime
			hours = currentTime.getHours();
			minutes = currentTime.getMinutes();


			// make separator blink every second by makeit transparent
			if (currentTime.getSeconds() % 2 == 0) {
				separator = "<span style='opacity: 0;'>:</span>";
			}

			// show Time like 12:55 pm
			var time = hours + separator + minutes + " " + ampm;

			if (minutes) {
				minutes = minutes < 10 ? "0" + minutes : minutes;
			} else {
				minutes = "00";
			}

			if (hours > 12) {
				time = (hours - 12) + separator + minutes + " <?php _e('pm') ?>";
			} else {
				time = hours + separator + minutes + " <?php _e('am') ?>";
			}

			document.getElementById("time").innerHTML = time;
		}
		setInterval(realTimeClock, 1000);
	</script>

<?php
}

// remove default welcome panel and add OneDS welcome panel
function ods_admin_welcome_welcome_panel_actions()
{
	remove_action('welcome_panel', 'wp_welcome_panel');
	add_action('admin_footer', 'ods_admin_welcome_welcome_panel');
}

add_action('load-index.php', 'ods_admin_welcome_welcome_panel_actions');

// END PART