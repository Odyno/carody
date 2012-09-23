<?php

/**
  @package Carody
  Plugin Name: Carody
  Plugin URI: http://carody.staniscia.net
  Description: My Plugin.
  Version: 0.0.0
  Author: Alessandro Staniscia
  Author URI: http://www.staniscia.net/carody-wp-plugins/
  License: GPLv2 or later
 */
define('CARODY_VERSION', '0.0.1-SNAPSHOT');

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
  echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
  exit;
}

include_once plugin_dir_path(__FILE__) . '/CarodyPluginManager.class.php';
if (!class_exists('CarodyPluginManager')) {
  wp_die("CarodyPluginManager not Loaded", "Plugin Failed To load");
}
register_activation_hook(__FILE__, array('CarodyPluginManager', 'on_activate'));
register_deactivation_hook(__FILE__, array('CarodyPluginManager', 'on_deactivate'));
register_uninstall_hook(__FILE__, array('CarodyPluginManager', 'on_uninstall'));

//Gestore dei menù

include_once plugin_dir_path(__FILE__) . '/CarodyMenuManager.php';


//Gestore dei Widget


//Aggiungo i widget
include_once plugin_dir_path(__FILE__) . '/fuel/FuelWidgets.php';
if (!function_exists('carody_dashboard_widgets')) {
  wp_die("Widgets not Loaded", "Plugin Failed To load");
}

?>
