<?php

class WPB_HomeController
{

  function __construct()
  {
  }

  function load_assets()
  {
    wp_enqueue_script('js_home', plugin_dir_url(__FILE__) . '../../assets/js/frontend/home.js');
  }

  function load_autoship_frequencies()
  {
    $autoship_frequencies = $this->xirect_api->get_autoship_frequencies();

    if (isset($autoship_frequencies["response_code"]) && $autoship_frequencies["response_code"] == 200 && $autoship_frequencies["success"] == true)
      $_SESSION["autoship_frequencies"] = $autoship_frequencies["data"];

      WPB_API::ajax_server_response($autoship_frequencies);
  }
}
