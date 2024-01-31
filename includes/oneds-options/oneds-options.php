<?php

/**
 * Check if OneDS Start Package is active and continue.
 */

function ods_options_oneds_not_loaded()
{
    printf('<div class="error"><p>%s</p></div>', __('Sorry (OneDS options Plugin) requires (OneDS Start Plugin) to load', 'oneds-start'));
}

if (in_array('oneds-start/oneds-start.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    include_once(plugin_dir_path(__FILE__) . '/includes/init.php');
} else {

    add_action('admin_notices', 'ods_options_oneds_not_loaded');
}

// END PART