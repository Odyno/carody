<?php

if (!class_exists("Carody_Timeline_Widget")) :

  class Carody_Timeline_Widget {

    static function attach() {
      wp_add_dashboard_widget(
              'Carody_Timeline_Widget_Id',
              'Time line',
              array('Carody_Timeline_Widget', 'show'));
    }

    function show() {
      include(CARODY_DIR.'/todo-index.php');
    }

  }

  endif;
?>
