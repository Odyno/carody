<?php

/**
 * Manage All action of Fuel
 */
if (!class_exists('Carody_Event_Query')) {


  class Carody_Event_Query {

     /**
     *
     * @global <type> $wpdb
     * @param <type> $idMacchina
     * @return <type>
     */
    static function get_events_list($idMacchina=null) {
      global $wpdb;
      $tableAlmanacco = $wpdb->prefix . "C_Almanacco";
      $tableManutenzione = $wpdb->prefix . "C_Manutenzione";
      $tableMAcchina = $wpdb->prefix . "Macchina";

      $sql = "SELECT alm.idEvento as idEvento, alm.data as data , alm.km as km, mnt.descrizione as intervento, alm.azione as azione, alm.prezzo as prezzo,  alm.descrizione as note
        FROM $tableAlmanacco as alm , $tableManutenzione as mnt, $tableMAcchina as car Where car.idMacchina = alm.idMacchina and mnt.idManutenzione=alm.idManutenzione";

      if ($idMacchina != null){
        $sql .=" AND car.idMacchina = ".$idMacchina;
      }
      $out = $wpdb->get_results($sql, ARRAY_A);
           
      return $out;
    }

      /**
     *
     * @global <type> $wpdb
     * @param <type> $idMacchina
     * @return <type>
     */
    static function get_event($idEvento) {
      global $wpdb;
      $tableAlmanacco = $wpdb->prefix . "C_Almanacco";
      $tableManutenzione = $wpdb->prefix . "C_Manutenzione";
      $tableMAcchina = $wpdb->prefix . "Macchina";

      $sql = "SELECT alm.idEvento, alm.data, alm.km, mnt.descrizione, alm.azione, alm.prezzo,  alm.descrizione as note
        FROM $tableAlmanacco as alm , $tableManutenzione as mnt, $tableMAcchina as car
        Where car.idMacchina = alm.idMacchina and mnt.idManutenzione=alm.idManutenzione
        AND alm.idEvento=".$idEvento;

      $out = $wpdb->get_results($sql, ARRAY_A);
      return @$out[0];
    }
  }

}
?>
