<?php

/**
 * Add Advanced Custom Fields Plugin to OneDS
 */

include_once(plugin_dir_path(__FILE__) . '/acf/acf-function.php');

// END PART



/**
 * Add OneDS Options Pages module to OneDS
 */

include_once(plugin_dir_path(__FILE__) . '/oneds-options/oneds-options.php');

// END PART



/**
 * Add OneDS Admin module to OneDS
 */

// Add Admin Theme functions
include_once(plugin_dir_path(__FILE__) . '/oneds-admin/admin-theme.php');

// Add Admin Color Schemes (OneDS Themes)
include_once(plugin_dir_path(__FILE__) . '/oneds-admin/admin-color-schemes.php');

// Add Admin Language Switcher
include_once(plugin_dir_path(__FILE__) . '/oneds-admin/admin-language-switcher.php');

// Add Admin Dashboard Widgets
include_once(plugin_dir_path(__FILE__) . '/oneds-admin/admin-dashboard-widgets.php');

// Add Admin Lyrix (Hello)
include_once(plugin_dir_path(__FILE__) . '/oneds-admin/admin-hello.php');

// Add Admin Welcome section
include_once(plugin_dir_path(__FILE__) . '/oneds-admin/admin-welcome.php');

// END PART



/**
 * Add OneDS Maintenance Mode
 */

include_once(plugin_dir_path(__FILE__) . 'oneds-maintenance-mode/maintenance-mode-page.php');
include_once(plugin_dir_path(__FILE__) . 'oneds-maintenance-mode/maintenance-mode-fields.php');

// END PART



/**
 * Add OneDS Reports Pages module to OneDS
 */

include_once(plugin_dir_path(__FILE__) . '/oneds-reports/reports.php');

// END PART



/**
 * Add OneDS No Theme Module to OneDS
 */

include_once(plugin_dir_path(__FILE__) . '/oneds-no-theme/no-theme.php');

// END PART