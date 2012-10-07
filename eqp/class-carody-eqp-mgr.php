<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!class_exists('Carody_Eqp_Mgr')) {

  class Carody_Eqp_Mgr {

    var $wpdb, $databasePre;

    function __construct() {

      global $wpdb;
      $this->wpdb = $wpdb;
      $this->databasePre = $wpdb->prefix;
     
    }



    function applayAction($commands) {
      try {
        if (isset($commands['do'])) {
          $do = @$commands['do'] . "_action";
          $fnc = new ReflectionMethod('Carody_Eqp_Mgr', $do);
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
      $table = "`".$this->databasePre . "Macchina`";
      $this->wpdb->query($this->wpdb->prepare("DELETE FROM $table WHERE idMacchina = %s", $commands['id']));
    }

    function edit_action($commands) {
// print_r($commands);
      $table = $this->databasePre . "Macchina";
      $data = $this->getDataFromCommand($commands);
      $where = array('idMacchina' => $commands['id']);
      $format = '%s';
      $this->wpdb->update($table, $data, $where);
    }

    function insert_action($commands) {
      $rows_affected = $this->wpdb->insert($this->databasePre . "Macchina", $this->getDataFromCommand($commands));
    }

    function getDataFromCommand($commands) {
      return array(
          'Marca' => $commands['marca'],
          'Modello' => $commands['modello'],
          'MaxSerbatoioLitri' => $commands['max_serbatoio_litri'],
          'ConsumoMedio' => $commands['consumo_medio']
      );
    }

  }
}
?>
