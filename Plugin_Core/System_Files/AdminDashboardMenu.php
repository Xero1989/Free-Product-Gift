<?php

class FPG_AdminDashboardMenu
{
    private $config;

    public function __construct()
    {
        $this->config = new FPG_Config;

        add_action('admin_menu', [$this, 'load_admin_dashboard_menu']);
    }

    function load_admin_dashboard_menu()
    {

        $admin_dashboard_menu = $this->config->admin_dashboard_menu;

        foreach ($admin_dashboard_menu as $menu) {
            $page_title = $menu['page_title'];
            $menu_title = $menu['menu_title'];
            $url_slug = $menu['url_slug'];
            $callback = $menu['callback'];

            add_menu_page($page_title, $menu_title, 'manage_options', $url_slug, $callback);

            if (isset($menu['submenu'])) {
                $submenus = $menu['submenu'];

                foreach ($submenus as $submenu) {

                    $submenu_page_title = $submenu['page_title'];
                    $submenu_menu_title = $submenu['menu_title'];
                    $submenu_url_slug = $submenu['url_slug'];
                    $submenu_callback = $submenu['callback'];

                    add_submenu_page($url_slug, $submenu_page_title, $submenu_menu_title, 'manage_options', $submenu_url_slug, $submenu_callback);
                }
            }
        }
    }
}
