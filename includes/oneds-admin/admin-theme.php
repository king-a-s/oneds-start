<?php

/**
 * Add OneDS Admin Theme
 */


/*
 * Set (OneDS Option) the default color for all user and remove other colors
 */

function ods_admin_theme_update_user_option_admin_color($color_scheme)
{
    if (get_field('dashboard_layout', ods_options_id('dashboard')) == 'oneds') {
        remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
        $color_scheme = 'oneds_metronic';
    }

    if (get_field('dashboard_layout', ods_options_id('dashboard')) == 'oneds_pro') {
        remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
        $color_scheme = 'oneds_calc';
    }

    if (get_field('dashboard_layout', ods_options_id('dashboard')) == 'oneds_pro_dark') {
        remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
        $color_scheme = 'oneds_calc_dark';
    }

    if (get_field('dashboard_layout', ods_options_id('dashboard')) == 'mizan') {
        remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
        $color_scheme = 'oneds_mizan';
    }

    return $color_scheme;
}
add_filter('get_user_option_admin_color', 'ods_admin_theme_update_user_option_admin_color', 5);

// END PART



/**
 * Move the 'Collapse menu' item to the top of the admin menu if OneDS Theme applied
 */

function ods_admin_theme_move_collapse_menu()
{

    $current_color = get_user_option('admin_color');
    if (strpos($current_color, 'oneds') === false) {
        return;
    } else {
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
    }
}
add_action('wp_after_admin_bar_render', 'ods_admin_theme_move_collapse_menu');

// END PART


/*
 * Add OneDS Toolbar Link For Dashboard Label
 */

function ods_admin_theme_toolbar_link($wp_admin_bar)
{

    if (is_admin()) :
        //link

        $lable = __('OneDS', 'oneds-start');

        if (get_field('dashboard_label', ods_options_id('dashboard'))) {
            $lable = get_field('dashboard_label', ods_options_id('dashboard'));
        }

        $wp_admin_bar->add_node(array(
            'id'    => 'oneds-title',
            'title' => $lable,
            'href'  => admin_url(),
        ));

        // dashboard label icon (default: OneDS logo) logo from plugin folder
        $lableIcon = plugins_url('oneds-start/assets/images/oneds-logo.png');
        if (get_field('dashboard_label_icon', ods_options_id('dashboard'))) {
            $lableIcon = get_field('dashboard_label_icon', ods_options_id('dashboard'));
        }

    ?>
        <style>
            /* like .wp-admin #wpadminbar #wp-admin-bar-site-name>.ab-item:before for oneds but with image not content*/
            @media only screen and (min-width: 782px) {
                #wp-admin-bar-oneds-title>.ab-item:before {
                    content: '';
                    background: url('<?php echo $lableIcon; ?>') !important;
                    background-repeat: no-repeat !important;
                    background-position: center !important;
                    background-size: auto 18px !important;
                    width: 24px !important;
                    height: 24px !important;
                    display: inline-block !important;
                    vertical-align: middle !important;
                    margin-right: 5px !important;
                }
            }

            @media only screen and (max-width: 600px) {

                .welcome-panel-content {
                    flex-direction: column !important;
                }
            }

            @media screen and (max-width: 782px) {
                #wp-admin-bar-oneds-title {
                    display: block !important;
                    position: fixed !important;
                    bottom: 16px;
                    <?php
                    $x = !is_rtl() ? 'right' : 'left';
                    echo $x . ': 0;';
                    ?>
                }

                #wp-admin-bar-oneds-title a.ab-item,
                #wpadminbar.nojq .quicklinks .ab-top-menu>li.oneds_title_oneds>.ab-item:focus {
                    color: transparent !important;
                }

                #wp-admin-bar-oneds-title>.ab-item:before {
                    content: '';
                    background: url('<?php echo $lableIcon; ?>') !important;
                    background-repeat: no-repeat !important;
                    background-position: center !important;
                    background-size: auto 64px !important;
                    width: 64px !important;
                    height: 64px !important;
                    display: inline-block !important;
                    vertical-align: middle !important;
                    margin-left: 5px !important;
                }

                #wp-admin-bar-oneds-title a.ab-item {
                    width: 63px !important;
                    height: 64px !important;
                    background-color: transparent !important;
                }


            }
        </style>

        <?php

        $current_color = get_user_option('admin_color');
        if ((strpos($current_color, 'oneds') === false) || $current_color == 'oneds_mizan') {
            return;
        }

        $wp_admin_bar->add_node(array(
            'id'    => 'oneds_collapse_button'
        ));

    //sublink
    // $wp_admin_bar->add_node(array(
    // 	    'id'    => 'title_link',
    // 	    'title' => __('title', 'oneds-start'),
    // 	    'href'  => '#',
    // 	    'parent' => 'oneds-title',
    // 	    'meta'  => array( 'target' => '_blank',)
    //     ) );

    endif;
}

