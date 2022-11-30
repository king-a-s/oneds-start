<?php

/**
 * Add the top level menu page and Register our options_page to the admin_menu action hook.
 */

function odsoptions_theme_page()
{
    add_options_page(
        __('Theme Options', 'oneds-start'), //page title
        __('Theme Options', 'oneds-start'), //menu title
        'manage_options', //capability
        'theme-options.php', //menu_slug
        'odsoptions_theme_options_page_html' //function
    );

    global $wpdb;
    $lastrowId = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type='optionspage' AND post_title = 'Theme' ORDER BY post_date DESC ");

    if (!isset($lastrowId[0])) {
        // Gather post data.
        $my_post = array(
            'post_type'     => 'optionspage',
            'post_status'   => 'publish',
            'post_title'   => 'Theme'
        );

        // Insert the post into the database.
        wp_insert_post($my_post);
    }
}

add_action('admin_menu', 'odsoptions_theme_page');



/**
 * Top level menu callback function
 */

function odsoptions_theme_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1> <?php _e('Theme Options', 'oneds-start'); ?> </h1>
        <?php
        //print_r(get_current_screen());

        global $wpdb;
        $lastrowId = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type='optionspage' AND post_title = 'Theme' ORDER BY post_date DESC ");

        if (isset($lastrowId[0])) {
            $lastPropertyId = $lastrowId[0];
            $options_post_id = $lastPropertyId;
            $postarray = null;
        } else {
            $options_post_id = 'new_post';
            $postarray = array(
                'post_type'     => 'optionspage',
                'post_status'   => 'publish',
                'post_title'   => 'Theme',
            );
        }

        acf_form(array(
            'post_id'       => $options_post_id,
            'new_post'      => $postarray,
            'submit_value'  => __('Save'),
            'updated_message' => __("Options Updated", 'oneds-start')
        ));
        
        ?>
    </div>
<?php
}