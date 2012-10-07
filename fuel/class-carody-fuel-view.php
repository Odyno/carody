<?php

/**
 * Manage All action of Fuel
 */
if (!class_exists('Carody_Fuel_View')) {

  require_once ( CARODY_DIR . '/eqp/class-carody-eqp-assoc.php');

  class Carody_Fuel_View {

    var $wpdb, $databasePre;

    function __construct() {
      global $wpdb;
      $this->wpdb = $wpdb;
      $this->databasePre = $wpdb->prefix;
    }

    static function getQueryFuelData($idMacchine) {
      global $wpdb;
      $sql = " 
           SELECT `idFuel`, `DataTime`, `TotKm`, `PrezzoAlLitro`,`PrezzoRifornimento`, `Utente_Macchina_idUtente_Macchina`
           FROM
              `" . $wpdb->prefix . "Fuel`
           Where
              Utente_Macchina_idUtente_Macchina in ( $idMacchine )";
      return $sql;
    }

    static function get_fuel_data_from_db($userId=null) {
      global $wpdb;
      $Ids = Carody_Eqp_Assoc::get_eqp_assoc_from_db($userId);
      if ($Ids != null) {
        foreach ($Ids as $key =>$riga) {
          $id[$key]=$riga['idUtente_Macchina'];
        }
        $comma_separated = implode(",", $id);
      }

      $sql = self::getQueryFuelData($comma_separated);
      $out = $wpdb->get_results($sql, ARRAY_A);
      return $out;
    }

    static function get_eq_from_db($userId=null) {
      global $wpdb;
      $sql = Carody_Eqp_Assoc::getQueryGetUserEQId($idUtente,1);
      $out = $wpdb->get_results($sql, ARRAY_A);
      return $out;
    }

  }

}
?>