add_action('admin_bar_menu', 'ods_admin_theme_toolbar_link', 0);

// END PART



/*
 * Add some CSS if Wide Layout applied
 */

function ods_admin_theme_wide_dash_css()
{
    if (get_field('dashboard_layout', ods_options_id('dashboard')) != 'wide') {
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

            #wp-admin-bar-oneds-title.oneds-title_oneds>.ab-item {
                vertical-align: middle;
                height: auto;
                font-size: 20px;
                padding-bottom: 6px;
            }

            li#wp-admin-bar-oneds-title.oneds-title_oneds {
                width: 150px;
            }

            #wp-admin-bar-oneds_collapse_button,
            li#wp-admin-bar-oneds-title {
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

        li#wp-admin-bar-oneds-title {
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

add_action('admin_head', 'ods_admin_theme_wide_dash_css');
//add_action('wp_head', 'ods_admin_theme_wide_dash_css');

function ods_admin_theme_front_admin_bar_style()
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
//add_theme_support('admin-bar', array('callback' => 'ods_admin_theme_front_admin_bar_style'));


/**
 * Add OneDS footer
 */

function ods_admin_theme_admin_footer_text()
{
    echo __('Powered By', 'oneds-start') . ' ';
    //check if system is ClassicPress or WordPress
    if (function_exists('classicpress_version')) {
        echo '<a href="https://www.classicpress.net">' . __('ClassicPress') . '</a> ';
    } else {
        echo '<a href="https://www.wordpress.org">' . __('WordPress') . '</a> ';
    }
    echo __('&', 'oneds-start');
    echo ' <a href="https://www.oneds.org">' . __('OneDS', 'oneds-start') . '</a>';
}

add_filter('admin_footer_text', 'ods_admin_theme_admin_footer_text');


function ods_admin_theme_admin_footer_date_time()
{

    // if screen is dashboard, return
    if (get_current_screen()->id == 'dashboard') {
        return;
    }

    echo '' . date_i18n('l, d/m/Y', current_time('timestamp', 1));
    ?>
    <script>
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

add_filter('update_footer', 'ods_admin_theme_admin_footer_date_time');

function ods_admin_theme_admin_footer_filter()
{
    remove_filter('update_footer', 'core_update_footer');
}

add_action('admin_menu', 'ods_admin_theme_admin_footer_filter');

// END PART




/**
 * Change Login Logo Based on Site Custom Logo
 */

function ods_admin_theme_login_logo()
{

    // dashboard label icon (default: OneDS logo) logo from plugin folder
    $lableIcon = plugins_url('oneds-start/assets/images/oneds-logo.png');
    if (get_field('dashboard_label_icon', ods_options_id('dashboard'))) {
        $lableIcon = get_field('dashboard_label_icon', ods_options_id('dashboard'));
    }
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

        .language-switcher {
            display: none;
        }
    </style>
<?php }

add_action('login_enqueue_scripts', 'ods_admin_theme_login_logo');

function ods_admin_theme_login_logo_url()
{
    return admin_url();
}

add_filter('login_headerurl', 'ods_admin_theme_login_logo_url');

function ods_admin_theme_login_logo_url_title()
{
    return get_bloginfo('name');
}

add_filter('login_headertext', 'ods_admin_theme_login_logo_url_title');

// END PART



/**
 * change title for admin
 */

function ods_admin_theme_admin_title($admin_title, $title)
{
    return get_bloginfo('name') . ' &bull; ' . $title;
}

add_filter('admin_title', 'ods_admin_theme_admin_title', 10, 2);
add_filter('login_title', 'ods_admin_theme_admin_title', 10, 2);

// END PART


/**
 * remove howdy
 */

function ods_admin_theme_remove_howdy($translation, $text)
{
    if ($text == 'Howdy, %s')
        return '%s';
    return $translation;
}

add_filter('gettext', 'ods_admin_theme_remove_howdy', 10, 2);

// END PART


/**
 * change user link from admin bar and make display name bolder 
 */

function ods_admin_theme_change_admin_bar_user_link($wp_admin_bar)
{
    $node = $wp_admin_bar->get_node('my-account');

    $node->href = '';

    $wp_admin_bar->add_node($node);
?>

    <style>
        @media screen and (max-width: 782px) {
            img.avatar.avatar-26.photo {
                position: absolute !important;
                top: 13px;
                right: 10px;
                width: 26px !important;
                height: 26px !important;
            }
        }
    </style>

<?php
}

add_action('admin_bar_menu', 'ods_admin_theme_change_admin_bar_user_link', 999);


function ods_admin_theme_make_display_name_bolder()
{
?>
    <style>
        /* make wp-admin-bar-user-info display_name bolder */
        #wp-admin-bar-my-account .ab-item .display-name {
            font-weight: 600;
        }

        #wp-admin-bar-my-account a.ab-item {
            pointer-events: none;
        }

        #wp-admin-bar-edit-profile a.ab-item,
        #wp-admin-bar-logout a.ab-item {
            pointer-events: auto;
        }
    </style>

