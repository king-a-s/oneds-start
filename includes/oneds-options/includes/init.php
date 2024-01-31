<?php

/**
 * Create Options Admin Pages
 */

include_once(plugin_dir_path(__FILE__) . '/options-cpt.php'); // Create Options CPT

include_once(plugin_dir_path(__FILE__) . '/options-functions.php'); // Get Options ID Function

include_once(plugin_dir_path(__FILE__) . '/options-pages/dashboard.php'); // Create Dashboard Options Page

include_once(plugin_dir_path(__FILE__) . '/options-fields/dashboard.php'); // Create Dashboard Options Group (Fields)

// END PART



/**
 * Run options form code on the admin options pages
 */

function ods_options_this_screen($current_screen)
{

        // if current screen is options page
        if ($current_screen->parent_base == 'optionspage') {

                acf_form_head();

                // echo '<pre>';
                // var_dump($current_screen);
                // echo '</pre>';
        }
}

add_action('current_screen', 'ods_options_this_screen');

// END PART