<?php

/**
 * Create Options Admin Pages
 */

include_once(plugin_dir_path(__FILE__) . '/options-cpt.php');

include_once(plugin_dir_path(__FILE__) . '/options-get-id.php');

include_once(plugin_dir_path(__FILE__) . '/options-types/dashboard.php');

include_once(plugin_dir_path(__FILE__) . '/options-types/theme.php');

include_once(plugin_dir_path(__FILE__) . '/options-groups/dashboard.php');

include_once(plugin_dir_path(__FILE__) . '/options-groups/theme.php');

// END PART



/**
 * Run code on the admin options pages
 */

function odsoptions_this_screen()
{
        acf_form_head();
}

add_action('current_screen', 'odsoptions_this_screen');

// END PART