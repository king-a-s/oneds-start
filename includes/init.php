<?php

/**
 * Add ACF Plugin to OneDS
 */

include_once(plugin_dir_path(__FILE__) . '/acf-function.php');

// END PART



/**
 * Add Options Pages module to OneDS
 */

include_once(plugin_dir_path(__FILE__) . '/oneds-options/oneds-options.php');

// END PART



/**
 * Add Dashboard Pages Class to OneDS
 */

include_once(plugin_dir_path(__FILE__) . '/class-ods-dashboard-page.php');

// END PART



/**
 * Add OneDS Admin Theme
 */

include_once(plugin_dir_path(__FILE__) . '/admin-theme-addon.php');
include_once(plugin_dir_path(__FILE__) . '/admin-color-scheme.php');

// END PART



/**
 * Add OneDS Maintenance Mode
 */

include_once(plugin_dir_path(__FILE__) . '/maintenance-mode-addon.php');

// END PART



/**
 * Add OneDS Admin Lyrix (Hello)
 */

include_once(plugin_dir_path(__FILE__) . '/admin-hello-addon.php');

// END PART



/**
 * Add a OneDS Widgets to Admin dashboard
 */

if (function_exists('ods_options_id')) {
  if (!empty(ods_options_id('Dashboard'))) {

    if (!get_post_meta(ods_options_id('Dashboard'), 'admin_dashboard_widgets', true)) {
      include_once(plugin_dir_path(__FILE__) . '/admin-dashboard-widgets-addon.php');
    }
  }
}

// END PART



/**
 * Add Language Switcher Plugin to OneDS
 */

if (function_exists('ods_options_id')) {
  if (!empty(ods_options_id('Dashboard'))) {

    if (!get_post_meta(ods_options_id('Dashboard'), 'admin_language_switcher', true)) {
      include_once(plugin_dir_path(__FILE__) . '/admin-language-switcher.php');
    }
  }
}

// END PART