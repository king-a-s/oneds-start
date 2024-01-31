<?php

/**
 * add options page for Maintenance Mode.
 */

function ods_mm_options_page()
{
    ods_add_options_page(
        __('Maintenance Mode', 'oneds-start'),
        'maintenance_mode',
        0,
    );
}

add_action('admin_menu', 'ods_mm_options_page');

// END PART


/**
 * Add a post display state for special page in the page list table.
 */

function ods_mm_add_display_post_states($post_states, $post)
{
    if (ods_options_id('maintenance_mode') == $post->ID) {
        $post_states['options_page_for_maintenance_mode'] = __('Maintenance Mode Settings Page', 'oneds-start');
    }

    return $post_states;
}

add_filter('display_post_states', 'ods_mm_add_display_post_states', 10, 2);

// END PART



/**
 * Add maintenance mode indicator to admin bar
 */

function ods_mm_indicator($wp_admin_bar)
{
    $is_enabled = get_field('odsmm-enabled',  ods_options_id('maintenance_mode'));
    if ($is_enabled) {
        $status = __('Enabled', 'oneds-start');
        $indicator = array(
            'id' => 'odsmm-indicator',
            'parent' => 'top-secondary',
            'title' => '<span class="ab-icon"></span>' . '<span class="ab-label">' . __('Maintenance Mode: ', 'oneds-start') . $status . '</span>',
            'href' => get_admin_url(null, 'options-general.php?page=maintenance_mode'),
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
            'href' => get_admin_url(null, 'options-general.php?page=maintenance_mode'),
            'meta' => array(
                'title' => __('Maintenance Mode Settings', 'oneds-start'),
                'class' => 'Disabled',
            )
        );
    }
    $wp_admin_bar->add_node($indicator);
}

add_action('admin_bar_menu', 'ods_mm_indicator', 100);

// END PART



/**
 * Add custom css to admin bar for maintenance mode indicator
 */

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

// END PART



/**
 * Maintenance Mode Function
 */

function ods_mm_function()
{
    $is_enabled = get_field('odsmm-enabled',  ods_options_id('maintenance_mode'));

    if (!$is_enabled || isset($_GET['maintenance-mode_out'])) {
        return;
    }

    // if current user not admin or super admin or editor and not secret preview
    if (!current_user_can('administrator') && !current_user_can('editor') && !current_user_can('super_admin') || isset($_GET['maintenance-mode_preview'])) {

        $default_content = __('<h1>System Under Maintenance</h1><p>Our System is currently undergoing scheduled maintenance. Please check back soon.</p>', 'oneds-start');
        $custom_content = get_field('odsmm-content',  ods_options_id('maintenance_mode'));
        $background_color = get_field('odsmm-background-color',  ods_options_id('maintenance_mode'));
        $full_screen = get_field('odsmm-full-screen',  ods_options_id('maintenance_mode'));
        $custom_css = get_field('odsmm-custom-css',  ods_options_id('maintenance_mode'));
        $custom_js = get_field('odsmm-custom-js',  ods_options_id('maintenance_mode'));


        if (!empty($custom_content)) {

            $content =  $custom_content;

    ?>
            <style>
                @import url("wp-includes/js/tinymce/skins/wordpress/wp-content.css");
            </style>

            <?php

            if ($custom_css) {
                echo '<style>' . $custom_css . '</style>';
            }

            if ($custom_js) {
                echo '<script>' . $custom_js . '</script>';
            }
        } else {
            $content = $default_content;
        }

        if ($background_color) {
            ?>
            <style>
                body {
                    background: <?php echo $background_color; ?> !important;
                    height: fit-content;
                }
            </style>
        <?php
        }

        if ($full_screen) {
        ?>
            <style>
                #error-page {
                    margin: 0 !important;
                    max-width: 100%;
                    border: none;
                }

                #error-page p,
                #error-page .wp-die-message {
                    margin: 0 !important;
                }

                body {
                    margin: 10px;
                    max-width: 100%;
                    border: none;
                    height: auto;
                }
            </style>

<?php
        }

        $content = apply_filters('the_content', $content);

        wp_die($content, __('Maintenance Mode', 'oneds-start'));
    }
}

add_action('template_redirect', 'ods_mm_function');

// END PART