<?php

class FPG_Useful
{

    static function log($data, $clean_log = false)
    {
        // Place the log on wp root
        // $logs_dir = ABSPATH . "log/FPG_".basename(FPG_PATH);

        // Place the log on plugin folder
        $logs_dir = FPG_PATH . "/log";

        if (!is_dir($logs_dir)) {
            mkdir($logs_dir, 0755, true);
        }

        $date = date("Y-m-d");
        $file_name = $logs_dir . '/' . $date . ".json";

        if ($clean_log)
            $obj = fopen($file_name, 'w');
        else $obj = fopen($file_name, 'a');

        $data = json_encode($data);

        fwrite($obj, $data);
        fwrite($obj, "\n\n");

        fclose($obj);
    }

    static function view($BladePage, $Attributes = array())
    {
        // $blade = new Jenssegers\Blade\Blade(plugin_dir_path(dirname(dirname(__FILE__))) . 'modules', plugin_dir_path(dirname(dirname(__FILE__))) . 'storage/cache');
        $blade = new Jenssegers\Blade\Blade(FPG_PATH . '/modules', FPG_PATH . 'storage/cache');
        echo $blade->render($BladePage, $Attributes);
    }

    static function inject_info_from_php_to_javascript($js_name, $php_info = array())
    {
        foreach ($php_info as $key => $value) {
            if (is_string($value))
                wp_add_inline_script($js_name, 'var ' . $key . ' = "' . $value . '";');
            else wp_add_inline_script($js_name, 'var ' . $key . ' = ' . json_encode($value) . ';');
        }
    }

    static function encrypt($data)
    {
        $pubKey = get_option("fpg_public_key");

        $publicKey = "-----BEGIN PUBLIC KEY-----\n" . wordwrap($pubKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";

        if (openssl_public_encrypt($data, $encrypted, $publicKey))
            $data = base64_encode($encrypted);

        return $data;
    }

    static function load_libraries($libraries = [])
    {
        wp_enqueue_script('js_util', plugin_dir_url(__FILE__) . '../../assets/libraries/utils.js');

        foreach ($libraries as $library) {

            if ($library == 'bootstrap4') {
                wp_enqueue_style('css_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
                wp_enqueue_script('js_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js');
                continue;
            }

            if ($library == 'lottie') {
                wp_enqueue_style('css_loader', plugin_dir_url(__FILE__) . '../../assets/libraries/loader/loader.css');
                wp_enqueue_script('js_lottie', "https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js");
                wp_enqueue_script('js_loader', plugin_dir_url(__FILE__) . '../../assets/libraries/loader/loader.js');
                continue;
            }

            if ($library == 'sweet_alert') {
                wp_enqueue_style('css_sweet_alert', plugin_dir_url(__FILE__) . '../../assets/libraries/sweet-alert-2/sweetalert2.min.css');
                wp_enqueue_script('js_sweet_alert', plugin_dir_url(__FILE__) . '../../assets/libraries/sweet-alert-2/sweetalert2@11.js');
                continue;
            }
        }
    }

    static function send_email($to, $subject, $template = "test")
    {
        $headers = array('Content-Type: text/html; charset=UTF-8');

        ob_start();
        FPG_Useful::view("emails/$template/$template");
        $body = ob_get_contents();
        ob_end_clean();

        $result = wp_mail($to, $subject, $body, $headers);

        FPG_Useful::log("Email send result: " . $result);

        return $result;
    }
}
