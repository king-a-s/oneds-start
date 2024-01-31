<?php

if (function_exists('ods_options_id')) {
    if (!empty(ods_options_id('dashboard'))) {

        if (get_post_meta(ods_options_id('dashboard'), 'no_theme_switch', true) == false) {

            return;
        }
    }
}

/**
 * Redirect users to the admin dashboard
 */

function ods_no_theme_dashboard_redirect()
{
    wp_redirect(admin_url());
    exit();
}

add_action('template_redirect', 'ods_no_theme_dashboard_redirect');

// END PART


/**
 * Remove Appearance Menu from admin
 */

function ods_no_theme_remove_appearance_menu()
{
    remove_menu_page('themes.php');
}

add_action('admin_menu', 'ods_no_theme_remove_appearance_menu');

// END PART


/**
 * remove back to site in login page
 */

function ods_no_theme_login_back()
{
?>
    <style>
        .login #backtoblog a {
            display: none;
        }
    </style>

<?php
}

add_action('login_enqueue_scripts', 'ods_no_theme_login_back');

// END PART