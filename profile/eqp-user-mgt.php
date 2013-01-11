<?php
// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
    exit;
}

require_once( CARODY_DIR . '/eqp/class-carody-eqp-mgr.php');

function is_update_of_carody_eqp_user() {
    global $_POST;
    $out = false;
    if (isset($_POST['do']) && ($_POST['do'] == "insert" || $_POST['do'] == "edit") ) {
        $out = true;
    } else {
        $out = false;
    }
    return $out;
}

/**
 * Eseguo l'insert o l'update dell'auto associata all'utente:
 *    Esiste ID AUTO?
 *    SI:
 *       Faccio solo update
 *    NO:
 *       Faccio insert e dato l'id eseguo l'assoc
 * 
 * @param type $_REQUEST
 */
function do_update_of_carody_eqp_user($request) {

    $carody_eqp_mgr = new Carody_Eqp_Mgr();
    if (!isset($request['id']) || $request['id'] != "") {
        //Faccio solo update
        $request['do'] = 'edit';
        $carody_eqp_mgr->applayAction($request);
    } else {
        include_once ( CARODY_DIR . '/eqp/class-carody-eqp-assoc.php');
        //Faccio insert e dato l'idMacchina eseguo l'assoc
        $request['do'] = 'insert';
        $request_assoc['idMacchine'] = $carody_eqp_mgr->insert_action($request);
        $request_assoc['id'] = get_current_user_id();
        $carody_eqp_assoc = new Carody_Eqp_Assoc();
        $carody_eqp_assoc->Associa_action($request_assoc);
    }
}

if (is_update_of_carody_eqp_user()) {
    global $_POST;
    do_update_of_carody_eqp_user($_POST);
}

/**
 *    Esiste un auto associata all'utente?
 *    SI:
 *       Scrivi i dati della macchina e imposta action edit 
 *    NO:
 *       Settare la action = 'insert'
 */
$my_cars = new Carody_Eqp_Assoc();
$idsAssocs = $my_cars->get_eqp_ids_from_db();

if (isset($idsAssocs[0])) {
    include_once( CARODY_DIR . '/eqp/class-carody-eqp-list.php');
    $data = Carody_Eqp_List::get_eqp_data_from_db($idsAssocs[0]['Macchina_idMacchina']);
}

if (isset($data[0])) {
    $crdEqpData = @$data[0];
    $action = 'edit';
} else {
    $action = 'insert';
}
?>

<div class="wrap">
    <?php screen_icon(); ?><h2>Auto</h2>
    <h3>Compila i seguenti campi</h3>
    <form action="?page=/carody/profile/eqp-user-mgt.php" method="post">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="Marca">Marca</label></th>
                    <td>
                        <input type="text" value="<?php echo @$crdEqpData['Marca']; ?>" tabindex="1" id="Marca" name="Marca" size="50">
                        <div class="description">Marca dell'auto</div>
                    </td>
                </tr>
                <tr>
                    <th><label for="Modello">Modello</label></th>
                    <td>
                        <input type="text" value="<?php echo @$crdEqpData['Modello']; ?>" tabindex="2" id="Modello" name="Modello" size="50">
                        <div class="description">Modello dell'auto</div>
                    </td>
                </tr>
                <tr>
                    <th><label for="MaxSerbatoioLitri">Capienza serbatoio</label></th>
                    <td><input type="text" value="<?php echo @$crdEqpData['MaxSerbatoioLitri']; ?>" tabindex="2" id="MaxSerbatoioLitri" name="MaxSerbatoioLitri" size="3">Litri
                        <div class="description">Capienza serbatoio</div></td>
                </tr>
                <tr>
                    <th><label for="ConsumoMedio">Consumo medio stimato</label></th>
                    <td><input type="text" value="<?php echo @$crdEqpData['ConsumoMedio']; ?>" tabindex="3" id="ConsumoMedio" name="ConsumoMedio" size="4">Litri per km
                        <div class="description">Indica qui il consumo medio</div></td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="hidden" name="do" value="<?php echo $action; ?>">
            <input type="hidden" name="id" value="<?php echo @$crdEqpData['idMacchina'] ?>">
            <input type="submit" value="<?php echo Carody_Eqp_Mgr::commandToLabel($action); ?>" class="button-primary" tabindex="5" accesskey="p" >
            <input type="reset" class="button" value="Reset">
            <br class="clear">
        </p>
    </form>
</div>