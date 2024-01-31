<?php

/**
 * Register function to add new report page
 */

function ods_add_report_page($page_name, $page_slug, $page_parent = 0, $capability = 'manage_reports', $meta_input = array(), $parent_slug = 'reports')
{
    if ($page_parent == 0) {
        $page_parent = ods_options_id('reports');
    } else {
        $parent_slug = get_the_title($page_parent);
    }
    return ods_add_options_page($page_name, $page_slug . '_report', $page_parent, $capability, $meta_input, $parent_slug);
}

// END PART
