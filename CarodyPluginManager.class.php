<?php

/**
 * Manage Plugin Activation/Deactivation and Unistall. 
 * @author Alessandro Staniscia
 */
if (!class_exists('CarodyPluginManager')) {


  class CarodyPluginManager {
    // Set this to true to get the state of origin, so you don't need to always uninstall during development.
    const DEVELOPE_MODE = true;

    const DB_VERSION = "1.1";

    var $notice,$file_declaretion;

    static function DDLs($databasePre="") {
      $dbSchema = array(
          $databasePre . "Macchina" => "CREATE TABLE `" . $databasePre . "Macchina` (  `idMacchina` INT NOT NULL AUTO_INCREMENT,  `idUtente` VARCHAR(45) NOT NULL ,  `Marca` VARCHAR(45) NULL ,  `Modello` VARCHAR(45) NULL ,  PRIMARY KEY (`idMacchina`, `idUtente`) ,  UNIQUE INDEX `idUtente_UNIQUE` (`idUtente` ASC) ,  UNIQUE INDEX `idMacchina_UNIQUE` (`idMacchina` ASC) )  ENGINE = MyISAM",
          $databasePre . "Fuel" => "CREATE TABLE `" . $databasePre . "Fuel` (  `idFuel` INT NOT NULL AUTO_INCREMENT ,  `DataTime` TIMESTAMP NOT NULL ,  `TotKm` INT(11) NOT NULL ,  `PrezzoAlLitro` DOUBLE NOT NULL ,  `PrezzoRifornimento` DOUBLE NOT NULL ,  `Macchina_idMacchina` INT NOT NULL ,  `Macchina_idUtente` VARCHAR(45) NOT NULL ,  PRIMARY KEY (`idFuel`, `Macchina_idMacchina`, `Macchina_idUtente`) ,  UNIQUE INDEX `idFuel_UNIQUE` (`idFuel` ASC) ,  INDEX `fk_Fuel_Macchina` (`Macchina_idMacchina` ASC, `Macchina_idUtente` ASC) ,  CONSTRAINT `fk_Fuel_Macchina`    FOREIGN KEY (`Macchina_idMacchina` , `Macchina_idUtente` )    REFERENCES `Macchina` (`idMacchina` , `idUtente` )    ON DELETE NO ACTION    ON UPDATE NO ACTION)   ENGINE = MyISAM",
      );
      return $dbSchema;
    }

    function __construct($file) {
      $this->file_declaration=$file;
      register_activation_hook($file, array(&$this, 'on_activate'));
      register_deactivation_hook($file, array(&$this, 'on_deactivate'));
      register_uninstall_hook($file, array('CarodyPluginManager', 'on_uninstall'));
      $this->notice[].="Configuration verion: ".  self::DB_VERSION;
      add_action('admin_notices', array(&$this, 'show_message_cb'));
    }

    /**
     * Set up tables, add options, etc. - All preparation that only needs to be done once
     */
    public function on_activate() {
      $this->notice[].="start activate procedure";
      $this->update_carody_db_tables();
      $this->add_carody_roles();
    }

    /**
     * Do nothing like removing settings, etc.
     * The user could reactivate the plugin and wants everything in the state before activation.
     * Take a constant to remove everything, so you can develop & test easier.
     */
    public function on_deactivate() {
      $this->notice[].="start deactivate procedure";
      if (CarodyPluginManager::DEVELOPE_MODE) {
        $this->notice[].="DEVELOP MODE!";
        self::on_uninstall($this->file_declaration);
      }
      //nothing for now
    }

    /**
     * Remove/Delete everything - If the user wants to uninstall, then he wants the state of origin.
     *
     * Will be called when the user clicks on the uninstall link that calls for the plugin to uninstall itself
     */
    public static function on_uninstall($file="") {
      $this->notice[].="Start uninstall procedire";
      // important: check if the file is the one that was registered with the uninstall hook (function)
      echo WP_UNINSTALL_PLUGIN;
      if ($file != WP_UNINSTALL_PLUGIN) {
        $me=new CarodyPluginManager($file);
        $me->drop_carody_db_tables();
        $me->del_carody_roles();
      }
    }

    public function update_carody_db_tables() {
      //Get the table name with the WP database prefix
      global $wpdb;
      $dbSchema = CarodyPluginManager::DDLs($wpdb->prefix);
      foreach ($dbSchema as $table_name => $ddl) {
        $installed_ver = get_option($table_name . "_table_ver");
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name || $installed_ver != $this->VERSION) {
          //table no exist or dbversion is no good
          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

          dbDelta($ddl);


          update_option($table_name . "_table_ver", $this->VERSION);

          $this->notice[].="Table $table_name Update!";
        } else {
          $this->notice[].="Table $table_name OK!";
        }
      }

      $this->notice[].="Updated tables done";
    }

    public function drop_carody_db_tables() {
      global $wpdb;
      $dbSchema = CarodyPluginManager::DDLs($wpdb->prefix);
      foreach ($dbSchema as $table_name => $ddl) {
        $wpdb->query("DROP TABLE {$table_name}");
        delete_option($table_name . "_table_ver");
        $this->notice[].="Drop $table_name";
      }
      $this->notice[].="Droped tables";
    }

    public function add_carody_roles() {
      if (null !== get_role('carody_registerd')) {
        $this->del_carody_roles();
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

    public function del_carody_roles() {
      $result = remove_role('carody_registerd');
    }

    public function show_message_cb() {
      echo '<div class="updated"><p>Carody plugin notice:</p><ol>';
      foreach ($this->notice as $note) {
        echo '<li>' . htmlentities($note) . '</li>';
      }
      echo '</ol></div>';
    }

    /**
     * trigger_error()
     *
     * @param (string) $error_msg
     * @param (boolean) $fatal_error | catched a fatal error - when we exit, then we can't go further than this point
     * @param unknown_type $error_type
     * @return void
     */
    function error($error_msg, $fatal_error = false, $error_type = E_USER_ERROR) {
      if (isset($_GET['action']) && 'error_scrape' == $_GET['action']) {
        echo "{$error_msg}\n";
        if ($fatal_error)
          exit;
      }else {
        trigger_error($error_msg, $error_type);
      }
    }

  }

}
?>
