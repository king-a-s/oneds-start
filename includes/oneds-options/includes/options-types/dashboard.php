<?php

/**
 * Add the top level menu page and Register our options_page to the admin_menu action hook.
 */

function odsoptions_dashboard_page()
{
    add_options_page(
        __('Dashboard Options', 'oneds-start'), //page title
        __('Dashboard Options', 'oneds-start'), //menu title
        'manage_options', //capability
        'dashboard-options.php', //menu_slug
        'odsoptions_dashboard_options_page_html' //function
    );

    global $wpdb;
    $lastrowId = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type='optionspage' AND post_title = 'Dashboard' ORDER BY post_date DESC ");

    if (!isset($lastrowId[0])) {
        // Gather post data.
        $my_post = array(
            'post_type'     => 'optionspage',
            'post_status'   => 'publish',
            'post_title'   => 'Dashboard',
            'meta_input' => array(
                'dashboard_layout' => 'oneds'
            )
        );

        // Insert the post into the database.
        wp_insert_post($my_post);
    }
}

add_action('admin_menu', 'odsoptions_dashboard_page');



/**
 * Top level menu callback function
 */

function odsoptions_dashboard_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1> <?php _e('Dashboard Options', 'oneds-start'); ?> </h1>
        <?php
        //print_r(get_current_screen());

        global $wpdb;
        $lastrowId = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type='optionspage' AND post_title = 'Dashboard' ORDER BY post_date DESC ");

        if (isset($lastrowId[0])) {
            $lastPropertyId = $lastrowId[0];
            $options_post_id = $lastPropertyId;
            $postarray = null;
        } else {
            $options_post_id = 'new_post';
            $postarray = array(
                'post_type'     => 'optionspage',
                'post_status'   => 'publish',
                'post_title'   => 'Dashboard',
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

    <script>
        const element = document.getElementById("acf-field_629342264b49e");
        element.addEventListener("input", myFunction);

        function myFunction() {
            var x = document.getElementById("acf-field_629342264b49e").value;
            document.getElementById("wp-admin-bar-oneds_title").getElementsByClassName("ab-item")[0].innerHTML = x;
        }
    </script>

<?php
}
