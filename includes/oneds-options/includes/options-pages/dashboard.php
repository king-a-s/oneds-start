<?php

/**
 * add options page for Dashboard Settings.
 */

function ods_options_dashboard_page()
{
    ods_add_options_page(
        __('Dashboard', 'oneds-start'),
        'dashboard',
        0,
        'manage_options',
        array(
            'dashboard_layout' => 'oneds'
        )
    );
}

add_action('admin_menu', 'ods_options_dashboard_page');

// END PART



/**
 * Add extra html to dashboard options page.
 */

function ods_options_extra_dashboard_page_html()
{
?>
    <script>
        const element = document.getElementById("acf-field_dashboard_label");
        element.addEventListener("input", myFunction);

        function myFunction() {
            var x = document.getElementById("acf-field_dashboard_label").value;
            document.getElementById("wp-admin-bar-oneds-title").getElementsByClassName("ab-item")[0].innerHTML = x;
        }
    </script>
<?php

}

add_action('page_content_for_dashboard', 'ods_options_extra_dashboard_page_html', 100);

// END PART