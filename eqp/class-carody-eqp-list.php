<?php

if (!class_exists('Carody_Eqp_List')) {


  if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
  }

  class Carody_Eqp_List extends WP_List_Table {

    function __construct() {
      global $status, $page;

      //Set parent defaults
      parent::__construct(array(
                  'singular' => 'Mezzo', //singular name of the listed records
                  'plural' => 'Mezzi', //plural name of the listed records
                  'ajax' => false        //does this table support ajax?
              ));
    }

    /**
     *
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     * ************************************************************************ */
    function column_default($item, $column_name) {
      switch ($column_name) {
        case 'Marca':
        case 'Modello':
        case 'MaxSerbatoioLitri':
        case 'ConsumoMedio':
          return $item[$column_name];
        default:
          return print_r($item, true); //Show the whole array for troubleshooting purposes
      }
    }

    /**     * ***********************************************************************
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     * ************************************************************************ */
    function column_DataTime($item) {

      //Build row actions
      $actions = array(
          'edit' => sprintf('<a href="?page=%s&action=%s&fuelid=%s">Edit</a>', 'carody/eqp/eqp-mgt.php', 'edit', $item['idMacchina']),
          'delete' => sprintf('<a href="?page=%s&action=%s&fuelid=%s">Delete</a>', 'carody/eqp/eqp-mgt.php', 'delete', $item['idMacchina']),
      );

      //Return the title contents
      return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
              /* $1%s */ $item['Marca'],
              /* $2%s */ $item['idMacchina'],
              /* $3%s */ $this->row_actions($actions)
      );
    }

    /**     * ***********************************************************************
     *
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     * ************************************************************************ */
    function column_cb($item) {
      return sprintf(
              '<input type="checkbox" name="%1$s[]" value="%2$s" />',
              /* $1%s */ $this->_args['singular'], //Let's simply repurpose the table's singular label ("movie")
              /* $2%s */ $item['idMacchina']                //The value of the checkbox should be the record's id
      );
    }

    /**     * ***********************************************************************
     *
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a column_cb() method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     *
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     * ************************************************************************ */
    function get_columns() {
      $columns = array(
          'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
          'Marca' => 'Marca',
          'Modello' => 'Modello',
          'MaxSerbatoioLitri' => 'Capienza Serbatoio',
          'ConsumoMedio' => 'Consumo Medio',
      );
      return $columns;
    }

    /**     * ***********************************************************************
     *
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     * *********************************************************************** */
    function get_sortable_columns() {
      $sortable_columns = array(
          'Marca' => array('Marca', false),
          'Modello' => array('Modello', false),
          'MaxSerbatoioLitri' => array('Capienza Serbatoio', false),
          'ConsumoMedio' => array('Consumo Medio', false),
      );
      return $sortable_columns;
    }

    /**     * ***********************************************************************     *
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     * ************************************************************************ */
    function get_bulk_actions() {
      $actions = array(
          'delete' => 'Delete'
      );
      return $actions;
    }

    /**     * ***********************************************************************
     *
     * @see $this->prepare_items()
     * ************************************************************************ */
    function process_bulk_action() {

      //Detect when a bulk action is being triggered...
      if ('delete' === $this->current_action()) {
        wp_die('Items deleted (or they would be if we had items to delete)!');
      }
    }

    /**     * ***********************************************************************
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     * ************************************************************************ */
    function prepare_items() {

      /**
       * First, lets decide how many records per page to show
       */
      $per_page = 5;


      /**
       * REQUIRED. Now we need to define our column headers. This includes a complete
       * array of columns to be displayed (slugs & titles), a list of columns
       * to keep hidden, and a list of columns that are sortable. Each of these
       * can be defined in another method (as we've done here) before being
       * used to build the value for our _column_headers property.
       */
      $columns = $this->get_columns();
      $hidden = array();
      $sortable = $this->get_sortable_columns();


      /**
       * REQUIRED. Finally, we build an array to be used by the class for column
       * headers. The $this->_column_headers property takes an array which contains
       * 3 other arrays. One for all columns, one for hidden columns, and one
       * for sortable columns.
       */
      $this->_column_headers = array($columns, $hidden, $sortable);


      /**
       * Optional. You can handle your bulk actions however you see fit. In this
       * case, we'll handle them within our package just to keep things clean.
       */
      $this->process_bulk_action();


      /**
       * Instead of querying a database, we're going to fetch the example data
       * property we created for use in this plugin. This makes this example
       * package slightly different than one you might build on your own. In
       * this example, we'll be using array manipulation to sort and paginate
       * our data. In a real-world implementation, you will probably want to
       * use sort and pagination data to build a custom query instead, as you'll
       * be able to use your precisely-queried data immediately.
       */
      $data = $this->get_eqp_data_from_db();

      /**
       * This checks for sorting input and sorts the data in our array accordingly.
       *
       * In a real-world situation involving a database, you would probably want
       * to handle sorting by passing the 'orderby' and 'order' values directly
       * to a custom query. The returned data will be pre-sorted, and this array
       * sorting technique would be unnecessary.
       */
      function usort_reorder($a, $b) {
        $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'Marca'; //If no sort, default to title
        $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
        $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
        return ($order === 'asc') ? $result : -$result; //Send final sort direction to usort
      }

      usort($data, 'usort_reorder');



      /**
       * REQUIRED for pagination. Let's figure out what page the user is currently
       * looking at. We'll need this later, so you should always include it in
       * your own package classes.
       */
      $current_page = $this->get_pagenum();

      /**
       * REQUIRED for pagination. Let's check how many items are in our data array.
       * In real-world use, this would be the total number of items in your database,
       * without filtering. We'll need this later, so you should always include it
       * in your own package classes.
       */
      $total_items = count($data);


      /**
       * The WP_List_Table class does not handle pagination for us, so we need
       * to ensure that the data is trimmed to only the current page. We can use
       * array_slice() to
       */
      $data = array_slice($data, (($current_page - 1) * $per_page), $per_page);



      /**
       * REQUIRED. Now we can add our *sorted* data to the items property, where
       * it can be used by the rest of the class.
       */
      $this->items = $data;


      /**
       * REQUIRED. We also have to register our pagination options & calculations.
       */
      $this->set_pagination_args(array(
          'total_items' => $total_items, //WE have to calculate the total number of items
          'per_page' => $per_page, //WE have to determine how many items to show on a page
          'total_pages' => ceil($total_items / $per_page)   //WE have to calculate the total number of pages
      ));
    }

    static function get_eqp_data_from_db($idMacchina = null) {
      global $wpdb;
      $sql = "SELECT `idMacchina`,`Marca`,`Modello`,`MaxSerbatoioLitri`,`ConsumoMedio`FROM `" . $wpdb->prefix . "Macchina` ";
      if ($idMacchina != null) {
        $sql .= " WHERE `idMacchina` = ".$idMacchina." ";
      }
      $out = $wpdb->get_results($sql, ARRAY_A);
      return $out;
    }

    function show($id) {
      $this->prepare_items();
      echo '<form id="' . $id . '-filter" method="get"><input type="hidden" name="page" value="' . $_REQUEST['page'] . '" />';
      $this->display();
      echo '</form>';
    }

  }

}
?>
