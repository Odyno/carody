<?php

if (!class_exists("Carody_Prezzi_Benzina_Widget")) :

  class Carody_Prezzi_Benzina_Widget {

    static function attach() {
      wp_add_dashboard_widget(
              'Carody_Prezzi_Benzina_Widget_Id',
              'PrezziBenzina News',
              array('Carody_Prezzi_Benzina_Widget', 'show'));
    }

    function show() {
      echo '<div class="rss-widget">';

      wp_widget_rss_output(array(
          'url' => 'http://feeds.feedburner.com/prezzibenzina', //put your feed URL here
          'title' => 'Prezzi Benzina', // Your feed title
          'items' => 4, //how many posts to show
          'show_summary' => 1, // 0 = false and 1 = true
          'show_author' => 0,
          'show_date' => 1
      ));
      echo "</div>";
    }

    

  }

  endif;
?>
