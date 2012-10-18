<?php

if (!class_exists('Carody_Sessions')) :



  include_once ( CARODY_DIR . '/eqp/class-carody-eqp-assoc.php');

  class Carody_Sessions {

    var $datiAuto;

    function __construct() {
      $this->datiAuto = Carody_Eqp_Assoc::get_eqp_assoc_from_db();
     // print_r($this->datiAuto);
    }

    function get_car_prop($prop) {
      return @$this->datiAuto[0][$prop];
    }

    static function check($object2check=null) {
      if ($object2check == null) {
        $lines = file(CARODY_DIR . "/inactive-index.php");

        foreach ($lines as $line) {
          echo($line);
        }
        wp_die();
      }

      return $object2check;
    }

  }

  endif;
?>
