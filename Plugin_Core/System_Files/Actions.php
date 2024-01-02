<?php

class FPG_Actions
{
    private $config;

    public function __construct()
    {
        $this->config = new FPG_Config;
    }

    function load_actions()
    {
        // FPG_Useful::log("Resgistering Plugin Actions");

        $actions = $this->config->actions;

        foreach ($actions as $action) {
            $hook = $action[0];
            $controller = $action[1];
            $function = $action[2];

            $object = new $controller();

            add_action($hook, [$object, $function]);
        }
    }
}
