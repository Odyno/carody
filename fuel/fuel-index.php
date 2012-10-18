<?php
include(  CARODY_DIR . '/fuel/class-carody-fuel-list.php');
include(  CARODY_DIR . '/fuel/class-carody-fuel-manager.php');


$carodyTable = new Carody_Fuel_List();
$fuelManager=new Carody_Fuel_Manager();
$fuelManager->applayAction($_REQUEST);



$carodySession = new Carody_Sessions();
$carody_modello_form = Carody_Sessions::check($carodySession->get_car_prop('Modello'));
?>


<div class="wrap">

  <div id="icon-users" class="icon32"><br/></div>
  <h2>Scheda carburante</h2>

  <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
    <p>In questa scheda sono contenuti tutti i rifornimenti effettuati.</p>
    
    <ul>
      <li><b>Modello:</b> <?php echo $carody_modello_form; ?></li>
      <li><b>Marca:</b> <?php echo $carodySession->get_car_prop('Marca');?></li>
      <li><b>Capienza Serbatoio:</b> <?php echo $carodySession->get_car_prop('MaxSerbatoioLitri');?></li>
      <li><b>Cosumo medio dichiarato:</b> <?php echo $carodySession->get_car_prop('ConsumoMedio');?></li>
      <li><b>Il tuo consumo medio:</b> n.p.</li>
    </ul>
  </div>

  <?php $carodyTable->show("fuel-table") ?>

</div>
