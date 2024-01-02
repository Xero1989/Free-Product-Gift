<?php

class FPG_Custom_Posts
{
    private $config;

    public function __construct()
    {
        $this->config = new FPG_Config;
    }

    function load_custom_posts()
    {
        // FPG_Useful::log("Registering Posts");

        $custom_posts = $this->config->custom_posts;

        foreach ($custom_posts as $custom_post) {

            $name = $custom_post['label'];

            register_post_type($name, $custom_post);
        }
    }
}