<?php
}

// add_filter('admin_bar_menu', 'ods_admin_theme_make_display_name_bolder', 25);

// END PART



/**
 * remove wordpress logo from admin bar
 */

function ods_admin_theme_remove_wp_logo($wp_admin_bar)
{
    $wp_admin_bar->remove_node('wp-logo');
}

add_action('admin_bar_menu', 'ods_admin_theme_remove_wp_logo', 999);

// END PART



/**
 * remove comments button from admin bar
 */

function ods_admin_theme_remove_admin_bar_comments_link($wp_admin_bar)
{
    $wp_admin_bar->remove_node('comments');
}

add_action('admin_bar_menu', 'ods_admin_theme_remove_admin_bar_comments_link', 999);

// END PART



/**
 * remove media new link from admin bar
 */

function ods_admin_theme_remove_admin_bar_media_new_link($wp_admin_bar)
{

    $wp_admin_bar->remove_node('new-media');
}

add_action('admin_bar_menu', 'ods_admin_theme_remove_admin_bar_media_new_link', 999);

// END PART



/**
 * change new link from admin bar
 */

function ods_admin_theme_change_admin_bar_new_link($wp_admin_bar)
{
    $node = $wp_admin_bar->get_node('new-content');

    if ($node) {
        $node->href = '';
        $wp_admin_bar->add_node($node);
    }
}

add_action('admin_bar_menu', 'ods_admin_theme_change_admin_bar_new_link', 999);

// END PART



/*
 * Add some CSS
 */

