<?php

/**
 * Add OneDS Admin Theme
 */


/*
 * Set (OneDS Option) the default color for all user and remove other colors
 */

function ods_update_user_option_admin_color($color_scheme)
{
    if (get_field('dashboard_layout', ods_options_id('Dashboard')) == 'oneds') {
        remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
        $color_scheme = 'metronic';
    }

    if (get_field('dashboard_layout', ods_options_id('Dashboard')) == 'oneds_pro') {
        remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
        $color_scheme = 'calc';
    }

    if (get_field('dashboard_layout', ods_options_id('Dashboard')) == 'oneds_pro_dark') {
        remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
        $color_scheme = 'calc_dark';
    }

    if (get_field('dashboard_layout', ods_options_id('Dashboard')) == 'mizan') {
        remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
        $color_scheme = 'mizan';
    }

    return $color_scheme;
}
add_filter('get_user_option_admin_color', 'ods_update_user_option_admin_color', 5);

// END PART



/**
 * Move the 'Collapse menu' item to the top of the admin menu if OneDS Theme applied
 */

function ods_move_collapse_menu()
{

    $current_color = get_user_option('admin_color');
    if (($current_color == 'metronic') || ($current_color == 'calc') || ($current_color == 'calc_dark')) :
?>
        <script>
            if (jQuery('#collapse-menu').length) {
                jQuery('#collapse-menu').prependTo('#wp-admin-bar-oneds_collapse_button');
            }
        </script>

        <style>
            .collapse-button-label {
                display: none !important;
            }
        </style>

    <?php
    endif;
}
add_action('wp_after_admin_bar_render', 'ods_move_collapse_menu');

// END PART


/*
 * Add OneDS Toolbar Link For Dashboard Label
 */

function ods_toolbar_link($wp_admin_bar)
{

    if (is_admin()) :
        $current_color = get_user_option('admin_color');
        if (($current_color != 'metronic') && ($current_color != 'calc') && ($current_color != 'calc_dark')) {
            return;
        }

        //link

        $lable = __('OneDS', 'oneds-start');

        if (get_field('dashboard_label', ods_options_id('Dashboard'))) {
            $lable = get_field('dashboard_label', ods_options_id('Dashboard'));
        }

        $wp_admin_bar->add_node(array(
            'id'    => 'oneds_title',
            'title' => $lable,
            'href'  => home_url() . '/wp-admin',
            'meta'  => array('class' => 'oneds_title_oneds',)
        ));

        $wp_admin_bar->add_node(array(
            'id'    => 'oneds_collapse_button'
        ));

        $lableIcon = '';
        if (get_field('dashboard_label_icon', ods_options_id('Dashboard'))) {
            $lableIcon = get_field('dashboard_label_icon', ods_options_id('Dashboard'));
        }

    ?>
        <style>
            #wp-admin-bar-oneds_title ::after {
                background: url('<?php echo $lableIcon; ?>');
            }
        </style>

    <?php

    //sublink
    /*$wp_admin_bar->add_node(array(
		    'id'    => 'title_link',
		    'title' => __('title', 'oneds-start'),
		    'href'  => '#',
		    'parent' => 'oneds_collapse_button',
		    'meta'  => array( 'target' => '_blank',)
	    ) );*/

    endif;
}

add_action('admin_bar_menu', 'ods_toolbar_link', 0);

// END PART



/*
 * Add some CSS if Wide Layout applied
 */

