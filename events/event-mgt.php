<?php
// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
  echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
  exit;
}


require_once (  CARODY_DIR . '/fuel/class-carody-fuel-view.php');
$carodySession = new Carody_Sessions();


function  carody_select_Intervento(){
  global $wpdb;
  $sql="SELECT idManutenzione, descrizione FROM ".$wpdb->prefix ."C_Manutenzione";
  $rs = $wpdb->get_results($sql, ARRAY_A);
  $out="";
  foreach ($rs as $linea) {
    $out.="<option value='".$linea['idManutenzione']."'>".$linea['descrizione']."</option>";
  }
  return $out;
}


wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery.ui.theme.custom', WP_PLUGIN_URL . '/carody/css/jquery-ui-1.7.3.custom.css');



$formIntervento['action'] = ( @$_REQUEST['action'] != null) ? $action : 'insert';
$formIntervento['id']=( @$_REQUEST['eventId'] != null)? $eventId:null;
$formIntervento['idMacchina']=Carody_Sessions::check($carodySession->get_car_prop('idMacchina'));




date_default_timezone_set('Europe/Rome');
$formIntervento['data']=current_time('mysql');

$formIntervento['inervento']=  carody_select_Intervento();

$formIntervento['note']="";
$formIntervento['prezzo']=0;


$formIntervento['km']="1950";


?>

<div class="wrap">

  <form action="?page=/carody/events/event-index.php" method="post">

    <script type="text/javascript">
      var $j = jQuery.noConflict();
      $j(function() {
        $j("#datepicker").datepicker({
          showOn: "button",
          buttonImage: "<?php echo WP_PLUGIN_URL ?>/carody/css/images/calendar.gif",
          buttonImageOnly: true,
          dateFormat: "yy-mm-dd 12:00:00",
          gotoCurrent: true
        });

      });
    </script>


    <h3>Compila i seguenti campi</h3>
    <table class="form-table">
      <tbody>
        <tr>
          <th><label for="date">Nella data</label></th>
          <td><input name="date" id="datepicker" type="text" value="<?php echo @$formIntervento['data']; ?>">
            <div class="description">La data dell'intervento</div></td>
        </tr>

         <tr>
          <th><label for="km">Totale chilometri</label></th>
          <td><input type="text" value="<?php echo @$formIntervento['km']; ?>" tabindex="1" id="km" name="km" size="6"> Km
            <div class="description">Guarda il cruscotto e indica i km totali della tua autovettura</div></td>
        </tr>


        <tr>
          <th><label for="Intervento">Intervento</label></th>
          <td>
            <select tabindex="2" id="intervento" name="intervento"  >
              <?php echo @$formIntervento['inervento']; ?>
            </select>
            <div class="description">Intervento Eseguito</div>
          </td>
        </tr>
        <tr>
          <th><label for="azione">Azione</label></th>
          <td>
            <input tabindex="3" type="radio" id="azione" name="azione"  value="Eseguito" >Eseguito &nbsp;&nbsp;
            <input tabindex="4" type="radio" id="azione" name="azione"  value="Sostituito">Sostituito &nbsp;&nbsp;
            <input tabindex="5" type="radio" id="azione" name="azione"  value="Controllato">Controllato &nbsp;&nbsp;
            <input tabindex="6" type="radio" id="azione" name="azione"  value="Rabboccato">Rabboccato &nbsp;&nbsp;
            <input tabindex="7" type="radio" id="azione" name="azione"  value="Rimandato">Rimandato &nbsp;&nbsp;
            <div class="description">Che cosa è stato fatto</div>
          </td>
        </tr>
        <tr>
          <th><label for="Note">Note</label></th>
          <td><textarea tabindex="8" id="note" name="note" rows="4" cols="50"><?php echo @$formIntervento['note']; ?></textarea>
            <div class="description">Una descrizione</div></td>
        </tr>
        <tr>
          <th><label for="Prezzo">Prezzo intervento</label></th>
          <td><input type="text" value="<?php echo @$formIntervento['prezzo']; ?>" tabindex="9" id="prezzo" name="prezzo" size="4">€
            <div class="description">Prezzo dell'intervento</div></td>
        </tr>
      </tbody>
    </table>


    <p class="submit">
      <input type="hidden" name="do" value="<?php echo @$formIntervento['action']; ?>">
      <input type="hidden" name="id" value="<?php echo @$formIntervento['id']; ?>">
      <input type="hidden" name="idMacchina" value="<?php echo @$formIntervento['idMacchina'] ?>">

      <input type="reset" class="button" value="Reset">
      <input type="submit" value="<?php echo  @$formIntervento['action']; ?>" class="button-primary" tabindex="5" accesskey="p" >
      <br class="clear">
    </p>



  </form>
</div>