<?php

if (!class_exists('Carody_User')) :

  class Carody_User {

    var $user_info;

    function __construct($id=null) {
      if ($id == null) {
        $id = get_current_user_id();
      }
      $user_info = get_userdata($id);
    }

    function getIdUtente() {
      return $this->user_info->ID;
    }

  }

  endif;
?>