function ods_wide_dash_css()
{
    if (get_field('dashboard_layout', ods_options_id('Dashboard')) != 'wide') {
        return;
    }

    // This makes sure that the positioning is also good for right-to-left languages
    $x = is_rtl() ? 'right' : 'left';

    echo "
    
    <style>
        html {
            scroll-behavior: smooth;
        }

        #wpadminbar .quicklinks li#wp-admin-bar-my-account.with-avatar>a img {
            width: 24px;
            height: 24px;
            border-radius: 50%
        }

        #wpadminbar ul#wp-admin-bar-root-default>li#wp-admin-bar-wp-logo {
            display: none
        }

        .postbox {
            border-radius: 5px;
        }

        #screen-meta-links .show-settings {
            border-bottom-right-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        @media only screen and (max-width: 782px) {
            #wpbody-content {
                margin-top: 0px;
            }
        }

        @media screen and (min-width: 782px) {

            #wpadminbar {
                height: 46px !important;
            }

            html.wp-toolbar {
                padding-top: 46px !important;
            }

            .admin-bar.masthead-fixed .site-header {
                top: 46px !important;
            }

            #wp-admin-bar-oneds_title.oneds_title_oneds>.ab-item {
                vertical-align: middle;
                height: auto;
                font-size: 20px;
                padding-bottom: 6px;
            }

            li#wp-admin-bar-oneds_title.oneds_title_oneds {
                width: 150px;
            }

            #wp-admin-bar-oneds_collapse_button,
            li#wp-admin-bar-oneds_title {
                height: 32px;
            }

            #wpadminbar #wp-admin-bar-oneds_collapse_button>.ab-item {
                width: 21px;
                text-align: center;
                padding-bottom: 6px;
            }

            #wpadminbar ul li {
                padding: 7px 4px
            }

            #adminmenu,
            #adminmenu .wp-submenu,
            #adminmenuback,
            #adminmenuwrap {
                width: 210px
            }

            #adminmenu .wp-submenu {
                $x: 210px
            }

            #adminmenu .wp-has-current-submenu ul>li>a {
                padding-$x: 34px
            }

            ul#adminmenu a.wp-has-current-submenu:after,
            ul#adminmenu>li.current>a.current:after,
            #adminmenu li.wp-has-submenu.wp-not-current-submenu.opensub:hover:after {
                display: none
            }

            #adminmenu .wp-submenu-head,
            #adminmenu a.menu-top {
                padding: 7px 0;
            }

            .folded #adminmenu .wp-submenu-head,
            .folded #adminmenu a.menu-top {
                padding: 7px 0;
            }

            #adminmenu .wp-not-current-submenu .wp-submenu,
            .folded #adminmenu .wp-has-current-submenu .wp-submenu {
                padding: 10px;
            }

            #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head {
                background: none;
            }

            #wpcontent,
            #wpfooter {
                margin-$x: 210px
            }

            #wp-admin-bar-site-name-default {
                display: none !important
            }

            #adminmenu div.wp-menu-image {
                width: 50px;
            }

            .folded #adminmenu,
            .folded #adminmenu li.menu-top,
            .folded #adminmenuback,
            .folded #adminmenuwrap {
                width: 50px;
            }

            .folded #wpcontent,
            .folded #wpfooter {
                margin-$x: 50px;
            }

            .folded #adminmenu div.wp-menu-image {
                width: 50px;
            }

            .folded .wp-submenu {
                top: 0;
                $x: 50px !important;
            }

            .dashicons,
            .dashicons-before:before {
                width: 22px;
                height: 22px;
                font-size: 22px;
            }

            .edit-post-header {
                $x: 210px;
                top: 46px;
            }

            .has-fixed-toolbar .edit-post-layout__content {
                top: 102px;
            }

            .edit-post-layout__content {
                margin-$x: 210px;
            }

            .edit-post-sidebar {
                top: 102px;
            }

            .edit-post-layout .editor-post-publish-panel {
                top: 46px;
            }

            body.auto-fold .edit-post-layout__content {
                margin-$x: 210px;
            }

        }

        li#wp-admin-bar-oneds_title {
            height: 46px;
        }

        li#wp-admin-bar-oneds_collapse_button {
            height: 46px;
            width: 60px;
        }

        .woocommerce-layout__header {
            top: 46px;
        }

        #collapse-button .collapse-button-icon {
            width: 50px;
        }

        #collapse-button .collapse-button-label {
            padding-$x: 50px;
        }

        .auto-fold .interface-interface-skeleton {
            $x: 210px;
        }

        .interface-interface-skeleton {
            top: 46px;
        }

        #collapse-button .collapse-button-label {
            display: unset;
            width: max-content;
        }

        li#wp-admin-bar-comments {
            display: none;
        }
    </style>
    
    ";
}

add_action('admin_head', 'ods_wide_dash_css');
//add_action('wp_head', 'ods_wide_dash_css');

function ods_front_admin_bar_style()
{
    if (is_admin_bar_showing()) {
    ?>
        <style type="text/css" media="screen">
            html {
                margin-top: 50px !important;
            }

            * html body {
                margin-top: 50px !important;
            }
        </style>
    <?php }
}
//add_theme_support('admin-bar', array('callback' => 'ods_front_admin_bar_style'));


/**
 * Add OneDS footer
 */

function ods_admin_footer_text()
{
    echo __('Powered By', 'oneds-start') . ' ';
    echo '<a href="http://www.wordpress.org">' . __('WordPress') . '</a> ';
    echo __('&', 'oneds-start');
    echo ' <a href="http://www.oneds.org">' . __('OneDS', 'oneds-start') . '</a>';
}

add_filter('admin_footer_text', 'ods_admin_footer_text');