function ods_admin_theme_dash_css()
{
    if (get_field('dashboard_layout', ods_options_id('dashboard')) != 'wide') {
        return;
    }

    // This makes sure that the positioning is also good for right-to-left languages
    $x = is_rtl() ? 'right' : 'left';

    // background color
    $color1 = get_field('dashboard_color_1', ods_options_id('dashboard')) ? get_field('dashboard_color_1', ods_options_id('dashboard')) : '#1e1e1e';

    // accent color
    $color2 = get_field('dashboard_color_2', ods_options_id('dashboard')) ? get_field('dashboard_color_2', ods_options_id('dashboard')) : '#007cba';

    /*<?php echo $x; ?>*/

?>
    <style>
        html {
            --wp-admin--admin-bar--height: 60px;
            scroll-padding-top: var(--wp-admin--admin-bar--height);
        }

        html.wp-toolbar {
            padding-top: 60px;
            box-sizing: border-box;
            -ms-overflow-style: scrollbar;
        }

        #wpcontent,
        #wpfooter {
            margin-<?php echo $x; ?>: 300px;
        }

        /** Admin Menu */

        #adminmenuback {
            height: 100%;
            width: 300px;
        }

        #adminmenuwrap {
            height: calc(100% - 120px);
            width: 300px;
            position: fixed;
            top: 60px;
            <?php echo $x; ?>: 0;
        }

        #adminmenu {
            height: 100%;
            width: 300px;
            position: fixed;
            top: 60px;
            <?php echo $x; ?>: 0;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            z-index: 9999;
        }

        #adminmenu,
        #adminmenuback,
        #adminmenuwrap {
            background-color: <?php echo $color1; ?>;
        }

        #adminmenu .wp-submenu {
            background-color: <?php echo $color1; ?>;
            /* width: auto; */
        }

        #adminmenu a {
            color: rgba(240, 246, 252, .6);
        }

        ul#adminmenu a.wp-has-current-submenu:after,
        ul#adminmenu>li.current>a.current:after {
            display: none;
        }

        #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head,
        #adminmenu .wp-menu-arrow,
        #adminmenu .wp-menu-arrow div,
        #adminmenu li.current a.menu-top,
        #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
            background: <?php echo $color2; ?>;
            color: #fff;
            border-radius: 2px;
        }

        #adminmenu a:focus,
        #adminmenu a:hover,
        .folded #adminmenu .wp-submenu-head:hover {
            box-shadow: none;
        }

        #adminmenu .wp-submenu a:focus,
        #adminmenu .wp-submenu a:hover,
        #adminmenu a:hover,
        #adminmenu li.menu-top>a:focus {
            color: #fff;
        }

        #adminmenu li.menu-top:hover,
        #adminmenu li.opensub>a.menu-top,
        #adminmenu li>a.menu-top:focus {
            color: #fff;
        }

        #adminmenu div.wp-menu-name {
            padding: 12px;
            padding-<?php echo $x; ?>: 48px;
            overflow-wrap: break-word;
            word-wrap: break-word;
            -ms-word-break: break-all;
            word-break: break-word;
            -webkit-hyphens: auto;
            hyphens: auto;
        }

        #adminmenu div.wp-menu-image {
            float: <?php echo $x; ?>;
            width: 36px;
            height: 34px;
            margin: 0px;
            text-align: center;
            position: relative;
            <?php echo $x; ?>: 12px;
            top: 5px;
        }

        #adminmenu li a:focus div.wp-menu-image:before,
        #adminmenu li.opensub div.wp-menu-image:before,
        #adminmenu li:hover div.wp-menu-image:before {
            color: #fff;
        }

        #adminmenu a.menu-top:focus+.wp-submenu,
        .js #adminmenu .opensub .wp-submenu,
        .js #adminmenu .sub-open,
        .no-js li.wp-has-submenu:hover .wp-submenu {
            <?php echo $x; ?>: 120px;
        }

        #adminmenu li.wp-has-submenu.wp-not-current-submenu.opensub:hover:after,
        #adminmenu li.wp-has-submenu.wp-not-current-submenu:focus-within:after {
            display: none;
        }


        /** Admin Bar */

        #wpadminbar {
            direction: rtl;
            color: #c3c4c7;
            font-size: 13px;
            font-weight: 400;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            line-height: 2.46153846;
            height: 60px;
            position: fixed;
            top: 0;
            <?php echo $x; ?>: 0;
            width: 100% z-index: 99999;
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
        }

        #wpadminbar .quicklinks>ul>li>a {
            padding: 12px;
            height: 36px;
        }

        #wpadminbar .ab-empty-item,
        #wpadminbar a.ab-item,
        #wpadminbar>#wp-toolbar span.ab-label,
        #wpadminbar>#wp-toolbar span.noticon {
            color: #000;
        }

        #wpadminbar .quicklinks .ab-empty-item,
        #wpadminbar .quicklinks a,
        #wpadminbar .shortlink-input {
            height: 36px;
            display: block;
            padding: 12px;
            margin: 0;
        }

        #wpadminbar #adminbarsearch:before,
        #wpadminbar .ab-icon:before,
        #wpadminbar .ab-item:before {
            color: #a7aaad;
            color: rgb(0 0 0 / 60%);
        }

        #wpadminbar .ab-top-menu>li.hover>.ab-item,
        #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus,
        #wpadminbar:not(.mobile) .ab-top-menu>li:hover>.ab-item,
        #wpadminbar:not(.mobile) .ab-top-menu>li>.ab-item:focus {
            background: #fff;
            color: #72aee6;
        }

        /** OneDS Logo */
        #wp-admin-bar-oneds-title {
            padding: 0 !important;
            background: #bc1b1b !important;
            width: 215px;
            height: 61px;
            vertical-align: middle;
            text-align: center;
        }
    </style>

<?php
}
 
//   add_action('admin_head', 'ods_admin_theme_dash_css');
 
 // END PART
