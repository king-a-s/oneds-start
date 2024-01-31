<?php



/**
 * Add OneDS Version in at a glance admin widget
 */

function ods_admin_dashboard_widgets_update_right_now_message($content)
{
	$oneds_plugin_data = get_plugin_data(plugin_dir_path(__FILE__) . '../../oneds-start.php');
	$oneds_plugin_version = $oneds_plugin_data['Version'];
	$ods_content = '<p id="oneds-version-message"><span id="oneds-version">' . __('OneDS', 'oneds-start') . ' ' . $oneds_plugin_version;

	$ods_modules = array();
	$ods_modules = apply_filters('ods_update_running_modules', $ods_modules);

	// Check if $ods_modules is not empty
	if (!empty($ods_modules)) {
		// Convert array to string
		$ods_modules_string = implode(', ', $ods_modules);
		$ods_msg = $ods_content . ' ' . __('running these modules:') . ' ' . $ods_modules_string . '.</span></p>';
	} else {
		// No modules, do not display the message
		$ods_msg = $ods_content . '.</span></p>';
	}

	$new_content = $content;

	if (function_exists('ods_options_id')) {
		if (!empty(ods_options_id('dashboard'))) {

			if (get_post_meta(ods_options_id('dashboard'), 'no_theme_switch', true)) {
				$new_content = __('WordPress') . ' ' . get_bloginfo('version', 'display') . '.';

				// $new_content = sprintf('<span id="wp-version">' . $content . '</span>', get_bloginfo('version', 'display'), 'No');
			}
		}
	}

	return $new_content . $ods_msg;
}

add_filter('update_right_now_text', 'ods_admin_dashboard_widgets_update_right_now_message');


// example for add module
/*function ods_contacts_running_modules($ods_modules)
 {
	 $module = 'Contacts';
	 $ods_modules[] = $module;
	 return $ods_modules;
 }
 
 add_filter('ods_update_running_modules', 'ods_contacts_running_modules');*/

// END PART



/**
 * Add extra info in at a glance admin widget
 */

function ods_admin_dashboard_widgets_extra_info_in_at_a_glance_widget()
{
	$count_active_plugins = sizeof(get_option('active_plugins'));
	$count_users = count_users();

	$text = '%s ' . __('Active Plugins', 'oneds-wassina');
	$text = sprintf($text, number_format_i18n($count_active_plugins));

	if (current_user_can('administrator')) {
		$output = '<a href="' . admin_url('plugins.php?plugin_status=active') . '">' . $text . '</a>';
		echo '<li class="plugins-count">' . $output . '</li>';
	} else {
		$output = '<span>' . $text . '</span>';
		echo '<li class="plugins-count">' . $output . '</li>';
	}

	$text_2 = '%s ' . __('Users', 'oneds-wassina');
	$text_2 = sprintf($text_2, $count_users['total_users']);

	if (current_user_can('administrator')) {
		$output2 = '<a href="' . admin_url('users.php') . '">' . $text_2 . '</a>';
		echo '<li class="users-count">' . $output2 . '</li>';
	} else {
		$output2 = '<span>' . $text_2 . '</span>';
		echo '<li class="users-count">' . $output2 . '</li>';
	}
}

add_filter('dashboard_glance_items', 'ods_admin_dashboard_widgets_extra_info_in_at_a_glance_widget', 999, 1);


function ods_admin_dashboard_widgets_extra_info_in_at_a_glance_widget_css()
{
	echo '<style type="text/css">';
	echo '#dashboard_right_now .plugins-count a:before, #dashboard_right_now .plugins-count span:before { content: "\f106";}';
	echo '#dashboard_right_now .users-count a:before, #dashboard_right_now .users-count span:before { content: "\f110";}';

	echo '</style>';
}

add_action('admin_head', 'ods_admin_dashboard_widgets_extra_info_in_at_a_glance_widget_css');

// END PART



