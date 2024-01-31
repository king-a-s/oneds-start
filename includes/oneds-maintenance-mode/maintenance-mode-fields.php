<?php

/**
 * Register Advanced Custom Fields in Options Page
 */

/**
 * Run code on the admin options pages
 */

function ods_mm_options_acf_add_local_field_groups()
{
    //change $post_id with  ods_options_id('maintenance_mode') :

    /**
     * Some queries and codes to use them later
     */



    //END PART



    /**
     * Create Simple ACF Fields
     */


    //add new group for maintenance-mode settings fields
    acf_add_local_field_group(array(
        'key' => 'group_maintenance_mode_settings',
        'title' => __('Maintenance Mode Settings', 'oneds-start'),
        'location' => array(
            array(
                array(
                    'param' => 'post',
                    'operator' => '==',
                    'value' =>  ods_options_id('maintenance_mode'),
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'the_content',
            1 => 'excerpt',
            2 => 'discussion',
            3 => 'comments',
            4 => 'revisions',
            5 => 'slug',
            6 => 'author',
            7 => 'format',
            8 => 'page_attributes',
            9 => 'tags',
            10 => 'send-trackbacks',
        ),
        'active' => true,
        'description' => '',
    ));

    //add new field for enabled
    acf_add_local_field(array(
        'parent' => 'group_maintenance_mode_settings',
        'key' => 'field_maintenance_mode_enabled',
        'label' => __('Enabled', 'oneds-start'),
        'name' => 'odsmm-enabled',
        'type' => 'true_false',
        'instructions' => __('Enable the maintenance mode.', 'oneds-start'),
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'default_value' => 0,
        'ui' => 1,
        'ui_on_text' => '',
        'ui_off_text' => '',
    ));

    //add new field for html content (enable full html)
    acf_add_local_field(array(
        'parent' => 'group_maintenance_mode_settings',
        'key' => 'field_maintenance_mode_content',
        'label' => __('Content', 'oneds-start'),
        'name' => 'odsmm-content',
        'aria-label' => '',
        'type' => 'wysiwyg',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'basic',
        'media_upload' => 1,
        'delay' => 0,
    ));


    //add new field for background color
    acf_add_local_field(array(
        'parent' => 'group_maintenance_mode_settings',
        'key' => 'field_maintenance_mode_background_color',
        'label' => __('Background Color', 'oneds-start'),
        'name' => 'odsmm-background-color',
        'type' => 'color_picker',
        'instructions' => __('Select the background color.', 'oneds-start'),
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '50',
            'class' => '',
            'id' => '',
        ),
        'default_value' => '',
    ));

    //add new field for full screen mode
    acf_add_local_field(array(
        'parent' => 'group_maintenance_mode_settings',
        'key' => 'field_maintenance_mode_full_screen',
        'label' => __('Full Screen', 'oneds-start'),
        'name' => 'odsmm-full-screen',
        'type' => 'true_false',
        'instructions' => __('Enable full screen mode.', 'oneds-start'),
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '50',
            'class' => '',
            'id' => '',
        ),
        'default_value' => 0,
        'ui' => 1,
        'ui_on_text' => '',
        'ui_off_text' => '',
    ));

    //add new field for custom css
    acf_add_local_field(array(
        'parent' => 'group_maintenance_mode_settings',
        'key' => 'field_maintenance_mode_custom_css',
        'label' => __('Custom CSS', 'oneds-start'),
        'name' => 'odsmm-custom-css',
        'type' => 'textarea',
        'instructions' => __('Enter the custom CSS.', 'oneds-start'),
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => '',
        'new_lines' => '',
    ));

    //add new field for custom js
    acf_add_local_field(array(
        'parent' => 'group_maintenance_mode_settings',
        'key' => 'field_maintenance_mode_custom_js',
        'label' => __('Custom JS', 'oneds-start'),
        'name' => 'odsmm-custom-js',
        'type' => 'textarea',
        'instructions' => __('Enter the custom JS.', 'oneds-start'),
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => '',
        'new_lines' => '',
    ));

    //END PART
}

add_action('acf/init', 'ods_mm_options_acf_add_local_field_groups');

// END PART


/**
 * Enable HTML in ACF field (wysiwyg)
 */

function ods_mm_acf_wysiwyg_html($value, $post_id, $field)
{
    return $value;
}

add_filter('acf/format_value/type=wysiwyg', 'ods_mm_acf_wysiwyg_html', 10, 3);

// END PART
