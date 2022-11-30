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