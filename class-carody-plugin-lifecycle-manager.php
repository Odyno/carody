<?php

if (!class_exists('Carody_Plugin_Lifecycle_Manager')) :

  if (!class_exists('Carody_DB_Definition'))
    require_once( CARODY_DIR . '/class-carody-db-definition.php' );

  if (!class_exists('Generic_Plugin_Lifecycle_Manager'))
    require_once( CARODY_DIR . '/class-generic-plugin-lifecycle-manager.php' );

  class Carody_Plugin_Lifecycle_Manager extends Generic_Plugin_Lifecycle_Manager {

    var $doUpdate = false;
    var $doDataFeel = false;

    function __construct($case) {
      parent::__construct($case);
    }

    function get_name() {
      return "carody_plugin";
    }

    function get_version() {
      return "0.0.2_5";
    }

    function update_request_cb($installed_version) {
      $this->doUpdate = true;
    }

    function activate_cb() {
      //Get the table name with the WP database prefix
      $this->addInfo("Do activate procedure");
      $this->_create_update_db_tables();
      $this->_add_carody_roles();
    }

    function deactivate_cb() {
      $this->addInfo("Do deactivate procedure");
    }

    function uninstall_cb() {
      $this->addInfo("Do uninstall procedure");
      $this->_drop_db_tables();
      $this->_del_carody_roles();
    }

    private function _create_update_db_tables() {

      global $wpdb;
      $wpdb->show_errors();
      $dbSchema = Carody_DB_Definition::DDLs($wpdb->prefix);
      foreach ($dbSchema as $table_name => $ddl) {
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name || $this->doUpdate) {
          //table no exist or version is no good
          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
          dbDelta($ddl);
          $this->doDataFeel = true;

          $this->addInfo("Table $table_name Update!");
        } else {
          $this->addInfo("Table $table_name is installed and Updated");
        }
      }
      if ($this->doDataFeel) {
        $dataFill = Carody_DB_Definition::DataFill($wpdb->prefix);
        foreach ($dataFill as $table_name => $inserts) {
          foreach ($inserts as $insertData) {
              $wpdb->insert($table_name, $insertData);
          }
        }
      }
      $wpdb->flush();
      $this->addInfo("DB done");
    }

    private function _drop_db_tables() {
      global $wpdb;
      $dbSchema = Carody_DB_Definition::DDLs($wpdb->prefix);
      foreach ($dbSchema as $table_name => $ddl) {
        $wpdb->query("DROP TABLE {$table_name}");
        delete_option($table_name . "_table_ver");
        $this->notice[].="Drop $table_name";
      }
      $this->notice[].="Droped tables";
    }

    private function _add_carody_roles() {
      if (null !== get_role('carody_registerd')) {
        $this->_del_carody_roles();
      }

      $result = add_role('carody_registerd', 'Carody basic registered user', array(
                  'read' => true, // True allows that capability,
                  'activate_plugins' => true
              ));

      if (null !== $result) {
        $result->add_cap("carody_fuel");
        $result->add_cap("carody_edit");
        $result->add_cap("carody_read");
        $result->add_cap("carody_delete");
        $result->add_cap("read");
      } else {
        wp_die("Roles not added", "add_carody_roles");
      }
    }

    private function _del_carody_roles() {
      $result = remove_role('carody_registerd');
    }

  }

  endif;
?>
