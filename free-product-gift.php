<?php

/*
Plugin Name: Free Product Gift
Plugin URI:
Description: WP Plugin to add free product gift for buying one or more products
Version: 0.1
Author: Jorge Blanco Suárez
Author URI: https://xerocode.net/curriculum
License: GPL2+
*/


define('FPG_PATH', __DIR__);


require_once __DIR__ . '/vendor/autoload.php';

foreach (glob(__DIR__ . "/Plugin_Core/*.php") as $filename) {
    require_once $filename;
}

foreach (glob(__DIR__ . "/Plugin_Core/System_Files/*.php") as $filename) {
    require_once $filename;

    $class = "FPG_".basename($filename, ".php");
    new $class();    
}

foreach (glob(__DIR__ . "/Helpers/*.php") as $filename) {
    require_once $filename;
}

// Modules
// require_once __DIR__ . '/modules/admin/AdminController.php';
require_once __DIR__ . '/modules/free_gift/FreeGiftController.php';
// Modules


register_activation_hook(__FILE__, 'fpg_plugin_activation');

function fpg_plugin_activation()
{
    FPG_Useful::log("Activating Plugin");

    $activate = new FPG_Activate();
    $activate->activate();
}

register_deactivation_hook(__FILE__, 'fpg_plugin_deactivation');

function fpg_plugin_deactivation()
{
    FPG_Useful::log("Deactivating Plugin");

    $deactivate = new FPG_Deactivate();
    $deactivate->deactivate();
}

register_uninstall_hook(__FILE__, 'fpg_plugin_unnistall');

function fpg_plugin_unnistall()
{
}

new FPG_Init();
