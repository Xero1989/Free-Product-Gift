<?php

class FPG_Init
{

    
    function __construct()
    {
        $this->load_plugin_resources(); 
    }


    function load_plugin_resources()
    {
        add_action('init', function () {

            $this->load_routes();

            $this->load_filters();
    
            $this->load_actions();
    
            $this->load_shortcodes();
    
            $this->load_admin_dashboard_menu();
    
            $this->load_individual_page_trigger();

            // $this->load_custom_posts();


            FPG_Session::start_session();

            add_action('template_redirect',  function () {

                // if (!is_user_logged_in() && !is_login()) {    
                //     wp_redirect(wp_login_url());    
                //     exit;
                // }

            });           
            
        });        
    }

    function load_admin_dashboard_menu()
    {
        new FPG_AdminDashboardMenu();
    }

    function load_routes()
    {
        $routes = new FPG_Routes();
        $routes->register_routes();
    }

    function load_filters()
    {
        $filter = new FPG_Filters();
        $filter->apply_filters();
    }

    function load_actions()
    {
        $actions = new FPG_Actions();
        $actions->load_actions();
    }

    function load_custom_posts()
    {
        $posts = new FPG_Custom_Posts();
        $posts->load_custom_posts();
    }

    function load_shortcodes()
    {
        $shortcodes = new FPG_Shortcodes();
        $shortcodes->apply_shortcodes();
    }

    function load_individual_page_trigger()
    {
        $individual_page_triggers = new FPG_IndividualPageTriggers();
        $individual_page_triggers->load_individual_page_triggers();
    }
}
