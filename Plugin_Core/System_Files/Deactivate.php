<?php

class FPG_Deactivate
{
    private $config;

    public function __construct()
    {
        $this->config = new FPG_Config;
    }

    function deactivate()
    {
        FPG_Useful::log("Deactivating  Plugin Options");
        $this->table_delete();
        // $this->table_updates();
        $this->plugin_options();
        $this->posts_delete();
    }

    /*
    * Plugin's Options on deactivate
    */
    public function plugin_options()
    {
        $options = $this->config->plugin_options;
        foreach ($options as $key => $option) {
            delete_option($key, $option);
        }
    }

    /*
    * Delete Tables
    */
    public function table_delete()
    {
        FPG_Useful::log("Deleting Plugin Tables");

        global $wpdb;

        $database_tables = $this->config->database_tables;

        foreach ($database_tables as $table) {

            $_table = $table[0];

            $query = "DROP TABLE `$_table`;";

            $wpdb->query($query);
        }
    }

    /*
    * Delete Posts
    */
    public function posts_delete()
    {
        // EX_Useful::log("Deleting Posts");

        $posts = $this->config->posts;

        global $wpdb;

        foreach ($posts as $post) {

            if(isset($post['post_name'])){
            $name = sanitize_title($post['post_name']);

            $query = "SELECT ID FROM wp_posts 
            WHERE post_name = '$name'";
            $result = $wpdb->get_results($query, ARRAY_A);

            foreach ($result as $delete_post) {
                wp_delete_post($delete_post["ID"], true);
            }
          }
        }
    }
}
