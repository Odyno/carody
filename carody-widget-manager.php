<?php


require_once CARODY_DIR. '/dsb/class-carody-prezzi-benzina-widget.php';
require_once CARODY_DIR. '/dsb/class-carody-quick-fuel-widget.php';
require_once CARODY_DIR. '/dsb/class-carody-timeline-widget.php';


// Create the function to remove last Widget
function remove_dashboard_default_widgets() {
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
}

// Hoook into the 'wp_dashboard_setup' action to register the remove function
add_action('wp_dashboard_setup', 'remove_dashboard_default_widgets' );



add_action('wp_dashboard_setup', 'Carody_Timeline_Widget::attach');


add_action('wp_dashboard_setup', 'Carody_Quick_Fuel_Widget::attach');


add_action('wp_dashboard_setup', 'Carody_Prezzi_Benzina_Widget::attach');



?>
