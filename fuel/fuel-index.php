<?php
include(  CARODY_DIR . '/fuel/class-carody-fuel-list.php');
include(  CARODY_DIR . '/fuel/class-carody-fuel-manager.php');


$carodyTable = new Carody_Fuel_List();
$fuelManager=new Carody_Fuel_Manager();
$fuelManager->applayAction($_REQUEST);


include( CARODY_DIR . '/eqp/class-carody-eqp-assoc.php');
$datiAuto=Carody_Eqp_Assoc::get_eqp_assoc_from_db();

?>


<div class="wrap">

  <div id="icon-users" class="icon32"><br/></div>
  <h2>Scheda carburante</h2>

  <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
    <p>In questa scheda sono contenuti tutti i rifornimenti effettuati.</p>
    
    <lu>
      <li><b>Modello:</b> <?php echo $datiAuto[0]['Modello'];?></li>
      <li><b>Marca:</b> <?php echo $datiAuto[0]['Marca'];?></li>
      <li><b>Capienza Serbatoio:</b> n.p.</li>
      <li><b>Cosumo medio dichiarato:</b> n.p.</li>
      <li><b>Il tuo consumo medio:</b> n.p.</li>
    </lu>
  </div>

  <?php $carodyTable->show("fuel-table") ?>

</div>