/**
 * Add OneDS Dashboard Widgets
 */


if (function_exists('ods_options_id')) {
	if (!empty(ods_options_id('dashboard'))) {

		if (get_post_meta(ods_options_id('dashboard'), 'admin_dashboard_widgets', true)) {

			return;
		}
	}
}

function ods_admin_dashboard_widgets_add_dashboard_widgets()
{
	// user profile info widget
	wp_add_dashboard_widget(
		'user_info_widget',         // $widget_id = Widget slug.
		__('Your Profile Information', 'oneds-start'),         // $widget_name = Title.
		'ods_admin_dashboard_widgets_user_profile_info_dashboard_widget', // $callback = Display function.
		null, // $control_callback = Optional.
		null, //$callback_args = Optional.
		'column3', //$context = 'normal', 'side', 'column3' or 'column4'.
		'default' //$priority = 'high', 'core', 'default' or 'low'.
	);

	// user system info widget
	wp_add_dashboard_widget(
		'user_system_info_widget',
		__('Your System Information', 'oneds-start'),
		'ods_admin_dashboard_widgets_user_system_info_dashboard_widget',
		null, // $control_callback = Optional.
		null, //$callback_args = Optional.
		'column3', //$context = 'normal', 'side', 'column3' or 'column4'.
		'default' //$priority = 'high', 'core', 'default' or 'low'.
	);

	// if user role is administrator
	if (current_user_can('administrator')) {

		// server info widget
		wp_add_dashboard_widget(
			'server_info_widget',
			__('Server Information', 'oneds-start'),
			'ods_admin_dashboard_widgets_server_info_dashboard_widget',
			null, // $control_callback = Optional.
			null, //$callback_args = Optional.
			'column3', //$context = 'normal', 'side', 'column3' or 'column4'.
			'default' //$priority = 'high', 'core', 'default' or 'low'.
		);

		// online users widget
		wp_add_dashboard_widget(
			'online_users_widget',
			__('Online Users', 'oneds-start'),
			'ods_admin_dashboard_widgets_online_users_dashboard_widget',
			null, // $control_callback = Optional.
			null, //$callback_args = Optional.
			'side', //$context = 'normal', 'side', 'column3' or 'column4'.
			'default' //$priority = 'high', 'core', 'default' or 'low'.
		);
	}
}
add_action('wp_dashboard_setup', 'ods_admin_dashboard_widgets_add_dashboard_widgets');

/**
 * Create the function to output the contents of our Dashboard Widgets. 
 */

// user_info_widget
function ods_admin_dashboard_widgets_user_profile_info_dashboard_widget()
{
	// Display whatever it is you want to show.
	$x = is_rtl() ? 'right' : 'left';
?> <style>
		table.odsWidget {
			border-collapse: collapse;
			border-spacing: 0;
			width: 100%;
			font-size: inherit;
		}

		table.odsWidget th,
		table.odsWidget td {
			margin: 0;
			padding: 8px;
			text-align: <?php echo $x; ?>;
			vertical-align: top;
			word-break: break-word;
		}

		table.odsWidget th {
			white-space: nowrap;
			width: 150px;
		}

		table.odsWidget tr:nth-child(odd) {
			background: #fafafa;
		}
	</style>
	<?php
	$current_user = wp_get_current_user();
	$user_id = $current_user->ID;
	$username = $current_user->user_login;
	$useremail = $current_user->user_email;
	$userdname = $current_user->display_name;

	if (!function_exists('get_user_role_name')) {
		function get_user_role_name($user_ID)
		{
			global $wp_roles;

			$user_data = get_userdata($user_ID);
			$user_roles = $user_data->roles;
			$user_role_slug = array_shift($user_roles);

			$role_name = translate_user_role($wp_roles->roles[$user_role_slug]['name']);
			return $role_name;
		}
	}

	echo '<table class="odsWidget">';
	echo '<tr><th>' . __('User ID', 'oneds-start') . '</th>';
	echo '<td>' . $user_id . '</td></tr>';
	echo '<tr><th>' . __('Username', 'oneds-start') . '</th>';
	echo '<td>' . $username . '</td></tr>';
	echo '<tr><th>' . __('User Email', 'oneds-start') . '</th>';
	echo '<td>' . $useremail . '</td></tr>';
	echo '<tr><th>' . __('User Display Name', 'oneds-start') . '</th>';
	echo '<td>' . $userdname . '</td></tr>';
	echo '<tr><th>' . __('User Role', 'oneds-start') . '</th>';
	echo '<td>';
	echo get_user_role_name($user_id);
	echo '</td></tr>';
	echo '</table>';
}

