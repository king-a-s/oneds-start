<?php

/**
 * Create new page (menu_page) for Reports in Admin Menu and (submenu_page)
 */

function ods_reports_admin_menu()
{
     // get all reports pages
     $parent = ods_options_id('reports');
     $reports = get_pages(array(
         'post_type' => 'optionspage',
         'parent' => $parent
     ));
 
     if (empty($reports)) {
         return 'hello adnan';
     }

    // main page
    add_menu_page(
        __('Reports', 'oneds-start'),
        __('Reports', 'oneds-start'),
        'manage_reports',
        'reports',
        '',
        'dashicons-clipboard',
        58
    );


    // submenu page to rename main page in submenu
    ods_add_options_page(
        __('Home', 'oneds-start'),
        'reports',
        0,
        'manage_reports',
        array(),
        'reports'
    );
}

add_action('admin_menu', 'ods_reports_admin_menu', 1);

// END PART


/**
 * Add a post display state for special page in the page list table.
 */

function ods_reports_add_display_post_states($post_states, $post)
{
    if (ods_options_id('reports') == $post->ID) {
        $post_states['options_page_for_reports'] = __('Reports Page', 'oneds-start');
    }

    return $post_states;
}

add_filter('display_post_states', 'ods_reports_add_display_post_states', 10, 2);

// END PART



/**
 * reports page
 */

function ods_reports_page_content()
{
    // check user capabilities
    if (!current_user_can('read')) {
        return;
    }
?>
    <style>
        #acf-form {
            display: none;
        }
    </style>
<?php
    // get all reports pages
    $parent = ods_options_id('reports');
    $reports = get_pages(array(
        'post_type' => 'optionspage',
        'parent' => $parent
    ));

    foreach ($reports as $report) {
        // get admin Menu Page Title by menu_slug
        $page_slug = $report->post_title;
        $menu_page = ods_get_submenu_page_title_by_menu_slug($page_slug);

        echo '<br>';
        echo '<a href="admin.php?page=' . $page_slug . '">' . $menu_page . '</a><br>';
        echo '<hr>';
    }
}

add_action('toplevel_page_reports', 'ods_reports_page_content', 100);

// END PART



/**
 * inclode reports functions
 */

include_once(plugin_dir_path(__FILE__) . '/reports-functions.php');

// END PART


function ods_reports_add_roles_caps_for_admin()
{
    // gets the simple_role role object
    $role = get_role('administrator');

    // add a new capability
    $role->add_cap('manage_reports');
}

// add simple_role capabilities, priority must be after the initial role definition
add_action('init', 'ods_reports_add_roles_caps_for_admin', 11);
