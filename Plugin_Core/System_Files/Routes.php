<?php

class FPG_Routes
{
    private $config;

    public function __construct()
    {
        $this->config = new FPG_Config;
    }

    function register_routes()
    {
        // FPG_Useful::log("Resgistering Plugin Routes");

        $routes = $this->config->routes;

        foreach ($routes as $item) {
            $controller = $item[0];
            $route = $item[1];

            $object = new $controller();

            add_action("wp_ajax_fpg_" . $route, [$object, $route]);
            add_action("wp_ajax_nopriv_fpg_" . $route, [$object, $route]);
        }
    }
}