// user system info
function ods_admin_dashboard_widgets_user_system_info_dashboard_widget()
{

	echo '<table class="odsWidget"';

	$agent = $_SERVER['HTTP_USER_AGENT'];

	// Detect Device/Operating System

	if (preg_match('/Android/i', $agent)) $os = 'Android';
	elseif (preg_match('/Linux/i', $agent)) $os = 'Linux';
	elseif (preg_match('/Mac/i', $agent)) $os = 'Apple Mac';
	elseif (preg_match('/iPhone/i', $agent)) $os = 'Apple iPhone';
	elseif (preg_match('/iPad/i', $agent)) $os = 'Apple iPad';
	elseif (preg_match('/windows phone 10/i', $agent)) $os = 'Microsoft Windows 10 Mobile';
	elseif (preg_match('/Unix/i', $agent)) $os = 'Unix';
	elseif (preg_match('/windows nt 10/i', $agent) && preg_match('/64/', $agent)) $os = '<div id="windowsm"style="
    display: inline;"></div>' . ' x64';
	elseif (preg_match('/windows nt 10/i', $agent)) $os = '<div id="windowsm"style="
    display: inline;"></div>' . ' x86';
	elseif (preg_match('/windows nt 6.3/i', $agent)) $os = 'Microsoft Windows 8.1';
	elseif (preg_match('/windows nt 6.2/i', $agent)) $os = 'Microsoft Windows 8';
	elseif (preg_match('/windows nt 6.1/i', $agent)) $os = 'Microsoft Windows 7';
	elseif (preg_match('/windows nt 6.0/i', $agent)) $os = 'Microsoft Windows Vista';
	elseif (preg_match('/windows nt 5.1/i', $agent) || preg_match('/windows xp/i', $agent)) $os = 'Microsoft Windows XP';

	else $os = 'Unknown OS';

	// Browser Detection

	if (preg_match('/Firefox/i', $agent)) $br = 'Mozilla Firefox';
	elseif (preg_match('/opr/i', $agent)) $br = 'Opera Chromium';
	elseif (preg_match('/rv:11/i', $agent)) $br = 'Microsoft Inetrnet Explorer 11';
	elseif (preg_match('/Mac/i', $agent)) $br = 'Apple Safari';
	elseif (preg_match('/Edge/i', $agent)) $br = 'Microsoft Edge';
	elseif (preg_match('/electron/i', $agent)) $br = 'Electron App';
	elseif (preg_match('/Edg/i', $agent) && preg_match('/Chrome/i', $agent)) $br = 'Microsoft Edge Chromium';
	elseif (preg_match('/Chrome/i', $agent)) $br = 'Google Chrome';
	elseif (preg_match('/MSIE/i', $agent)) $br = 'Microsoft Inetrnet Explorer';
	else $br = 'Unknown Browser';

	$tot = $agent;

	echo '<tr><th>' . __('Operating System', 'oneds-start') . '</th>';
	echo '<td>' . $os . '</td></tr>';
	echo '<tr><th>' . __('Browser', 'oneds-start') . '</th>';
	echo '<td>' . $br . '</td></tr>';
	echo '<tr><th>' . __('All info', 'oneds-start') . '</th>';
	echo '<td>' . $tot . '</td></tr>';

	echo '</table>';
	?>

	<script>
		navigator.userAgentData.getHighEntropyValues(["platformVersion"])
			.then(ua => {
				if (navigator.userAgentData.platform === "Windows") {
					const majorPlatformVersion = parseInt(ua.platformVersion.split('.')[0]);
					if (majorPlatformVersion >= 13) {
						let winName = "Microsoft Windows 11";
						document.getElementById("windowsm").innerHTML = winName;
					} else if (majorPlatformVersion > 0) {
						let winName = "Microsoft Windows 10";
						document.getElementById("windowsm").innerHTML = winName;
					} else {
						console.log("Before Windows 10");
					}
				} else {
					console.log("Not running on Windows");
				}
			});
	</script>
<?php

}



