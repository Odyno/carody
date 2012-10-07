<?php
include( CARODY_DIR . '/eqp/class-carody-eqp-list.php');
include( CARODY_DIR . '/eqp/class-carody-eqp-mgr.php');


$carodyTable = new Carody_Eqp_List();

//managerequest
$fuelManager=new Carody_Eqp_Mgr();
$fuelManager->applayAction($_REQUEST);

?>


<div class="wrap">

  <div id="icon-users" class="icon32"><br/></div>
  <h2>Parco Mezzi</h2>

  <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
    <p>In questa scheda sono contenuti tutti Mezzi</p>
  </div>

  <?php $carodyTable->show("eqp-table") ?>

</div>
