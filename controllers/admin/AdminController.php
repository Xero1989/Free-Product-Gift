<?php

class WPB_AdminController
{

  static function view_main_settings()
  {

    WPB_Useful::load_libraries(['bootstrap4', 'lottie', 'sweet_alert']);

    wp_enqueue_style('css_admin', plugin_dir_url(__FILE__) . '../../assets/css/admin/admin.css');
    wp_enqueue_script('js_admin', plugin_dir_url(__FILE__) . '../../assets/js/admin/admin.js');
    wp_add_inline_script('js_admin', 'var url_admin_ajax = "' . admin_url('admin-ajax.php') . '";');

    $config = new WPB_Config;
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

    WPB_Useful::view('admin/admin', compact('options'));
  }

  static function save_settings()
  {
    // do_action( 'my_custom_hook' );

    $options = $_POST["options"];

    foreach ($options as $option) {
      update_option($option[0], $option[1]);
    }

    WPB_API::ajax_server_response();
  }

  // function test($order_id)
  // {
  //   WPB_Useful::log("test");

  //   global $wpdb;    

  //   $order = wc_get_order( $order_id );
  //   $order_data = $order->get_data();

  //   WPB_Useful::log("order_data");
  //   WPB_Useful::log($order_data);


  //   // $query = "SELECT id,username FROM xk_users";
  //   // $users = $wpdb->get_results($query, ARRAY_A);
  //   // $users = $wpdb->insert('test',$query, ARRAY_A);

   
  // }


}
