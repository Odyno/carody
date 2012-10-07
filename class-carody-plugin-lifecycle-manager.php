<?php

if (!class_exists('Carody_Plugin_Lifecycle_Manager')) :


  if (!class_exists('Generic_Plugin_Lifecycle_Manager'))
    require_once( CARODY_DIR . '/class-generic-plugin-lifecycle-manager.php' );

  class Carody_Plugin_Lifecycle_Manager extends Generic_Plugin_Lifecycle_Manager {

    var $doUpdate = false;

    static function DDLs($databasePre="") {
      $dbSchema = array(
          $databasePre . "Macchina" => "CREATE TABLE `" . $databasePre . "Macchina` ( `idMacchina` INT(11) NOT NULL AUTO_INCREMENT , `Marca` VARCHAR(45) NULL , `Modello` VARCHAR(45) NULL , `MaxSerbatoioLitri` INT(11) NULL , `ConsumoMedio` FLOAT NULL , PRIMARY KEY (`idMacchina`) , UNIQUE INDEX `idMacchina_UNIQUE` (`idMacchina` ASC) ) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8",
          $databasePre . "Utente_Macchina" => "CREATE TABLE `" . $databasePre . "Utente_Macchina` ( `idUtente_Macchina` INT NOT NULL AUTO_INCREMENT , `Users_ID` BIGINT(20) UNSIGNED NOT NULL , `Macchina_idMacchina` INT(11) NOT NULL ,`Priority` INT(10) NOT NULL DEFAULT -1 , PRIMARY KEY (`idUtente_Macchina`) , INDEX `fk_Utente_Macchina_wp_users` (`Users_ID` ASC) , INDEX `fk_Utente_Macchina_Macchina1` (`Macchina_idMacchina` ASC) ) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8",
          $databasePre . "Fuel" => "CREATE TABLE `" . $databasePre . "Fuel` ( `idFuel` INT(11) NOT NULL AUTO_INCREMENT , `DataTime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP , `TotKm` INT(11) NOT NULL , `PrezzoAlLitro` DOUBLE NOT NULL , `PrezzoRifornimento` DOUBLE NOT NULL , `Utente_Macchina_idUtente_Macchina` INT NOT NULL , PRIMARY KEY (`idFuel`) , UNIQUE INDEX `idFuel_UNIQUE` (`idFuel` ASC) , INDEX `fk_Fuel_Utente_Macchina1` (`Utente_Macchina_idUtente_Macchina` ASC) ) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8"
      );
      return $dbSchema;
    }

    function __construct($case) {
      parent::__construct($case);
    }

    function get_name() {
      return "carody_plugin";
    }

    function get_version() {
      return "0.0.1";
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

      $dbSchema = self::DDLs($wpdb->prefix);
      foreach ($dbSchema as $table_name => $ddl) {
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name || $this->doUpdate) {
          //table no exist or version is no good
          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
          dbDelta($ddl);

          $this->addInfo("Table $table_name Update!");
        } else {
          $this->addInfo("Table $table_name is installed and Updated");
        }
      }

      $this->addInfo("DB done");
    }

    private function _drop_db_tables() {
      global $wpdb;
      $dbSchema = self::DDLs($wpdb->prefix);
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
