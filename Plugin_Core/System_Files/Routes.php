<?php

class WPB_Routes
{
    private $config;

    public function __construct()
    {
        $this->config = new WPB_Config;
    }

    function register_routes()
    {
        // WPB_Useful::log("Resgistering Plugin Routes");

        $routes = $this->config->routes;

        foreach ($routes as $item) {
            $controller = $item[0];
            $route = $item[1];

            $object = new $controller();

            add_action("wp_ajax_wpb_" . $route, [$object, $route]);
            add_action("wp_ajax_nopriv_wpb_" . $route, [$object, $route]);
        }
    }
}
