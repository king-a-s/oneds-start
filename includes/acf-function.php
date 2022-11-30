<?php

/**
 * Including ACF Plugin within a OneDS Strat plugin
 */

// Define path and URL to the ACF plugin.
define('ODS_ACF_PATH', plugin_dir_path(__FILE__) . 'acf/');
define('ODS_ACF_URL', plugin_dir_url(__FILE__) . 'acf/');

// Include the ACF plugin.
include_once(ODS_ACF_PATH . 'acf.php');

// Customize the url setting to fix incorrect asset URLs.
function ods_acf_settings_url($url)
{
    return ODS_ACF_URL;
}

add_filter('acf/settings/url', 'ods_acf_settings_url');

// (Optional) Hide the ACF admin menu item.
function ods_acf_settings_show_admin($show_admin)
{
    if (function_exists('ods_options_id')) {
        if (!empty(ods_options_id('Dashboard'))) {

            if (!get_post_meta(ods_options_id('Dashboard'), 'admin_acf_menu', true)) {
                return false;
            } else {
                return true;
            }
        }
    }
}

add_filter('acf/settings/show_admin', 'ods_acf_settings_show_admin');

// END PART



/**
 * Add new function to get field Values created with ACF, Named ods_get_meta_values.
 */

function ods_get_meta_values($key = '', $type = '', $status = 'publish')
{

    global $wpdb;

    if (empty($key))
        return;

    $r = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT pm.meta_value
        FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p
        ON pm.post_id = p.ID
        WHERE pm.meta_value > ''
        AND pm.meta_key = %s
        AND p.post_type = %s
        AND p.post_status = %s
        ", $key, $type, $status));

    return $r;
}

// END PART



/**
 * Add new function to get all field Values created with ACF, Named ods_get_meta_all_values.
 */

function ods_get_meta_all_values($key = '', $type = '', $status = 'publish')
{

    global $wpdb;

    if (empty($key))
        return;

    $r = $wpdb->get_col($wpdb->prepare("
        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p
        ON pm.post_id = p.ID
        WHERE pm.meta_value > ''
        AND pm.meta_key = %s
        AND p.post_type = %s
        AND p.post_status = %s
        ", $key, $type, $status));

    return $r;
}

// END PART



/**
 * Add new function to get all field Values created with ACF by post ids, Named ods_get_meta_all_values_by_ids.
 */

function ods_get_meta_all_values_by_ids($key = '', $ids = array(), $status = 'publish')
{
    global $wpdb;

    if (empty($key))
        return;

    $r = $wpdb->get_col($wpdb->prepare("
        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p
        ON pm.post_id = p.ID
        WHERE pm.meta_value > ''
        AND pm.meta_key = %s
        AND p.ID IN (" . implode(',', $ids) . ")
        AND p.post_status = %s
        ", $key, $status));

    return $r;
}

// END PART



/**
 * Add new function to get post id created with ACF by field Value
 */

function ods_get_post_id_by_field_key_and_value($key = '', $val = '', $type = '', $status = 'publish')
{

    global $wpdb;

    if ((!$key) || (!$val))
        return;

    $r = $wpdb->get_col($wpdb->prepare("
        SELECT p.ID
        FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p
        ON pm.post_id = p.ID
        WHERE pm.meta_key = %s
        AND pm.meta_value = %s
        AND p.post_type = %s
        AND p.post_status = %s
        ", $key, $val, $type, $status));

    return $r;
}

// END PART



/**
 * Add new function to get post id created with ACF by two fields Value
 */

function ods_get_post_id_by_two_fields_key_and_value($key = '', $val = '', $key2 = '', $val2 = '', $type = '', $status = 'publish')
{

    global $wpdb;

    if ((!$key) || (!$val) || (!$key2) || (!$val2))
        return;

    $r = $wpdb->get_col($wpdb->prepare("
        SELECT p.ID
        FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->postmeta} pm2 INNER JOIN {$wpdb->posts} p
        ON pm.post_id = p.ID
        AND pm2.post_id = p.ID
        WHERE pm.meta_key = %s
        AND pm.meta_value = %s
        AND pm2.meta_key = %s
        AND pm2.meta_value = %s
        AND p.post_type = %s
        AND p.post_status = %s
        ", $key, $val, $key2, $val2, $type, $status));

    return $r;
}

// END PART



/**
 * Google Maps API Key
 */

function ods_acf_google_map_api($api)
{

    $api['key'] = get_field('google_maps_api_key', ods_options_id('Dashboard'));

    return $api;
}

add_filter('acf/fields/google_map/api', 'ods_acf_google_map_api');

// END PART



/**
 * Some CSS for ACF in Admin
 */

function ods_acf_style()
{

?>
    <style>
        .acf-admin-toolbar a.btn-upgrade {
            display: none;
        }
    </style>
<?php

}

add_action('admin_head', 'ods_acf_style');

// END PART