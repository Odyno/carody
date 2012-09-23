<?php

/**
 * Manage All action of Fuel
 */
if (!class_exists('Carody_FuelManager')) {

  class Carody_FuelManager {

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
      $wpdb->update( $table, $data, $where, $format = null, $where_format = null );
    }

    function insert_action($commands) {
      print_r($commands);
      $rows_affected = $wpdb->insert( $table_name,
              array(
                  'time' => current_time('mysql'),
                  'name' => $welcome_name,
                  'text' => $welcome_text ) );
    }

  }

}
?>
