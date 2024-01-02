<?php

class FPG_AdminController
{

  static function view_main_settings()
  {

    FPG_Useful::load_libraries(['bootstrap4', 'lottie', 'sweet_alert']);

    wp_enqueue_style('css_admin', plugin_dir_url(__FILE__) . '../../assets/css/admin/admin.css');
    wp_enqueue_script('js_admin', plugin_dir_url(__FILE__) . '../../assets/js/admin/admin.js');
    wp_add_inline_script('js_admin', 'var url_admin_ajax = "' . admin_url('admin-ajax.php') . '";');

    $config = new FPG_Config;
    $plugin_options = $config->plugin_options;

    $options = [];
    $option_init = 0;
    $option_end = count($plugin_options) - 1;
    $cursor = 0;
    foreach ($plugin_options as $key => $value) {
      if ($cursor >= $option_init && $cursor <= $option_end) {
        $value = get_option($key);
        $options[$key] = $value;
      }

      $cursor++;
    }

    // FPG_Useful::log("test");
    // FPG_Useful::log(FPG_PATH . 'modules/admin');
    FPG_Useful::view('admin/admin', compact('options'));
  }

  static function save_settings()
  {
    // do_action( 'my_custom_hook' );

    $options = $_POST["options"];

    foreach ($options as $option) {
      update_option($option[0], $option[1]);
    }

    FPG_API::ajax_server_response();
  }

}
