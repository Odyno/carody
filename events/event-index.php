<?php
include( CARODY_DIR . '/events/class-carody-event-list.php');
include(  CARODY_DIR . '/events/class-carody-event-mgr.php');



$carodyTable = new Carody_Event_List();

//managerequest
$fuelManager=new Carody_Event_Mgr();
$fuelManager->applayAction($_REQUEST);

$carodySession = new Carody_Sessions();
$carody_modello_form = Carody_Sessions::check($carodySession->get_car_prop('Modello'));

?>


<div class="wrap">

  <div id="icon-users" class="icon32"><br/></div>
  <h2>Tutti gli interventi sulla macchina</h2>

  <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
    <p>In questa scheda sono contenuti gli interventi della macchina</p>
     <ul>
      <li><b>Modello:</b> <?php echo $carody_modello_form; ?></li>
      <li><b>Marca:</b> <?php echo $carodySession->get_car_prop('Marca');?></li>
     </ul>

  </div>

  <?php $carodyTable->show("event-table") ?>

</div>
