<?php

class FPG_GLOBAL_CONTROLLER
{


    function __construct()
    {
    }

    function load_assets()
    {
        wp_enqueue_style('css_loader', plugin_dir_url(__FILE__) . '../../assets/libraries/loader/loader.css');
        wp_enqueue_script('js_lottie', "https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js");
        wp_enqueue_script('js_loader', plugin_dir_url(__FILE__) . '../../assets/libraries/loader/loader.js');

        wp_enqueue_style('css_sweet_alert', plugin_dir_url(__FILE__) . '../../assets/libraries/sweet-alert-2/sweetalert2.min.css');
        wp_enqueue_script('js_sweet_alert', plugin_dir_url(__FILE__) . '../../assets/libraries/sweet-alert-2/sweetalert2@11.js');

        wp_enqueue_script('js_util', plugin_dir_url(__FILE__) . '../../assets/libraries/utils.js');

        wp_enqueue_script('js_frontend', plugin_dir_url(__FILE__) . '../../assets/js/frontend/FRONTEND.js');

        $url_admin_ajax = admin_url('admin-ajax.php');
        // $client_ip = WC_Geolocation::get_ip_address();
        // $_SESSION["client_ip"] = $client_ip;

        FPG_Useful::inject_info_from_php_to_javascript("js_master", compact("url_admin_ajax"));
    }
}
