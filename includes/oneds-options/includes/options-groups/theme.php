<?php

/**
 * Register Advanced Custom Fields in Options Page
 */

/**
 * Run code on the admin options pages
 */

function ods_acf_add_local_field_groups_theme()
{
    //change $post_id with ods_options_id('Theme') :

// Note
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_628c9f7676c5f',
        'title' => 'Message',
        'fields' => array(
            array(
                'key' => 'field_628c9f83c1263',
                'label' => 'Note',
                'name' => '',
                'type' => 'message',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => __('You can add fields by custom fields settings and set "Show this fields group if" post is equal to Theme Options Page, After that you can use it by get_field(\'your_field\', ods_options_id(\'Theme\'))', 'oneds-start'),
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post',
                    'operator' => '==',
                    'value' => ods_options_id('Theme'),
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'seamless',
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

add_action('acf/init', 'ods_acf_add_local_field_groups_theme');

// END PART