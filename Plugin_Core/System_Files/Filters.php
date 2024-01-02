<?php

class FPG_Filters
{
    private $config;

    public function __construct()
    {
        $this->config = new FPG_Config;
    }

    function apply_filters()
    {
        // FPG_Useful::log("Resgistering Plugin Filters");

        $filters = $this->config->filters;

        foreach ($filters as $filter) {
            $hook = $filter[0];
            $controller = $filter[1];
            $function = $filter[2];

            $object = new $controller();

            add_filter($hook, [$object, $function]);
        }
    }
}
