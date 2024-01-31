<?php

function ods_admin_hello_get_lyric()
{
	/** These are the lyrics to Hello ODS */
	$lyrics = get_field('hello', ods_options_id('dashboard'));

	// Here we split it into lines
	$lyrics = explode("\n", $lyrics);

	// And then randomly choose a line
	return wptexturize($lyrics[mt_rand(0, count($lyrics) - 1)]);
}

// This just echoes the chosen line, we'll position it later
function ods_hello()
{
	$chosen = ods_admin_hello_get_lyric();
	echo '<p id="hello">' . $chosen . '</p>';
}

// Now we set that function up to execute when the admin_notices action is called
add_action('admin_notices', 'ods_hello');

// We need some CSS to position the paragraph
function ods_admin_hello_css()
{
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

?>
	<style>
		#hello {
			float: <?php echo $x; ?>;
			padding-<?php echo $x; ?>: 12px;
			padding-top: 6px;
			margin: 0;
			font-size: 12px;
			height: 24px;
		}

		.block-editor-page #hello {
			display: none;
		}
	</style>
<?php

	// print_r (get_current_screen());
}

add_action('admin_head', 'ods_admin_hello_css');
