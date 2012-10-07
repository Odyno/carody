<?php
// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
  echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
  exit;
}


require_once ( CARODY_DIR . '/eqp/class-carody-eqp-assoc.php');

function get_carody_eqp_asoc_html_select() {
  
  $var = Carody_Eqp_Assoc::get_eqp_assoc_from_db(Carody_Eqp_Assoc::getQueryAll());
  
  foreach ($var as $righe) {
       $selected=$righe['Priority'] > 0 ? "selected='selected'":"";
       $out.="<option value='$righe[idMacchina]' $selected >$righe[Priority] - $righe[Marca], $righe[Modello]</option><br/>";
    
  }
  return $out;
}

//managerequest
$fuelManager=new Carody_Eqp_Assoc();
$fuelManager->applayAction($_REQUEST)


?>


<div class="wrap">

  <div id="icon-users" class="icon32"><br/></div>
  <h2>Seleziona la tua macchina</h2>

  <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
    <p>Quali mezzi ti appartengono? <br> Ricorda, il primo selezionato sarà il defualt per il tuo profilo</p>
    
  </div>

  <form action="?page=/carody/eqp/eqp-assoc.php">
    <label> <br>
      <select name="idMacchine" size="10" multiple="multiple" width="300" style="width: 100%">
        <option value='-1'  >-- Nothing --</option><br/>
        <?php echo get_carody_eqp_asoc_html_select(); ?>
      </select>
    </label>

    <p class="submit">
      <input type="hidden" name="page" value="/carody/eqp/eqp-assoc.php">
      <input type="hidden" name="do" value="Associa">
      <input type="hidden" name="id" value="<?php echo get_current_user_id(); ?>">
      <input type="reset" class="button" value="Reset">
      <input type="submit" value="Associa" class="button-primary" tabindex="5" accesskey="p" >
      <br class="clear">
    </p>

  </form>


</div>