// server info (for admin only)
function ods_admin_dashboard_widgets_server_info_dashboard_widget()
{
	global $wpdb;

	$output  = "";

	$output .= '<table class="odsWidget">';

	if (php_uname()) :
		$output .= '	<tr><th>' . __('Operating System', 'oneds-start') . '</th>';
		$output .= '	<td>' . php_uname() . '</td></tr>';
	endif;

	$output .= '	<tr><th>' . __('Web Server Version', 'oneds-start') . '</th>';
	$output .= '	<td>' . $_SERVER["SERVER_SOFTWARE"] . '</dd>';
	if (phpversion()) :
		$output .= '	<tr><th>' . __('PHP Version', 'oneds-start') . '</th>';
		$output .= '	<td>' . phpversion() . '</td></tr>';
	endif;
	if (ini_get('memory_limit')) :
		$output .= '	<tr><th>' . __('PHP Memory Limit', 'oneds-start') . '</th>';
		$output .= '	<td>' . ini_get('memory_limit') . '</td></tr>';
	endif;
	if (ini_get('post_max_size')) :
		$output .= '	<tr><th>' . __('PHP post_max_size', 'oneds-start') . '</th>';
		$output .= '	<td>' . ini_get('post_max_size') . '</td></tr>';
	endif;
	if (ini_get('upload_max_filesize')) :
		$output .= '	<tr><th>' . __('PHP upload_max_filesize', 'oneds-start') . '</th>';
		$output .= '	<td>' . ini_get('upload_max_filesize') . '</td></tr>';
	endif;
	if (ini_get('max_input_vars')) :
		$output .= '	<tr><th>' . __('PHP max_input_vars', 'oneds-start') . '</th>';
		$output .= '	<td>' . ini_get('max_input_vars') . '</td></tr>';
	endif;
	if (ini_get('max_execution_time')) :
		$output .= '	<tr><th>' . __('PHP max_execution_time', 'oneds-start') . '</th>';
		$output .= '	<td>' . ini_get('max_execution_time') . '</td></tr>';
	endif;
	if ($wpdb->db_version()) :
		$output .= '	<tr><th>' . __('MySQL Version', 'oneds-start') . '</th>';
		$output .= '	<td>' . $wpdb->db_version() . '</td></tr>';
	endif;
	$output .= '</table>';

	// shell_exec('wmic bios get serialnumber') 

	echo $output;
}


// online users (for admin only)
function ods_admin_dashboard_widgets_online_users_dashboard_widget2()
{
	echo '<div>';

	// Display online users count
	$online_users_count = ods_get_online_users_count(); // Get the count of online users
	echo '<p>' . __('Number of users currently online', 'oneds-start') . ': ' . $online_users_count . '</p>'; // Display the count of online users

	echo '<hr>';

	// Display online users and their names

	$online_users = get_transient('online_users'); // Get the list of currently online users

	if ($online_users && is_array($online_users)) { // Check if data is available and it's an array
		echo '<ul>'; // Start an unordered list to display users
		foreach ($online_users as $user_id) {
			$user_info = get_userdata($user_id); // Get user information using user ID
			if ($user_info) {
				echo '<li>' . $user_info->display_name . '</li>'; // Display user's name
			}
		}
		echo '</ul>'; // Close the unordered list
	} else {
		echo __('There are no users currently online.', 'oneds-start'); // Display a message if no users are found online
	}
	echo '</div>';
}

