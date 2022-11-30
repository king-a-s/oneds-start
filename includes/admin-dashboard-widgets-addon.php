<?php

function ods_add_dashboard_widgets()
{
	wp_add_dashboard_widget(
		'userinfo_widget',         // Widget slug.
		__('Your Profile Information', 'oneds-start'),         // Title.
		'ods_userinfo_dashboard_widget', // Display function.
		null,
		null,
		'column3'
	);

	wp_add_dashboard_widget(
		'systemspecs_widget',
		__('Your System Information', 'oneds-start'),
		'ods_systemspecs_dashboard_widget',
		null,
		null,
		'column3'
	);

	wp_add_dashboard_widget(
		'serverspecs_widget',
		__('Server Information', 'oneds-start'),
		'ods_serverspecs_dashboard_widget',
		null,
		null,
		'column3'
	);
}
add_action('wp_dashboard_setup', 'ods_add_dashboard_widgets');

// Create the function to output the contents of our Dashboard Widget.

function ods_userinfo_dashboard_widget()
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
	//$user = new WP_User($user_id);
	$username = $current_user->user_login;
	//$userrole = '1';
	$useremail = $current_user->user_email;
	$userdname = $current_user->display_name;

	if (!function_exists('get_user_role_name')) {
		function get_user_role_name($user_ID)
		{
			global $wp_roles;

			$user_data = get_userdata($user_ID);
			$user_role_slug = $user_data->roles[0];
			return translate_user_role($wp_roles->roles[$user_role_slug]['name']);
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
	//foreach ($user->roles as $role)
	//	echo $role;
	echo get_user_role_name($user_id);
	echo '</td></tr>';
	echo '</table>';
}

function ods_systemspecs_dashboard_widget()
{
	// Display whatever it is you want to show.
	// $x = is_rtl() ? 'right' : 'left';
	// echo "";

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
	//echo '<br>';
	//echo $br;
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

function ods_serverspecs_dashboard_widget()
{
	global $wpdb;
	// global $wp_version;

	$active_plugins = get_option('active_plugins');
	// $count_active_plugins = sizeof($active_plugins);
	// $count_users = count_users();
	// $x = is_rtl() ? 'right' : 'left';
	$output  = "";

	$output .= '<table class="odsWidget">';

	if (php_uname()) :
		$output .= '	<tr><th>' . __('Operating System', 'oneds-start') . '</th>';
		$output .= '	<td>' . php_uname() . '</td></tr>';
	endif;

	/*$output .= '	<tr><th>' . __('WordPress Version', 'oneds-start') . '</th>';
	$output .= '	<td>' . $wp_version . '<br>';
	$output .= '    <a href="' . admin_url('plugins.php?plugin_status=active') . '">' . $count_active_plugins . '</a> ' . __('Active Plugins', 'oneds-start')
		. ',<a href="' . admin_url('users.php') . '">' . $count_users['total_users'] . '</a> ' . __('registered users', 'oneds-start')
		. '</td></tr>';

	$output .= '	<tr><th>' . __('OneDS System Version', 'oneds-start') . '</th>';
	$oneds_plugin_data = get_plugin_data(plugin_dir_path(__FILE__) . '../oneds-start.php');
    $oneds_plugin_version = $oneds_plugin_data['Version'];
	$output .= '	<td>' . $oneds_plugin_version . '</td></tr>';
	*/
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
	/*if ( zend_version() ) :
	$output .= '	<tr><th>' .__('Zend Engine Version', 'oneds-start') .'</th>';
	$output .= '	<td>' . zend_version() . '</td></tr>';
	endif;*/
	if ($wpdb->db_version()) :
		$output .= '	<tr><th>' . __('MySQL Version', 'oneds-start') . '</th>';
		$output .= '	<td>' . $wpdb->db_version() . '</td></tr>';
	endif;
	$output .= '</table>';

	// shell_exec('wmic bios get serialnumber') 

	echo $output;
}

// END PART