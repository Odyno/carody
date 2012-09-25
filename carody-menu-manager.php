<?php

add_action('admin_menu', 'register_carody_fuel_index_page');

function register_carody_fuel_index_page() {
  add_menu_page('Fuel', 'Rifornimenti', 'carody_read', 'carody/fuel/fuel-index.php', '', plugins_url('carody/images/Fuel_Icon.png'), 6);
  add_submenu_page('carody/fuel/fuel-index.php', 'Almanacco', 'Tutti', 'carody_read', 'carody/fuel/fuel-index.php', '');
  add_submenu_page('carody/fuel/fuel-index.php', 'Add new', 'Nuovo', 'carody_read', 'carody/fuel/fuel-mng.php', '');
}

?>
