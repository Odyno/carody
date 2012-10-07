<?php

/**
 * Manage All action of Fuel
 */
if (!class_exists('Carody_Fuel_Manager')) {

  class Carody_Fuel_Manager {

    var $wpdb, $databasePre, $car;

    function __construct($class_eqp_manager) {
      if ($class_eqp_manager == null){
        wp_die("null on eqp manager!!!");
      }
      global $wpdb;
      $this->wpdb = $wpdb;
      $this->databasePre = $wpdb->prefix;
      $this->car = $class_eqp_manager;
    }

    function applayAction($commands) {
      try {
        if (isset($commands['do'])) {
          $do = @$commands['do'] . "_action";
          $fnc = new ReflectionMethod('Carody_Fuel_Manager', $do);
          $fnc->invoke($this, $commands);
        }
      } catch (Exception $e) {
        if (WP_DEBUG) {
          wp_die("Action not Allowed!:" . $e->__toString());
        } else {
          wp_die("Action not Allowed!");
        }
      }
    }

    function delete_action($commands) {
     // print_r($commands);
      $table = $this->databasePre . "Fuel";
      $this->wpdb->query($this->wpdb->prepare("DELETE FROM $table WHERE idFuel = %s", $commands['id']  ));
    }

    function edit_action($commands) {
     // print_r($commands);
      $table = $this->databasePre . "Fuel";
      $data = $this->getDataFromCommand($commands);
      $where = array('idFuel' => $commands['id']);
      $format = '%s';
      $this->wpdb->update($table, $data, $where);
    }

    function insert_action($commands) {
      $rows_affected = $this->wpdb->insert($this->databasePre . "Fuel", $this->getDataFromCommand($commands));
    }

    function getDataFromCommand($commands) {
      return array(
          'DataTime' => $commands['date'],
          'TotKm' => $commands['tot_km'],
          'PrezzoAlLitro' => $commands['fuel_costo_unitario'],
          'PrezzoRifornimento' => $commands['fuel_costo_totale'],
          'Macchina_idMacchina' => $this->car->getIdAuto(),
          'Macchina_idUtente' => $this->car->getIdUtente()
      );
    }

  }

}
?>
