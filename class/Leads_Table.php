<?php
class Leads_Table extends WP_List_Table {

   public function __construct() {
      parent::__construct();
      $this->prepare_items();
      $this->screen = get_current_screen();
   }

   /**
    * Prepare the items for the table to process
    *
    * @return Void
    */
   public function prepare_items() {

      $columns   = $this->get_columns();
      $hidden    = $this->get_hidden_columns();
      $sortable  = $this->get_sortable_columns();

      $data = $this->table_data();
      usort( $data, array( &$this, 'sort_data' ) );

      // Search
      $s = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST['s'] ) ) : '';
      if ( $s ) {
         $data = $this->filter_data( $data, $s );
      }

      $per_page    = 20;
      $currentPage = $this->get_pagenum();
      $total_items = count( $data );

      $this->set_pagination_args( array(
         'total_items' => $total_items,
         'per_page'    => $per_page
      ));

      $data = array_slice( $data,( ( $currentPage - 1 ) * $per_page ), $per_page );
      $this->_column_headers = array( $columns, $hidden, $sortable );
      $this->items = $data;

   }

   /**
   * Filters table date by search query
   *
   * @return Array
   */
   private function filter_data( $data, $s ) {
      $filtered_data = array_values( array_filter( $data, function( $row ) use( $s ) {
         foreach ( $row as $value ) {
            if ( stripos( $value, $s ) !== false ) {
   				return true;
   			}
         }
      }));
      return $filtered_data;
   }

   /**
   * Override the parent columns method. Defines the columns to use in your listing table
   *
   * @return Array
   */
   public function get_columns() {

      $columns = array(
         'cb'           => __( 'Selecteer alles', 'glasbestellen' ),
         'name'         => __( 'Naam', 'glasbestellen' ),
         'owner'        => __( 'Beheerder', 'glasbestellen' ),
         'status'       => __( 'Status', 'glasbestellen' ),
         'date'         => __( 'Datum', 'glasbestellen' ),
         'email'        => __( 'Email', 'glasbestellen' ),
         'phone'        => __( 'Telefoonnummer', 'glasbestellen' ),
         'residence'    => __( 'Woonplaats', 'glasbestellen' ),
         'configuration'=> __( 'Configuratie', 'glasbestellen' ),
         'request_uri'  => __( 'URL', 'glasbestellen' ),
      );

     // If admin show extra columns
      if ( current_user_can( 'administrator' ) ) {
         $columns['gclid'] = __( 'GCLID', 'glasbestellen' );
         $columns['client_id'] = __( 'Client ID', 'glasbestellen' );
         $columns['data_pushed'] = __( 'DP', 'glasbestellen' );
      }

      return $columns;
   }

   /**
    * Define what data to show on each column of the table
    *
    * @param  Array $item        Data
    * @param  String $column_name - Current column name
    *
    * @return Mixed
   */
   public function column_default( $item, $column_name ) {

      switch ( $column_name ) {
         case 'name' :
            return $this->get_name_column_html( $item, $column_name );
            break;
         case 'owner' :
         case 'status' :
         case 'date' :
         case 'email' :
         case 'phone' :
         case 'residence' :
            if ( isset( $item[$column_name] ) ) {
               return $item[$column_name];
            }
            break;
         case 'configuration' :
            $configurator = CRM::get_lead_meta( $item['lead_id'], 'saved_configurator', true );
            if ( $configurator ) {
               return '<span class="dashicons dashicons-yes-alt" style="color: green;"></span>';
            }
            break;
         case 'request_uri' :
            $request_uri = CRM::get_lead_meta( $item['lead_id'], 'request_uri', true );
            if ( $request_uri ) {
               $parsed = parse_url( $request_uri );
               if ( ! empty( $parsed['path'] ) ) return $parsed['path'];
            }
            break;
         case 'gclid' :
            $gclid = CRM::get_lead_meta( $item['lead_id'], 'ads_gclid', true );
            if ( $gclid ) {
               return '<span class="dashicons dashicons-yes-alt" style="color: green;"></span>';
            }
            break;
         case 'client_id' :
            $client_id = CRM::get_lead_meta( $item['lead_id'], 'gclid', true );
            if ( $client_id ) {
               return '<span class="dashicons dashicons-yes-alt" style="color: green;"></span>';
            }
            break;      
         case 'data_pushed' :
            $data_pushed = CRM::get_lead_meta( $item['lead_id'], 'conversion_data_pushed', true );
            if ( $data_pushed ) {
               return '<span class="dashicons dashicons-yes-alt" style="color: green;"></span>';
            }
            break;
         default :
            return print_r( $item, true ) ;
      }
   }

   /**
    * Get the table data
    *
    * @return Array
    */
   private function table_data() {

      $data = array();

      $leads = CRM::get_leads();

      if ( ! empty( $leads ) ) {

         foreach ( $leads as $lead ) {
            $owner = get_user_by( 'id', $lead->lead_owner );
            $date = date_create( $lead->lead_date );
            $row = [
               'lead_id'    => $lead->lead_id,
               'name'       => $lead->relation_name,
               'owner'      => isset( $owner->display_name ) ? $owner->display_name : '-',
               'status'     => CRM::get_status_label( $lead->lead_status ),
               'date'       => date_format( $date, 'd M Y H:i' ),
               'date_time'  => date_format( $date, 'YmdHi' ),
               'email'      => $lead->relation_email,
               'phone'      => get_user_meta( $lead->lead_relation, 'user_phone', true ),
               'residence'  => get_user_meta( $lead->lead_relation, 'user_residence', true )
            ];
            $data[] = $row;
         }
      }

      return $data;
   }

   /**
    * @param object $item
    */
   public function column_cb( $item ) {
      return '<input type="checkbox" name="lead[' . $item['lead_id'] . ']" id="lead-' . $item['lead_id'] . '" value="checked" />';
   }

   /**
    * Get an associative array ( option_name => option_title ) with the list
    * of bulk actions available on this table.
    *
    * @since 3.1.0
    *
    * @return array
    */
   protected function get_bulk_actions() {
      $actions = [
         'delete' => __( 'Verwijderen', 'glasbestellen' )
      ];
      return $actions;
   }

   /**
    * Allows you to sort the data by the variables set in the $_GET
    *
    * @return Mixed
    */
   private function sort_data( $a, $b ) {

      // Set defaults
      $orderby = 'date_time';
      $order = 'desc';

      // If orderby is set, use this as the sort column
      if ( ! empty( $_GET['orderby'] ) ) {
         $orderby = $_GET['orderby'];
      }

      // If order is set use this as the order
      if ( ! empty( $_GET['order'] ) ) {
         $order = $_GET['order'];
      }

      $result = strcmp( $a[$orderby], $b[$orderby] );
      if ( $order === 'asc' ) {
         return $result;
      }
      return - $result;

   }

   /**
   * Define which columns are hidden
   *
   * @return Array
   */
   public function get_hidden_columns() {
      return array();
   }

   /**
   * Define the sortable columns
   *
   * @return Array
   */
   public function get_sortable_columns(){
      return array(
         'name' => array( 'name', false ),
         'owner' => array( 'owner', false ),
         'status' => array( 'status', false ),
         'date' => array( 'date_time', false ),
         'email' => array( 'email', false ),
         'residence' => array( 'residence', false )
      );
   }

   public function get_name_column_html( $item, $column_name ) {

      if ( empty( $item ) || empty( $column_name ) ) return;

      $crm = new CRM();

      $edit_link   = admin_url( 'admin.php?page=crm&lead_id=' . $item['lead_id'] );
      $delete_link = admin_url( 'admin.php?page=crm&lead_id=' . $item['lead_id'] . '&action=delete' );
      $actions = [
         'edit'    => '<a href="' . $edit_link . '">' . __( 'Bewerken', 'glasbestellen' ) . '</a>',
         'delete'  => '<a href="' . $delete_link . '" class="js-lead-row-delete-link">' . __( 'Verwijderen', 'glasbestellen' ) . '</a>'
      ];
      $html = '';
      $html .= '<div class="js-someone-editing js-someone-editing-' . $item['lead_id'] . '" data-lead-id="' . $item['lead_id'] . '" style="display: none;"><span class="dashicons dashicons-warning"></span> ' . __( 'Iemand anders is aan het bewerken.', 'glasbestellen' ) . '</div>';
      $html .= '<strong><a href="' . $edit_link . '">' . $item[$column_name] . '</a></strong>';
      $html .= $this->row_actions( $actions );

      return $html;
   }

}