function ods_admin_footer_date_time()
{
    echo '' . date_i18n('l, d/m/Y', current_time('timestamp', 1));
    ?>
    <script type="text/javascript">
        function GetClock() {
            var d = new Date();
            var nday = d.getDay(),
                nmonth = d.getMonth(),
                ndate = d.getDate(),
                nyear = d.getYear();
            if (nyear < 1000) nyear += 1900;
            var d = new Date();
            var nhour = d.getHours(),
                nmin = d.getMinutes(),
                nsec = d.getSeconds(),
                ap;

            if (nhour == 0) {
                ap = " AM";
                nhour = 12;
            } else if (nhour < 12) {
                ap = " AM";
            } else if (nhour == 12) {
                ap = " PM";
            } else if (nhour > 12) {
                ap = " PM";
                nhour -= 12;
            }

            if (nmin <= 9) nmin = "0" + nmin;
            if (nsec <= 9) nsec = "0" + nsec;

            document.getElementById("clockbox").innerHTML = " | " + nhour + ":" + nmin + ":" + nsec + "";
        }

        window.onload = function() {
            GetClock();
            setInterval(GetClock, 1000);
        }
    </script>
    <span id="clockbox"></span>

<?php
    echo '' . date_i18n('a', current_time('timestamp', 1));
}

add_filter('update_footer', 'ods_admin_footer_date_time');

function ods_admin_footer_filter()
{
    remove_filter('update_footer', 'core_update_footer');
}

add_action('admin_menu', 'ods_admin_footer_filter');

// END PART



/**
 * Add OneDS Version in at a galance admin widget
 */

function ods_update_right_now_message($content)
{
    $oneds_plugin_data = get_plugin_data(plugin_dir_path(__FILE__) . '../oneds-start.php');
    $oneds_plugin_version = $oneds_plugin_data['Version'];
    $ods_content = '<p id="oneds-version-message"><span id="oneds-version">' . __('OneDS', 'oneds-start') . ' ' . $oneds_plugin_version;
    $ods_plugins = '';
    $ods_plugins = apply_filters('ods_update_running_modules', $ods_plugins);
    $ods_msg = $ods_content . '.' /*. __('running this modules:') */ . ' ' . $ods_plugins . '</span></p>';

    return $content . $ods_msg;
}

add_filter('update_right_now_text', 'ods_update_right_now_message');


/*function ods_test_running_modules($ods_plugins) {

    $content = 'Contacts';

    $ods_plugins = $ods_plugins . ' ,' . $content;

    return $ods_plugins;

}

add_filter( 'ods_update_running_modules', 'ods_test_running_modules' );

function ods_test2_running_modules($ods_plugins) {

    $content = 'Accounting';

    $ods_plugins = $ods_plugins . ' ,' . $content;

    return $ods_plugins;

}

add_filter( 'ods_update_running_modules', 'ods_test2_running_modules' );*/

// END PART



/**
 * Add a custom Welcome Dashboard Panel
 */

function ods_welcome_panel()
{
?>
    <div class="top-welcome-panel-content">
    </div>

    <style>
        .wrap>h1:first-child {
            /* color: transparent; */
            display: none;
        }

        .welcome-panel {
            border: 0;
            box-shadow: none;
            background: none;
            /* margin-top: -22px;
            padding-top: 0px; */
        }

        .welcome-panel .welcome-panel-close {
            display: none;
        }

        .welcome-panel::before {
            display: none;
            background: none;
            height: unset;
        }
    </style>
<?php
}

//remove_action('welcome_panel', 'wp_welcome_panel');
//add_action('welcome_panel', 'ods_welcome_panel', 1);

// END PART



/**
 * Change Login Logo Based on Site Custom Logo
 */

function ods_login_logo()
{

    $lableIcon = get_field('dashboard_label_icon', ods_options_id('Dashboard'));
?>
    <style>
        body {
            background: #f1f3f6 !important;
        }

        .login form {
            border: none !important;
            border-radius: 0.625rem;
            box-shadow: 0px 0px 20px 0px rgb(76 87 125 / 2%) !important;
        }

        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo $lableIcon; ?>);
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: auto 84px !important;
        }

        .login #backtoblog a,
        .login #nav a {
            display: none;
        }
    </style>
<?php }

add_action('login_enqueue_scripts', 'ods_login_logo');

function ods_login_logo_url()
{
    return admin_url();
}

add_filter('login_headerurl', 'ods_login_logo_url');

function ods_login_logo_url_title()
{
    return get_bloginfo('name');
}

add_filter('login_headertext', 'ods_login_logo_url_title');

// END PART



/**
 * change title for admin
 */

function ods_admin_title($admin_title, $title)
{
    return get_bloginfo('name') . ' &bull; ' . $title;
}

add_filter('admin_title', 'ods_admin_title', 10, 2);
add_filter('login_title', 'ods_admin_title', 10, 2);

// END PART