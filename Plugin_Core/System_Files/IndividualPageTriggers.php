<?php

class WPB_IndividualPageTriggers
{
    private $config;

    public function __construct()
    {
        $this->config = new WPB_Config;
    }

    public function load_individual_page_triggers()
    {
        // WPB_Useful::log("load_individual_page_triggers");

        add_action('wp_footer', function () {

            $individual_page_triggers = $this->config->individual_page_triggers;

            foreach ($individual_page_triggers as $element) {

                $page_slug = $element['page_slug'];

                if (is_page($page_slug)) {

                    if (isset($element['css'])) {
                        $page_css = $element['css'];

                        foreach ($page_css as $css) {
                            wp_enqueue_style($css, plugin_dir_url(__FILE__) . "../../assets/css/$css.css");
                        }
                    }

                    if (isset($element['js'])) {
                        $page_js = $element['js'];

                        foreach ($page_js as $js) {
                            wp_enqueue_script($js, plugin_dir_url(__FILE__) . "../../assets/js/$js.js");
                        }
                    }

                    if (isset($element['functions'])) {
                        $functions = $element['functions'];

                        foreach ($functions as $function) {
                            $controller = $function[0];
                            $function = $function[1];

                            $object = new $controller();

                            $object->$function();
                        }
                    }

                }

            }

//   Load resources by default in admin or on the frontend
            // if (is_admin()) {
            // } else {
            //     if (is_page('home')) {
            //         $homeController = new WPB_HomeController();
            //         $homeController->load_assets();
            //     }
            // }

        });

    }
}
