<?php

class FPG_Uninstall
{

    private $config;

    public function __construct()
    {
        $this->config = new FPG_Config;
    }

    public function index()
    {
        $this->delete_options($this->config->plugin_options);
    }

    public function delete_options($options)
    {
        foreach ($options as $key => $option) {
            if (get_option($key) != false) {
                delete_option($key);
            }

        }
    }
}
