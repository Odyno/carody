<?php

if (!class_exists("Carody_Quick_Fuel_Widget")) :

  class Carody_Quick_Fuel_Widget {

    static function attach() {
      wp_add_dashboard_widget(
              'Carody_Quick_Fuel_Widget_Id',
              'Quick report rifornimento',
              array('Carody_Quick_Fuel_Widget', 'show'));
    }

    function show() {
      include(CARODY_DIR.'/fuel/fuel-mng.php');
    }

  }

  endif;
?>
