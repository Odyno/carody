<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!class_exists('Carody_Event_Mgr')) {

  class Carody_Event_Mgr {

    var $wpdb, $databasePre;

    function __construct() {

      global $wpdb;
      $this->wpdb = $wpdb;
      $this->databasePre = $wpdb->prefix;
     
    }



    function applayAction($commands) {
      try {
        if (isset($commands['do'])) {
          //print_r($commands) && wp_die();
          $do = @$commands['do'] . "_action";
          $fnc = new ReflectionMethod('Carody_Event_Mgr', $do);
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

      $table = "`".$this->databasePre . "C_Almanacco`";
      $this->wpdb->query($this->wpdb->prepare("DELETE FROM $table WHERE idEvento = %s", $commands['id']));
    }

    function edit_action($commands) {
// print_r($commands);
      $table = $this->databasePre . "C_Almanacco";
      $data = $this->getDataFromCommand($commands);
      $where = array('idEvento' => $commands['id']);
      $format = '%s';
      $this->wpdb->update($table, $data, $where);
    }

    function insert_action($commands) {
      $rows_affected = $this->wpdb->insert($this->databasePre . "C_Almanacco", $this->getDataFromCommand($commands));
    }

    function getDataFromCommand($commands) {
      return array(
          'idMacchina' => $commands['idMacchina'],
          'data' => $commands['date'],
          'km' =>  $commands['km'],
          'idManutenzione' => $commands['intervento'],
          'descrizione' => $commands['note'],
          'azione' => $commands['azione'],
          'prezzo' => $commands['prezzo']
      );
    }

  }
}
?>
