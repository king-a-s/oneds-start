<?php

/**
 * Register Custom Post Type options pages.
 */

function ods_options_post_type()
{

    $labels = array(
        'name'                  => _x('Options Pages', 'Post Type General Name', 'oneds-start'),
        'singular_name'         => _x('Options Page', 'Post Type Singular Name', 'oneds-start'),
        'menu_name'             => __('Options Pages', 'oneds-start'),
        'name_admin_bar'        => __('Options Page', 'oneds-start'),
        //'archives'              => __('Item Archives', 'oneds-start'),
        //'attributes'            => __('Item Attributes', 'oneds-start'),
        //'parent_item_colon'     => __('Parent Item:', 'oneds-start'),
        //'all_items'             => __('All options', 'oneds-start'),
        //'add_new_item'          => __('Add New optionsPage', 'oneds-start'),
        //'add_new'               => __('Add New', 'oneds-start'),
        //'new_item'              => __('New optionsPage', 'oneds-start'),
        //'edit_item'             => __('Edit optionsPage', 'oneds-start'),
        //'update_item'           => __('Update optionsPage', 'oneds-start'),
        //'view_item'             => __('View optionsPage', 'oneds-start'),
        //'view_items'            => __('View options', 'oneds-start'),
        //'search_items'          => __('Search optionsPage', 'oneds-start'),
        //'not_found'             => __('Not found', 'oneds-start'),
        //'not_found_in_trash'    => __('Not found in Trash', 'oneds-start'),
        //'featured_image'        => __('Featured Image'),
        //'set_featured_image'    => __('Set featured image'),
        //'remove_featured_image' => __('Remove featured image'),
        //'use_featured_image'    => __('Use as featured image'),
        //'insert_into_item'      => __('Insert into optionsPage', 'oneds-start'),
        //'uploaded_to_this_item' => __('Uploaded to this optionsPage', 'oneds-start'),
        //'items_list'            => __('options list', 'oneds-start'),
        //'items_list_navigation' => __('options list navigation', 'oneds-start'),
        //'filter_items_list'     => __('Filter options list', 'oneds-start'),
    );

    $args = array(
        'label'                 => __('Options Page', 'oneds-start'),
        'labels'                => $labels,
        'description'           => __('Options Pages', 'oneds-start'),
        'public'                => false,
        'hierarchical'          => true, //Default false.
        //'exclude_from_search'   => true, //Default is the opposite value of $public.
        //"publicly_queryable"    => false, //Default is inherited from $public.
        'show_ui'               => true, //Default is value of $public.
        //'show_in_menu'          => false, //Default is value of $show_ui.
        //'show_in_nav_menus'     => false, //Default is value of $public.
        'show_in_admin_bar'     => false, //Default is value of $show_in_menu.
        //'show_in_rest'          => true,
        //'rest_base'             => '', //Default is $post_type.
        //'rest_namespace'          => '', //Default is $post_type.
        //'rest_controller_class'   => '', //Default is $post_type.
        'menu_position'         => 82,
        'menu_icon'             => 'dashicons-admin-generic',
        'capability_type'       => 'page',
        //'capabilities'          => array(''),
        //'map_meta_cap'          => false, //Default false.
        'supports'              => array('title', 'page-attributes'), // 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields', and 'post-formats'
        //'register_meta_box_cb'  => //Default null.
        //'taxonomies'            => array(''),
        //'has_archive'           => false, //Default false.
        //'rewrite'               => array('slug' => 'oneds-start', 'with_front' => true),
        //'query_var'             => '',
        'can_export'            => true,
    );
    register_post_type('optionspage', $args);
}

add_action('init', 'ods_options_post_type', 0);

// END PART



/**
 * Add a post display state for special pages in the page list table.
 */

function ods_options_add_display_post_states($post_states, $post)
{
    if (ods_options_id('dashboard') == $post->ID) {
        $post_states['options_page_for_dashboard'] = __('Dashboard Settings Page', 'oneds-start');
    }

    return $post_states;
}

add_filter('display_post_states', 'ods_options_add_display_post_states', 10, 2);

// END PART



/**
 * remove menu page
 */

function ods_options_remove_menus()
{
    remove_menu_page('edit.php?post_type=optionspage');
}

add_action('admin_menu', 'ods_options_remove_menus');

// END PART