<?php

/**
 * Manage All action of Fuel
 */
if (!class_exists('Carody_FuelManager')) {

  class Carody_FuelManager {

    var $wpdb, $databasePre,$car;

    function   __construct() {
      global $wpdb;
      $this->wpdb=$wpdb;
      $this->databasePre=$wpdb->prefix;
      $this->car=new Carody_Equipments ();
      
    }

    function applayAction($commands) {
      try {
        if (isset($commands['do'])) {
          $do = @$commands['do'] . "_action";
          $fnc = new ReflectionMethod('Carody_FuelManager', $do);
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
      print_r($commands);
      
    }

    function edit_action($commands) {
      print_r($commands);
      //[date] => 2012-09-07 17:54:37 [tot_km] => 140000 [fuel_costo_unitario] => 1.65 [fuel_costo_totale] => 41 [do] => edit
      $this->wpdb->update( $table, $data, $where, $format = null, $where_format = null );
    }

    function insert_action($commands) {
      print_r($commands);
      $rows_affected = $this->wpdb->insert( $this->databasePre . "Fuel",
              array(
                  'DataTime' => $commands['date'],
                  'TotKm' =>$commands['tot_km'],
                  'PrezzoAlLitro' =>$commands['fuel_costo_unitario'],
                  'PrezzoRifornimento' =>$commands['fuel_costo_totale'],
                  'Macchina_idMacchina' => $this->car->getIdAuto(),
                  'Macchina_idUtente' => $this->car->getIdUtente()
                   ) );
    }

  }

}
?>
