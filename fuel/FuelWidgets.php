<?php
// Create the function to output the contents of our Dashboard Widget
function carody_dashboard_fuel_widget_function() {
	// Display whatever it is you want to show
	//echo "Hello World, I'm a great Dashboard Widget";
    include('fuel-mng.php');
}


function prezzi_benzina_rss_widget_function(){
    echo '<div class="rss-widget">';

       wp_widget_rss_output(array(
            'url' => 'http://feeds.feedburner.com/prezzibenzina',  //put your feed URL here
            'title' => 'Prezzi Benzina', // Your feed title
            'items' => 4, //how many posts to show
            'show_summary' => 1, // 0 = false and 1 = true
            'show_author' => 0,
            'show_date' => 1
       ));

       echo "</div>";
}

// Create the function use in the action hook

function carody_dashboard_widgets() {
    	wp_add_dashboard_widget('carody_dashboard_fuel_widget', 'Fuel Dashboard Widget', 'carody_dashboard_fuel_widget_function');
        wp_add_dashboard_widget('prezzi_benzina_rss_widget', 'RSS Prezzi Benzina', 'prezzi_benzina_rss_widget_function');
}


// Create the function to use in the action hook

function remove_dashboard_default_widgets() {
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
}

// Hoook into the 'wp_dashboard_setup' action to register our function
add_action('wp_dashboard_setup', 'remove_dashboard_default_widgets' );

// Hook into the 'wp_dashboard_setup' action to register our other functions

add_action('wp_dashboard_setup', 'carody_dashboard_widgets' ); // Hint: For Multisite Network Admin Dashboard use wp_network_dashboard_setup instead of wp_dashboard_setup.
?>
