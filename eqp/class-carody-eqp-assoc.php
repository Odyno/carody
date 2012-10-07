<?php

if (!class_exists('Carody_Eqp_Assoc')) :

  class Carody_Eqp_Assoc {

    var $wpdb, $databasePre;

    function __construct() {

      global $wpdb;
      $this->wpdb = $wpdb;
      $this->databasePre = $wpdb->prefix;
    }

    static function getQueryGetUserEQId($idUtente=null) {
      if ($idUtente == null) {
        $idUtente = get_current_user_id();
      }
      $sql = " select Macchina_idMacchina
                from wp_Utente_Macchina where Users_ID = '$idUtente'";
      return $sql;
    }

    static function getQueryGetUserEQ($idUtente=null) {
      if ($idUtente == null) {
        $idUtente = get_current_user_id();
      }
      $sql = "select ma.idMacchina, ma.Marca, ma.Modello, mu.Priority as Priority 
                 from  wp_Macchina as ma, wp_Utente_Macchina as mu
                 where ma.idMacchina in ( " . self::getQueryGetUserEQId($idUtente) . " )
                 order by Priority ";
      return $sql;
    }

    static function getQueryAll($idUtente=null) {
      if ($idUtente == null) {
        $idUtente = get_current_user_id();
      }

      $sql = "select ma.idMacchina, ma.Marca, ma.Modello, 0 as Priority
                from wp_Macchina as ma where ma.idMacchina not in ( " . self::getQueryGetUserEQId($idUtente) . " )
                union " .
              self::getQueryGetUserEQ($idUtente = null);
      return $sql;
    }

    static function get_eqp_assoc_from_db($sql = null) {
      global $wpdb;
      if ($sql == null) {
        $sql = self::getQueryGetUserEQ();
      }
      $out = $wpdb->get_results($sql, ARRAY_A);
      return $out;
    }

    function applayAction($commands) {
      try {
        if (isset($commands['do'])) {
          $do = @$commands['do'] . "_action";
          $fnc = new ReflectionMethod('Carody_Eqp_Assoc', $do);
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

    function Associa_action($commands) {
      // print_r($commands);

      $table = $this->databasePre . "Utente_Macchina";
      $this->wpdb->query($this->wpdb->prepare("DELETE FROM $table WHERE Users_ID = %s", $commands['id']));
      if ($commands['idMacchine'] > 0) {
        $this->wpdb->insert($table, array("Users_ID" => $commands['id'], "Macchina_idMacchina" => $commands['idMacchine'], "Priority" => 1));
      }
    }

  }

  endif;
?>
