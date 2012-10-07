<?php
// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
  echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
  exit;
}

wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery.ui.theme.custom', WP_PLUGIN_URL . '/carody/css/jquery-ui-1.7.3.custom.css');

include( CARODY_DIR . '/fuel/class-carody-fuel-list.php');

$data = (!empty($_REQUEST['fuelid'])) ? Carody_Fuel_List::get_fuel_data_from_db($_REQUEST['fuelid']) : "";
$action = (!empty($_REQUEST['action'])) ? $_REQUEST['action'] : 'insert';

if (!isset($data[0])) {
  date_default_timezone_set('Europe/Rome');
  $fueldata['DataTime'] = current_time('mysql');
} else {
  $fueldata = @$data[0];
}
?>

<div class="wrap">

  <form action="?page=/carody/fuel/fuel-index.php" method="post">


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
          <td><input name="date" id="datepicker" type="text" value="<?php echo @$fueldata['DataTime']; ?>">
            <div class="description">La data del riformimento</div></td>
        </tr>
        <tr>
          <th><label for="date">Totale chilometri</label></th>
          <td><input type="text" value="<?php echo @$fueldata['TotKm']; ?>" tabindex="1" id="tot-km" name="tot_km" size="6"> Km
            <div class="description">Guarda il cruscotto e indica i km totali della tua autovettura</div></td>
        </tr>
        <tr>
          <th><label for="date">Prezzo del carburante </label></th>
          <td><input type="text" value="<?php echo @$fueldata['PrezzoAlLitro']; ?>" tabindex="2" id="fuel-costo-unitario" name="fuel_costo_unitario" size="4">€/L
            <div class="description">Guarda la pompa e indica il prezzo del carburante</div></td>
        </tr>
        <tr>
          <th><label for="date">Totale rifornimento</label></th>
          <td><input type="text" value="<?php echo @$fueldata['PrezzoRifornimento']; ?>" tabindex="3" id="fuel-costo-totale" name="fuel_costo_totale" size="4">€
            <div class="description">Indica qui quanto hai speso</div></td>
        </tr>

      </tbody>
    </table>


    <p class="submit">
      <input type="hidden" name="do" value="<?php echo $action; ?>">
      <input type="hidden" name="id" value="<?php echo $_REQUEST['fuelid'] ?>">
      <input type="reset" class="button" value="Reset">
      <input type="submit" value="<?php echo $action; ?>" class="button-primary" tabindex="5" accesskey="p" >
      <br class="clear">
    </p>



  </form>
</div>