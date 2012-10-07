<?php
// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
  echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
  exit;
}

include( CARODY_DIR . '/eqp/class-carody-eqp-list.php');

$data = (!empty($_REQUEST['idMacchina'])) ? Carody_Eqp_List::get_eqp_data_from_db($_REQUEST['idMacchina']) : "";
$action = (!empty($_REQUEST['action'])) ? $_REQUEST['action'] : 'insert';

if (!isset($data[0])) {
  //$crdEqpData['DataTime'] = current_time('mysql');
} else {
  $crdEqpData = @$data[0];
}
?>

<div class="wrap">

  <form action="?page=/carody/eqp/eqp-index.php" method="post">

    <h3>Compila i seguenti campi</h3>
    <table class="form-table">
      <tbody>
        <tr>
          <th><label for="Marca">Marca</label></th>
          <td>
            <input type="text" value="<?php echo @$crdEqpData['marca']; ?>" tabindex="1" id="marca" name="marca" size="10">
            <div class="description">Marca dell'auto</div>
          </td>
        </tr>
        <tr>
          <th><label for="Modello">Modello</label></th>
          <td>
            <input type="text" value="<?php echo @$crdEqpData['modello']; ?>" tabindex="2" id="modello" name="modello" size="10">
            <div class="description">Modello dell'auto</div>
          </td>
        </tr>
        <tr>
          <th><label for="date">Capienza serbatoio</label></th>
          <td><input type="text" value="<?php echo @$crdEqpData['max_serbatoio_litri']; ?>" tabindex="2" id="max_serbatoio_litri" name="max_serbatoio_litri" size="3">Litri
            <div class="description">Capienza serbatoio</div></td>
        </tr>
        <tr>
          <th><label for="date">Consumo medio stimato</label></th>
          <td><input type="text" value="<?php echo @$crdEqpData['consumo_medio']; ?>" tabindex="3" id="consumo_medio" name="consumo_medio" size="4">Litri per km
            <div class="description">Indica qui il consumo medio</div></td>
        </tr>

      </tbody>
    </table>


    <p class="submit">
      <input type="hidden" name="do" value="<?php echo $action; ?>">
      <input type="hidden" name="id" value="<?php echo $_REQUEST['idMacchina'] ?>">
      <input type="reset" class="button" value="Reset">
      <input type="submit" value="<?php echo $action; ?>" class="button-primary" tabindex="5" accesskey="p" >
      <br class="clear">
    </p>



  </form>
</div>