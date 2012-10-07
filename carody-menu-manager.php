<?php

add_action('admin_menu', 'register_carody_fuel_index_page');
add_action('admin_menu', 'register_carody_eqp_index_page');


function register_carody_fuel_index_page() {
  add_menu_page('Fuel', 'Rifornimenti', 'carody_read', 'carody/fuel/fuel-index.php', '', plugins_url('/carody/images/Fuel_Icon.png'), 6);
  add_submenu_page('carody/fuel/fuel-index.php', 'Almanacco', 'Tutti', 'carody_read', 'carody/fuel/fuel-index.php', '');
  add_submenu_page('carody/fuel/fuel-index.php', 'Add new', 'Nuovo', 'carody_read', 'carody/fuel/fuel-mng.php', '');
}

function register_carody_eqp_index_page() {
  add_menu_page('Mezzi', 'Mezzi', 'carody_read', 'carody/eqp/eqp-index.php', '', plugins_url('/carody/images/Fuel_Icon.png'), 7);
  add_submenu_page('carody/eqp/eqp-index.php', 'Almanacco', 'Tutti', 'carody_read', 'carody/eqp/eqp-index.php', '');
  add_submenu_page('carody/eqp/eqp-index.php', 'Nuovo', 'Nuovo', 'carody_read', 'carody/eqp/eqp-mgt.php', '');
  add_submenu_page('carody/eqp/eqp-index.php', 'Associa', 'Associa', 'carody_read', 'carody/eqp/eqp-assoc.php', '');
}


?>
