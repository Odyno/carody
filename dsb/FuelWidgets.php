<?php




// Create the function use in the action hook

function carody_dashboard_widgets() {
    	wp_add_dashboard_widget('carody_dashboard_fuel_widget', 'Fuel Dashboard Widget', 'carody_dashboard_fuel_widget_function');
        wp_add_dashboard_widget('prezzi_benzina_rss_widget', 'RSS Prezzi Benzina', 'prezzi_benzina_rss_widget_function');
}


// Hook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'carody_dashboard_widgets' ); // Hint: For Multisite Network Admin Dashboard use wp_network_dashboard_setup instead of wp_dashboard_setup.
?>
