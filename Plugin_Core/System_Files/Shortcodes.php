<?php

class WPB_Shortcodes
{
    private $config;

    public function __construct()
    {
        $this->config = new WPB_Config;
    }

    function apply_shortcodes()
    {
        // WPB_Useful::log("Registering Plugin Shortcodes");

        $shortcodes = $this->config->shortcodes;

        foreach ($shortcodes as $shortcode) {
            $hook = $shortcode[0];
            $controller = $shortcode[1];
            $function = $shortcode[2];

            $object = new $controller();

            add_shortcode($hook, [$object, $function]);
        }
    }
}