// END PART



/**
 * online users functions
 */

// Get online users count
function ods_get_online_users_count()
{
	$count = 0;
	$online_users = get_transient('online_users'); // Get the list of currently online users
	if ($online_users && is_array($online_users)) { // Check if data is available and it's an array
		$count = count($online_users); // Count the number of online users
	}
	return $count; // Return the count of online users
}

// Update online users count
function ods_update_online_users_count()
{
    $current_user_id = get_current_user_id(); // Get the current user ID
    $online_users = get_transient('online_users'); // Get the list of currently online users

    if (!$online_users) { // Check if the list is empty
        $online_users = array(); // Create a new list
    }

    // Check if the current user ID is not already in the list
    if (!in_array($current_user_id, $online_users)) { 
        $online_users[] = $current_user_id; // Add the current user ID to the list
    }

    // Remove duplicate user IDs
    $online_users = array_unique($online_users);

    set_transient('online_users', $online_users, 15); // Update the list of online users to include the current user for 15 seconds
}

// Hook to update online users count on every page load
add_action('init', 'ods_update_online_users_count'); // Call the update_online_users_count() function on every page load


// END PART


// online users (for admin only)
function ods_admin_dashboard_widgets_online_users_dashboard_widget()
{
	echo '<div>';

	// Display online users count
	$online_users_count = ods_get_online_users_count(); // Get the count of online users
	echo '<p>' . __('Number of users currently online', 'oneds-start') . ': ' . $online_users_count . '</p>'; // Display the count of online users

	echo '<hr>';

	// Display online registered users
	$online_registered_users = ods_get_online_registered_users();
	if ($online_registered_users && is_array($online_registered_users)) {
		echo '<h4>' . __('Registered Users Online', 'oneds-start') . '</h4>';
		echo '<ul>';
		foreach ($online_registered_users as $user_id) {
			$user_info = get_userdata($user_id);
			if ($user_info) {
				echo '<li>' . $user_info->display_name . '</li>';
			}
		}
		echo '</ul>';
	} else {
		echo '<p>' . __('No registered users currently online.', 'oneds-start') . '</p>';
	}

	echo '<hr>';

	// Display online guest users
	$online_guest_users = ods_get_online_guest_users();
	if ($online_guest_users && is_array($online_guest_users)) {
		echo '<h4>' . __('Guest Users Online', 'oneds-start') . '</h4>';
		echo '<ul>';
		foreach ($online_guest_users as $guest_user) {
			echo '<li>' . $guest_user . '</li>';
		}
		echo '</ul>';
	} else {
		echo '<p>' . __('No guest users currently online.', 'oneds-start') . '</p>';
	}

	echo '</div>';
}

// Get online registered users
function ods_get_online_registered_users()
{
	$online_users = get_transient('online_users'); // Get the list of currently online users
	$registered_users = array();

	if ($online_users && is_array($online_users)) {
		foreach ($online_users as $user_id) {
			$user = get_userdata($user_id);
			if ($user && $user->ID != 0) {
				$registered_users[] = $user->ID;
			}
		}
	}

	return $registered_users;
}

// Get online guest users
function ods_get_online_guest_users()
{
	$online_users = get_transient('online_users'); // Get the list of currently online users
	$guest_users = array();

	if ($online_users && is_array($online_users)) {
		foreach ($online_users as $user_id) {
			$user = get_userdata($user_id);
			if (!$user || $user->ID == 0) {
				$guest_users[] = __('Guest', 'oneds-start');
			}
		}
	}

	return $guest_users;
}
