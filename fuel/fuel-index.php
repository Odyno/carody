<?php
include(  CARODY_DIR . '/eqp/class-carody-eqp-manager.php');
include(  CARODY_DIR . '/fuel/class-carody-fuel-list.php');
include(  CARODY_DIR . '/fuel/class-carody-fuel-manager.php');


$carodyTable = new Carody_Fuel_List();

//managerequest
$fuelManager=new Carody_Fuel_Manager(new Carody_Eqp_Manager());
$fuelManager->applayAction($_REQUEST);


?>


<div class="wrap">

  <div id="icon-users" class="icon32"><br/></div>
  <h2>Scheda carburante</h2>

  <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
    <p>In questa scheda sono contenuti tutti i rifornimenti effettuati.</p>
    <p>La macchina in oggetto è la ???</p>
  </div>

  <?php $carodyTable->show("fuel-table") ?>

</div>
