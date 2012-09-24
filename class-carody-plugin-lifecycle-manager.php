<?php

if (!class_exists('Carody_Plugin_Lifecycle_Manager')) :


  if (!class_exists('Generic_Plugin_Lifecycle_Manager'))
    require_once( CARODY_DIR . '/class-generic-plugin-lifecycle-manager.php' );

  class Carody_Plugin_Lifecycle_Manager extends Generic_Plugin_Lifecycle_Manager {

    function __construct($case) {
      
      parent::__construct($case);
    }

    function get_name() {
      return "carody_plugin";
    }

    function get_version() {
      return "0.0.0";
    }

    function update_request_cb($installed_version) {
      return;
    }

    function activate_cb() {
      $this->addInfo("Do activate procedure");
    
    }

    function deactivate_cb() {
      $this->addInfo("Do deactivate procedure");
      
    }

    function uninstall_cb() {
      $this->addInfo("Do uninstall procedure");
      
    }

  }

  endif;
?>
