<?php

if (!class_exists('Carody_Fuel_Statistic')) :

  class Carody_Fuel_Statistic {

    function __construct($dbData) {

    }

    function getKM() {
      return 1000;
    }

    function getFuelPrice() {
      return 1.876;
    }

    function getTotFuelPrice() {
      return "30";
    }

  }

  endif;
?>
