<?php
add_action('admin_menu', 'register_carody_profile_page');
add_action('admin_menu', 'register_carody_fuel_index_page');
add_action('admin_menu', 'register_carody_events_index_page');
add_action('admin_menu', 'register_carody_eqp_index_page');



function register_carody_profile_page() {
	add_users_page('Modifica Auto', 'Modifica Auto', 'read', 'carody/profile/eqp-user-mgt.php', '');
}

function register_carody_fuel_index_page() {
  add_menu_page('DiarioRifornimenti', 'Diario rifornimenti', 'carody_read_report_fuel', 'carody/fuel/fuel-index.php', '', plugins_url('/carody/images/Fuel_Icon2.png'));
  add_submenu_page('carody/fuel/fuel-index.php', 'Almanacco', 'Tutti', 'carody_read_report_fuel', 'carody/fuel/fuel-index.php', '');
  add_submenu_page('carody/fuel/fuel-index.php', 'Add new', 'Nuovo', 'carody_edit_report_fuel', 'carody/fuel/fuel-mng.php', '');
}

function register_carody_eqp_index_page() {
  add_menu_page('ParcoMezzi', 'Parco dei mezzi', 'carody_read_eqp', 'carody/eqp/eqp-index.php', '', plugins_url('/carody/images/Garage_Icon.png'));
  add_submenu_page('carody/eqp/eqp-index.php', 'Almanacco', 'Tutti', 'carody_read_eqp', 'carody/eqp/eqp-index.php', '');
  add_submenu_page('carody/eqp/eqp-index.php', 'Nuovo', 'Nuovo', 'carody_edit_eqp', 'carody/eqp/eqp-mgt.php', '');
  add_submenu_page('carody/eqp/eqp-index.php', 'Seleziona', 'Seleziona', 'carody_edit_eqp', 'carody/eqp/eqp-assoc.php', '');
}

function register_carody_events_index_page() {
  add_menu_page('DiarioManutenzione', 'Diario manutenzione', 'carody_read_event', 'carody/events/event-index.php', '', plugins_url('/carody/images/Event_Icon.png'));
  add_submenu_page('carody/events/event-index.php', 'AlmanaccoInterventi', 'Lista interventi', 'carody_read_event', 'carody/events/event-index.php', '');
  add_submenu_page('carody/events/event-index.php', 'NuovoIntervento', 'Nuovo', 'carody_edit_event', 'carody/events/event-mgt.php', '');
  add_submenu_page('carody/events/event-index.php', 'PrevisioniIntervento', 'Previsioni', 'carody_edit_event', 'carody/todo-index.php', '');
}

?>