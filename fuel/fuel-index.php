<?php
include(  ABSPATH.'wp-content/plugins/carody/equipment/Carody_Equipments.php');
include(  ABSPATH.'wp-content/plugins/carody/fuel/Carody_FuelList.php');
include(  ABSPATH.'wp-content/plugins/carody/fuel/Carody_FuelManager.php');


$testListTable = new Carody_FuelList();
$equipment=new Carody_Equipments();



//managerequest
$fuelManager=new Carody_FuelManager();
$fuelManager->applayAction($_REQUEST);


?>


<div class="wrap">

  <div id="icon-users" class="icon32"><br/></div>
  <h2>Scheda carburante</h2>

  <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
    <p>In questa scheda sono contenuti tutti i rifornimenti effettuati.</p>
    <p>La macchina in oggetto è la <?php $equipment->showDatasheetConsume(); ?></p>
  </div>

  <?php $testListTable->show("fuel-table") ?>

</div>
