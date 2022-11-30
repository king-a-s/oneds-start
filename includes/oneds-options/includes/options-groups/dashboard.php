<?php

/**
 * Register Advanced Custom Fields in Options Page
 */

/**
 * Run code on the admin options pages
 */

function ods_acf_add_local_field_groups_dashboard()
{
    //change $post_id with ods_options_id('Dashboard')

    // fields
    if (function_exists('acf_add_local_field_group')) :

        acf_add_local_field_group(array(
            'key' => 'group_629342264835f',
            'title' => __('Dashboard Settings Fields', 'oneds-start'),
            'fields' => array(
                array(
                    'key' => 'field_629557806d1b7',
                    'label' => __('Layout', 'oneds-start'),
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'top',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_629342264ef20',
                    'label' => __('Dashboard Layout', 'oneds-start'),
                    'name' => 'dashboard_layout',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        'classic' => __('Classic Layout', 'oneds-start'),
                        'wide' => __('Wide Layout', 'oneds-start'),
                        'oneds' => __('OneDS Theme', 'oneds-start'),
                        'oneds_pro' => __('OneDS Pro Theme', 'oneds-start'),
                        'oneds_pro_dark' => __('OneDS Pro Dark Theme', 'oneds-start'),
                        'mizan' => __('Orange Balance', 'oneds-start'),
                    ),
                    'default_value' => 'oneds',
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 1,
                    'ajax' => 0,
                    'return_format' => 'value',
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_629342264b49e',
                    'label' => __('Dashboard Label', 'oneds-start'),
                    'name' => 'dashboard_label',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_629342264ef20',
                                'operator' => '==',
                                'value' => 'oneds',
                            ),
                        ),
                        array(
                            array(
                                'field' => 'field_629342264ef20',
                                'operator' => '==',
                                'value' => 'oneds_pro',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_6298bc6eccb8d',
                    'label' => __('Dashboard Label Icon', 'oneds-start'),
                    'name' => 'dashboard_label_icon',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_629342264ef20',
                                'operator' => '==',
                                'value' => 'oneds',
                            ),
                        ),
                        array(
                            array(
                                'field' => 'field_629342264ef20',
                                'operator' => '==',
                                'value' => 'oneds_pro',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'url',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_6295581775fa1',
                    'label' => __('Addons', 'oneds-start'),
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'top',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_6295586375fa2',
                    'label' => __('Disable Admin Language Switcher', 'oneds-start'),
                    'name' => 'admin_language_switcher',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => '',
                    'default_value' => 0,
                    'ui' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),
                array(
                    'key' => 'field_629559d71165a',
                    'label' => __('Disable Admin Dashboard Widgets', 'oneds-start'),
                    'name' => 'admin_dashboard_widgets',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => '',
                    'default_value' => 0,
                    'ui' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),
                array(
                    'key' => 'field_admin_acf_menu',
                    'label' => __('Enable ACF Menu', 'oneds-start'),
                    'name' => 'admin_acf_menu',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'message' => '',
                    'default_value' => 0,
                    'ui' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),
                array(
                    'key' => 'field_629568a98e7fd',
                    'label' => __('Hello', 'oneds-start'),
                    'name' => 'hello',
                    'type' => 'textarea',
                    'instructions' => __('Put each sentence on a separate line', 'oneds-start'),
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
                ),
                array(
                    'key' => 'field_62955f6d4b172',
                    'label' => __('API Keys', 'oneds-start'),
                    'name' => '',
                    'type' => 'tab',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'placement' => 'top',
                    'endpoint' => 0,
                ),
                array(
                    'key' => 'field_62955f964b173',
                    'label' => __('Google Maps API Key', 'oneds-start'),
                    'name' => 'google_maps_api_key',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post',
                        'operator' => '==',
                        'value' => ods_options_id('Dashboard'),
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => array(
                0 => 'permalink',
                1 => 'the_content',
                2 => 'excerpt',
                3 => 'discussion',
                4 => 'comments',
                5 => 'revisions',
                6 => 'slug',
                7 => 'author',
                8 => 'format',
                9 => 'page_attributes',
                10 => 'featured_image',
                11 => 'categories',
                12 => 'tags',
                13 => 'send-trackbacks',
            ),
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));

    endif;
}

add_action('acf/init', 'ods_acf_add_local_field_groups_dashboard');

// END PART