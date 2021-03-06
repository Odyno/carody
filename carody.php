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



//Gestore dei menù
require_once CARODY_DIR . '/carody-menu-manager.php';

//Gestore dei widget
require_once CARODY_DIR . '/carody-widget-manager.php';

//Gestore dei widget
require_once CARODY_DIR . '/class-carody-sessions.php';

//Gestore le interfacce xml-rpc
require_once CARODY_DIR . '/carody-xml-rpc-manager.php';




?>
