<?php

/**
 * Add the top level menu page and Register our options_page to the admin_menu action hook.
 */

function ods_mm_page()
{
    add_options_page(
        __('Maintenance Mode', 'oneds-start'), //page title
        __('Maintenance Mode', 'oneds-start'), //menu title
        'manage_options', //capability
        'maintenance-mode-options.php', //menu_slug
        'ods_mm_options_page_html' //function
    );
}

add_action('admin_menu', 'ods_mm_page');



/**
 * Top level menu callback function
 */

function ods_mm_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1> <?php _e('Maintenance Mode Settings', 'oneds-start'); ?> </h1>
        <form method="post" action="options.php">
            <?php settings_fields('odsmm'); ?>
            <?php do_settings_sections('odsmm'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"> <?php _e('Enabled', 'oneds-start'); ?> </th>
                    <td>
                        <input type="checkbox" name="odsmm-enabled" value="1" <?php checked(esc_attr(get_option('odsmm-enabled')), 1); ?>>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" colspan="2"> <?php _e('Content', 'oneds-start'); ?> </th>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php
                        $content = get_option('odsmm-content');
                        $editor_id = 'odsmm-content';
                        wp_editor($content, $editor_id);
                        ?>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}


function ods_mm_style()
{
?>
    <style>
        #wp-admin-bar-odsmm-indicator.Enabled {
            background-color: #f44;
            background-image: -webkit-gradient(linear, left bottom, left top, from(#d00), to(#f44));
            z-index: auto;
        }

        #wp-admin-bar-odsmm-indicator span.ab-label {
            color: #fff !important;
        }

        #wp-admin-bar-odsmm-indicator.Disabled {
            display: none !Important;
        }

        #wpadminbar #wp-admin-bar-odsmm-indicator .ab-icon:before {
            content: "\f308";
            top: 2px;
        }

        @media screen and (max-width: 782px) {
            #wpadminbar li#wp-admin-bar-odsmm-indicator {
                display: block
            }

            #wpadminbar #wp-admin-bar-odsmm-indicator>.ab-item {
                width: 50px;
                text-align: center
            }

            #wpadminbar #wp-admin-bar-odsmm-indicator>.ab-item .ab-icon:before {
                font: 32px/1 "dashicons";
                top: -1px
            }

            #wpadminbar #wp-admin-bar-odsmm-indicator>.ab-item img {
                margin: 19px 0
            }

            #wpadminbar #wp-admin-bar-odsmm-indicator #wp-admin-bar-all .ab-item .ab-icon {
                /* margin-$y: 6px; */
                font-size: 20px !important;
                line-height: 20px !important
            }
        }
    </style>
    <?php
}

add_action('admin_head', 'ods_mm_style');
add_action('wp_head', 'ods_mm_style');

function ods_mm_settings()
{
    register_setting('odsmm', 'odsmm-enabled');
    register_setting('odsmm', 'odsmm-content');
}

add_action('admin_init', 'ods_mm_settings');


function ods_mm_indicator($wp_admin_bar)
{
    $is_enabled = get_option('odsmm-enabled');
    if ($is_enabled) {
        $status = __('Enabled', 'oneds-start');
        $indicator = array(
            'id' => 'odsmm-indicator',
            'parent' => 'top-secondary',
            'title' => '<span class="ab-icon"></span>' . '<span class="ab-label">' . __('Maintenance Mode: ', 'oneds-start') . $status . '</span>',
            'href' => get_admin_url(null, 'options-general.php?page=maintenance-mode-options.php'),
            'meta' => array(
                'title' => __('Maintenance Mode Settings', 'oneds-start'),
                'class' => 'Enabled',
            )
        );
    }
    if (!$is_enabled) {
        $status = __('Disabled', 'oneds-start');
        $indicator = array(
            'id' => 'odsmm-indicator',
            'parent' => 'top-secondary',
            'title' => '<span class="ab-icon"></span>' . '<span class="ab-label">' . __('Maintenance Mode: ', 'oneds-start') . $status . '</span>',
            'href' => get_admin_url(null, 'options-general.php?page=maintenance-mode-options.php'),
            'meta' => array(
                'title' => __('Maintenance Mode Settings', 'oneds-start'),
                'class' => 'Disabled',
            )
        );
    }
    $wp_admin_bar->add_node($indicator);
}

add_action('admin_bar_menu', 'ods_mm_indicator', 100);


function ods_mm_maintenance()
{

    if (!(current_user_can('administrator') ||  current_user_can('super admin') || current_user_can('editor')) || (isset($_GET['odsmm']) && $_GET['odsmm'] !== 'preview')) {

        $default_content = __('<h1>Website Under Maintenance</h1><p>Our Website is currently undergoing scheduled maintenance. Please check back soon.</p>', 'oneds-start');
        $admin_content = get_option('odsmm-content');

        if (!empty($admin_content)) {

            $content =  $admin_content;

            // wp-content stylesheet
    ?>
            <style>
                @import url("wp-includes/js/tinymce/skins/wordpress/wp-content.css");
            </style>
<?php
        } else {
            $content = $default_content;
        }

        $content = apply_filters('the_content', $content);

        wp_die($content, __('Maintenance Mode', 'oneds-start'));
    }
}

$is_enabled = get_option('odsmm-enabled');
if ($is_enabled) {
    add_action('wp', 'ods_mm_maintenance');
}
