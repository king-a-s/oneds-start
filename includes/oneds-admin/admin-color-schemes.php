<?php

/**
 * Add Dark Color scheme
 */

function ods_dark_admin_color_scheme()
{

  $suffix  = is_rtl() ? '-rtl' : '';
  //$suffix .= SCRIPT_DEBUG ? '' : '.min';

  //Dark
  wp_admin_css_color(
    'oneds_dark',
    __('Dark'),
    plugins_url("../../assets/css/color-schema/dark/colors$suffix.css", __FILE__),
    array('#1d2327', '#2c3338', '#2271b1', '#72aee6', '#0c0e10')
  );
}

add_action('admin_init', 'ods_dark_admin_color_scheme');

// END PART



/**
 * Add Metronic (OneDS) Color scheme
 */

function ods_metronic_admin_color_scheme()
{

  $layout = get_field('dashboard_layout', ods_options_id('dashboard'));
  if ($layout == 'oneds') {

    $suffix  = is_rtl() ? '-rtl' : '';
    //$suffix .= SCRIPT_DEBUG ? '' : '.min';

    //Metronic
    wp_admin_css_color(
      'oneds_metronic',
      __('Metronic'),
      plugins_url("../../assets/css/color-schema/metronic/colors$suffix.css", __FILE__),
      array('#1e1e2d', '#2c3338', '#2271b1', '#72aee6', '#f1f3f6')
    );
  }
}

add_action('admin_init', 'ods_metronic_admin_color_scheme');

// END PART



/**
 * Add calc (OneDS Pro) Color scheme
 */

function ods_calc_admin_color_scheme()
{

  $layout = get_field('dashboard_layout', ods_options_id('dashboard'));
  if ($layout == 'oneds_pro') {

    $suffix  = is_rtl() ? '-rtl' : '';
    //$suffix .= SCRIPT_DEBUG ? '' : '.min';

    //Metronic
    wp_admin_css_color(
      'oneds_calc',
      __('Calc'),
      plugins_url("../../assets/css/color-schema/calc/colors$suffix.css", __FILE__),
      array('#1e1e2d', '#2c3338', '#2271b1', '#72aee6', '#f1f3f6')
    );
  }
}

add_action('admin_init', 'ods_calc_admin_color_scheme');

// END PART



/**
 * Add calc Dark (OneDS Pro Dark) Color scheme
 */

function ods_calc_dark_admin_color_scheme()
{

  $layout = get_field('dashboard_layout', ods_options_id('dashboard'));
  if ($layout == 'oneds_pro_dark') {

    $suffix  = is_rtl() ? '-rtl' : '';
    //$suffix .= SCRIPT_DEBUG ? '' : '.min';

    //Metronic
    wp_admin_css_color(
      'oneds_calc_dark',
      __('Calc Dark'),
      plugins_url("../../assets/css/color-schema/calc-dark/colors$suffix.css", __FILE__),
      array('#1e1e2d', '#2c3338', '#2271b1', '#72aee6', '#f1f3f6')
    );
  }
}

add_action('admin_init', 'ods_calc_dark_admin_color_scheme');

// END PART



/**
 * Add Mizan (Orange Balance) Color scheme
 */

function ods_mizan_admin_color_scheme()
{

  if (get_field('dashboard_layout', ods_options_id('dashboard')) == 'mizan') :

    $suffix  = is_rtl() ? '-rtl' : '';
    //$suffix .= SCRIPT_DEBUG ? '' : '.min';

    //Mizan
    wp_admin_css_color(
      'oneds_mizan',
      __('Mizan'),
      plugins_url("../../assets/css/color-schema/mizan/colors$suffix.css", __FILE__),
      array('#1e1e2d', '#2c3338', '#2271b1', '#72aee6', '#f1f3f6')
    );


    function custom_admin_js()
    {
      echo "<script> 

      document.body.classList.remove('folded');
      document.body.classList.remove('auto-fold');
  
    </script>";

      echo '<style>
    #collapse-menu {
      display: none !important;
    }
    </style>';
    }
    add_action('admin_notices', 'custom_admin_js');

  endif;
}

add_action('admin_init', 'ods_mizan_admin_color_scheme');

// END PART