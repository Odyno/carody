<?php

/**
  @package Carody
  Plugin Name: Carody
  Plugin URI: http://carody.staniscia.net
  Description: My Plugin.
  Version: 0.0.1
  Author: Alessandro Staniscia
  Author URI: http://www.staniscia.net/carody-wp-plugins/
  License: GPLv2 or later
 */
define('CARODY_VERSION', '0.0.1-SNAPSHOT');
define('CARODY_DIR', plugin_dir_path(__FILE__));
define('CARODY_URL', plugin_dir_url(__FILE__));
define('CARODY_FILE', ABSPATH . PLUGINDIR . '/carody/carody.php');

require_once 'class-carody-plugin-lifecycle-manager.php';

function carody_on_active() {
  $me = new Carody_Plugin_Lifecycle_Manager('activate');
  add_action('admin_notices', array(&$me, 'show_message_cb'));
}

function carody_on_deactive() {
  $me = new Carody_Plugin_Lifecycle_Manager('deactivate');
  add_action('admin_notices', array(&$me, 'show_message_cb'));
}

function carody_on_uninstall() {
  $me = new Carody_Plugin_Lifecycle_Manager('uninstall');
  add_action('admin_notices', array(&$me, 'show_message_cb'));
}

register_activation_hook(CARODY_FILE, 'carody_on_active');
register_deactivation_hook(CARODY_FILE, 'carody_on_deactive');
register_uninstall_hook(CARODY_FILE, 'carody_on_uninstall');


//
//
//
//require_once 'class-carody-plugin-lifecycle-manager.php';
//
//include_once plugin_dir_path(__FILE__) . '/CarodyPluginManager.class.php';
//if (!class_exists('CarodyPluginManager')) {
//  wp_die("CarodyPluginManager not Loaded", "Plugin Failed To load");
//}
//
//$carody_PluginManager=new CarodyPluginManager(__FILE__);
//
//
//
////Gestore dei menù
//include_once plugin_dir_path(__FILE__) . '/CarodyMenuManager.php';
//
//
////Gestore dei Widget
//include_once plugin_dir_path(__FILE__) . '/fuel/FuelWidgets.php';
//if (!function_exists('carody_dashboard_widgets')) {
//  wp_die("Widgets not Loaded", "Plugin Failed To load");
//}
?>
