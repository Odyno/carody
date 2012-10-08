<?php

add_action('admin_menu', 'register_carody_fuel_index_page');
add_action('admin_menu', 'register_carody_eqp_index_page');
add_action('admin_menu', 'register_carody_events_index_page');


function register_carody_fuel_index_page() {
  add_menu_page('Fuel', 'Rifornimenti', 'carody_read', 'carody/fuel/fuel-index.php', '', plugins_url('/carody/images/Fuel_Icon.png'), 6);
  add_submenu_page('carody/fuel/fuel-index.php', 'Almanacco', 'Tutti', 'carody_read', 'carody/fuel/fuel-index.php', '');
  add_submenu_page('carody/fuel/fuel-index.php', 'Add new', 'Nuovo', 'carody_read', 'carody/fuel/fuel-mng.php', '');
}

function register_carody_eqp_index_page() {
  add_menu_page('Mezzi', 'Mezzi', 'carody_read', 'carody/eqp/eqp-index.php', '', plugins_url('/carody/images/Fuel_Icon.png'), 7);
  add_submenu_page('carody/eqp/eqp-index.php', 'Almanacco', 'Tutti', 'carody_read', 'carody/eqp/eqp-index.php', '');
  add_submenu_page('carody/eqp/eqp-index.php', 'Nuovo', 'Nuovo', 'carody_read', 'carody/eqp/eqp-mgt.php', '');
  add_submenu_page('carody/eqp/eqp-index.php', 'Seleziona', 'Seleziona', 'carody_read', 'carody/eqp/eqp-assoc.php', '');
}


function register_carody_events_index_page() {
  add_menu_page('Garage', 'Garage', 'carody_read', 'carody/todo-index.php', '', plugins_url('/carody/images/Fuel_Icon.png'), 8);
  add_submenu_page('carody/todo-index.php', 'AlmanaccoInterventi', 'Lista interventi', 'carody_read', 'carody/todo-index.php', '');
  add_submenu_page('carody/todo-index.php', 'NuovoIntervento', 'Nuovo', 'carody_read', 'carody/todo-index.php', '');
  add_submenu_page('carody/todo-index.php', 'PrevisioniIntervento', 'Previsioni', 'carody_read', 'carody/todo-index.php', '');
}

?>