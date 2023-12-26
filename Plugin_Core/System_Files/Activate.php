<?php

class WPB_Activate
{
    private $config;

    public function __construct()
    {
        $this->config = new WPB_Config;
    }

    function activate()
    {
        WPB_Useful::log("Activating Plugin Options");
        $this->table_create();
        $this->table_insert_values();
        // $this->table_updates();

        $this->plugin_options();

        $this->create_posts();
    }

    /*
    * Plugin's Options on first install   
    */
    public function plugin_options()
    {
        $options = $this->config->plugin_options;
        foreach ($options as $key => $option) {
            add_option($key, $option);
        }
    }

    /*
    * Create Plugin Database Tables
    */
    public function table_create()
    {
        $database_tables = $this->config->database_tables;

        global $wpdb;

        foreach ($database_tables as $table) {

            $_table = $table[0];
            $_fields = $table[1];

            $query = "CREATE TABLE IF NOT EXISTS `$_table` (`id` INT(5) NOT NULL AUTO_INCREMENT,";

            $column_unique_index = array();
            foreach ($_fields as $field) {

                $column = $field[0];
                $type = $field[1];

                if (isset($field[3]))
                    array_push($column_unique_index, $column);

                if (isset($field[2]))
                    $length = $field[2];

                if ($type == "FLOAT" || $type == "DATETIME")
                    $query .= "`$column` $type NULL DEFAULT NULL,";
                else if ($type == "TINYINT")
                    $query .= "`$column` TINYINT(1) NULL DEFAULT NULL,";
                else $query .= "`$column` $type($length) NULL DEFAULT NULL,";
            }

            $query .= "PRIMARY KEY (`id`),";

            foreach ($column_unique_index as $column) {
                $query .= "UNIQUE INDEX `$column` (`$column`),";
            }

            $query = substr($query, 0, -1);
            $query .= ") COLLATE='latin1_swedish_ci';";

            $wpdb->query($query);
        }
    }

    public function table_updates()
    {
        $database_tables = $this->config->database_tables;

        global $wpdb;

        foreach ($database_tables as $table) {

            $_table = $table[0];
            $_fields = $table[1];
        }
    }

    public function table_insert_values()
    {
        WPB_Useful::log("INSERTING TABLE VALUES");
        $database_tables_values = $this->config->database_tables_values;

        global $wpdb;

        foreach ($database_tables_values as $table) {

            $_table = $table[0];
            $values = $table[1];
            $values = implode(', ', $values[0]);

            $existing_columns = $wpdb->get_col("DESC {$_table}", 0);
            array_splice($existing_columns, 0, 1);
            $fields = implode(', ', $existing_columns);

            $query = "INSERT INTO $_table($fields) VALUES($values)";
            $wpdb->query($query);
        }
    }

    function create_posts()
    {
        // WPB_Useful::log("Resgistering Plugin Posts");

        $posts = $this->config->posts;

        global $wpdb;

        foreach ($posts as $post) {

            $name = sanitize_title($post['post_name']);

            $query = "SELECT * FROM wp_posts 
            WHERE post_name = '$name'";
            $result = $wpdb->get_results($query, ARRAY_A);

            if (count($result) == 0) {
                $post_id = wp_insert_post($post);
            }
        }
    }
}
