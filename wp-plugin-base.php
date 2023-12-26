<?php

/*
Plugin Name: WP Plugin Base
Plugin URI:
Description: WP Plugin to develop a plugin
Version: 0.1
Author: Jorge Blanco Suárez
Author URI: https://xerocode.net/curriculum
License: GPL2+
*/


define('WPB_PATH', __DIR__);


require_once __DIR__ . '/vendor/autoload.php';

foreach (glob(__DIR__ . "/Plugin_Core/*.php") as $filename) {
    require_once $filename;
}

foreach (glob(__DIR__ . "/Plugin_Core/System_Files/*.php") as $filename) {
    require_once $filename;

    $class = "WPB_".basename($filename, ".php");
    new $class();    
}

foreach (glob(__DIR__ . "/controllers/Helpers/*.php") as $filename) {
    require_once $filename;
}

foreach (glob(__DIR__ . "/controllers/admin/*.php") as $filename) {
    require_once $filename;
}

foreach (glob(__DIR__ . "/controllers/frontend/*.php") as $filename) {
    require_once $filename;
}

foreach (glob(__DIR__ . "/controllers/backend/*.php") as $filename) {
    require_once $filename;
}


register_activation_hook(__FILE__, 'wpb_plugin_activation');

function wpb_plugin_activation()
{
    WPB_Useful::log("Activating Plugin");

    $activate = new WPB_Activate();
    $activate->activate();
}

register_deactivation_hook(__FILE__, 'wpb_plugin_deactivation');

function wpb_plugin_deactivation()
{
    WPB_Useful::log("Deactivating Plugin");

    $deactivate = new WPB_Deactivate();
    $deactivate->deactivate();
}

register_uninstall_hook(__FILE__, 'wpb_plugin_unnistall');

function wpb_plugin_unnistall()
{
}

new WPB_Init();
