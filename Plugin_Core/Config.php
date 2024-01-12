<?php

class FPG_Config
{

    public $filters = [
        // ["woocommerce_is_purchasable","FPG_FreeGiftController","woocommerce_is_purchasable",10,2]
        // ['woocommerce_cart_item_quantity',"FPG_FreeGiftController","remove_all_quantity_fields_for_free_gifts"]
        ['woocommerce_add_to_cart_validation', 'FPG_FreeGiftController', 'woocommerce_add_to_cart_validation'],
    ];

    public $actions = [
        ['woocommerce_before_add_to_cart_button','FPG_FreeGiftController', 'show_template'],
        // ["woocommerce_share","FPG_FreeGiftController","show_free_gifts"],
        ['woocommerce_add_to_cart', 'FPG_FreeGiftController', 'woocommerce_add_to_cart'],
        // ['wp_footer', 'FPG_FreeGiftController', 'set_free_gifts_products_visibility_none'],
        
    ];

    public $shortcodes = [
        // ["test_shortcode", "FPG_AdminController", "testing_shortcode"]
    ];

    public $individual_page_triggers = [
        // [
        //     "page_slug" => "kapital-view",
        //     "css" => ["admin/test"],
        //     "js" => ["frontend/test"],
        //     "functions"=> [
        //         ["FPG_AdminController", "test"]
        //     ]
        // ],
    ];

    public $routes = [
        // ["FPG_AdminController", "save_settings"],
    ];

    public $admin_dashboard_menu = [
        // [
        //     // 'page_title' => 'Free Product Gift Settings',
        //     // 'menu_title' => 'Free Product Gift Settings',
        //     // 'url_slug' => 'free-product-gift-settings',
        //     // 'callback' => 'FPG_AdminController::view_main_settings',
        //     // 'icon' => '',
        //     // 'submenu' => [
        //     //     [
        //     //         'page_title' => 'Pusher Settings',
        //     //         'menu_title' => 'Pusher Settings',
        //     //         'url_slug'   => 'pusher-settings',
        //     //         'callback'   => 'FPG_AdminController::view_pusher_settings',
        //     //     ],
        //     //     [
        //     //         'page_title' => 'Twilio Settings',
        //     //         'menu_title' => 'Twilio Settings',
        //     //         'url_slug'   => 'twilio-settings',
        //     //         'callback'   => 'FPG_AdminController::view_twilio_settings',
        //     //     ]
        //     // ]
        // ],
    ];

    public $plugin_options = [
        // "fpg_main_setting_1" => "",
        // "fpg_main_setting_2" => "",

        // "fpg_pusher_setting_1" => "",
        // "fpg_pusher_setting_2" => "",

        // "fpg_twilio_setting_1" => "",
        // "fpg_twilio_setting_2" => "",
    ];

    public $database_tables = [
        // [
        //     "fpg_plugin_base", [
        //         ["name", "VARCHAR", 255, "UNIQUE"],
        //         ["edad", "INT", 5],
        //         ["dinero", "FLOAT"],
        //         ["deleted", "TINYINT"],
        //         ["created_at", "DATETIME"],
        //     ]
        // ]
    ];

    public $database_tables_values = [
        // [
        //     "fpg_plugin_base", [
        //         ["'jorge blanco'", 33, 1500.10, 0, "'2022-10-15 11:20:50'"],
        //     ]
        // ]
    ];

    public $posts = [
        [
            // 'post_type'     => 'page',                 // Post Type Slug eg: 'page', 'post'
            // 'post_title'    => 'Test Page Title 2',    // Title of the Content
            // 'post_content'  => '[test_shortcode]',     // Content
            // 'post_status'   => 'publish',              // Post Status
            // //'post_author'   => 1,                      // Post Author ID
            // 'post_name'     => 'test-page-title'       // Slug of the Post
        ],
    ];

    public $custom_posts = [
        [
            // Set other options for Custom Post Type

            // 'label'               => 'movies',
            // 'description'         => 'Movie news and reviews',
            // 'labels'              => [
            //     'name'                => 'Movies',
            //     'singular_name'       => 'Movie',
            //     'menu_name'           => 'Movies',
            //     'parent_item_colon'   => 'Parent Movie',
            //     'all_items'           => 'All Movies',
            //     'view_item'           => 'View Movie',
            //     'add_new_item'        => 'Add New Movie',
            //     'add_new'             => 'Add New',
            //     'edit_item'           => 'Edit Movie',
            //     'update_item'         => 'Update Movie',
            //     'search_items'        => 'Search Movie',
            //     'not_found'           => 'Not Found',
            //     'not_found_in_trash'  => 'Not found in Trash',
            // ],

            // 'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields'),
            // 'taxonomies'          => array('genres'),
            // 'hierarchical'        => false,
            // 'public'              => true,
            // 'show_ui'             => true,
            // 'show_in_menu'        => true,
            // 'show_in_nav_menus'   => true,
            // 'show_in_admin_bar'   => true,
            // 'menu_position'       => 5,
            // 'can_export'          => true,
            // 'has_archive'         => true,
            // 'exclude_from_search' => false,
            // 'publicly_queryable'  => true,
            // 'capability_type'     => 'post',
            // 'show_in_rest' => true,
        ],
    ];

   
}
