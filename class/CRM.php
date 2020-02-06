<?php
class CRM {

   // Is the init method already called
   private static $initialised = false;

   // Hold wordpress database object
   private static $wpdb;

   // Leads table with prefix
   private static $leads_table;

   // Lead meta table with prefix
   private static $leadmeta_table;

   // Holds available lead statuses
   private static $statuses;

   /**
    * Sets properties
    */
   private static function init() {

      if ( ! self::$initialised ) {

         global $wpdb;

         self::$wpdb = $wpdb;

         self::$leads_table = $wpdb->prefix . 'leads';
         self::$leadmeta_table = $wpdb->prefix . 'leadmeta';

         self::$statuses = [
            'open'       => __( 'Open', 'glasbestellen' ),
            'wait'       => __( 'Afwachten', 'glasbestellen' ),
            'answered'   => __( 'Beantwoord', 'glasbestellen' ),
            'quote'      => __( 'Offerte', 'glasbestellen' ),
            'order'      => __( 'Order', 'glasbestellen' )
         ];

         self::$initialised = true;
      }

   }

   /**
    * Returns lead by lead id
    *
    * @param int $lead_id database row id
    */
   public static function get_lead( $lead_id ) {

      if ( empty( $lead_id ) )
         return;

      self::init();

      $lead_data = self::$wpdb->get_row(
         self::$wpdb->prepare(
            "SELECT * FROM " . self::$leads_table . " WHERE lead_id = %d",
            $lead_id
         )
      );
      return new Lead( $lead_data, self::get_lead_custom( $lead_id ) );

   }

   /**
    * Returns all the lead rows from database
    */
   public static function get_leads( $where = '' ) {

      self::init();

      $leads = false;

      $query = "SELECT * FROM " . self::$leads_table . "";
      if ( isset( $where ) ) {
         $query .= " " . $where;
      }

      $rows = self::$wpdb->get_results( $query );
      if ( ! empty( $rows ) ) {
         foreach ( $rows as $lead_data ) {
            $leads[] = new Lead( $lead_data, self::get_lead_custom( $lead_data->lead_id ) );
         }
      }
      return $leads;
   }

   public static function get_leads_by_status( $status = 'order' ) {

      self::init();

      $leads = false;

      $query = "
         SELECT *
         FROM " . self::$leads_table . " l
         JOIN " . self::$leadmeta_table . " m ON m.lead_id = l.lead_id
         WHERE m.meta_key = 'lead_status' AND m.meta_value = '$status';
      ";
      $rows = self::$wpdb->get_results( $query );
      if ( ! empty( $rows ) ) {
         foreach ( $rows as $lead_data ) {
            $leads[] = new Lead( $lead_data, self::get_lead_custom( $lead_data->lead_id ) );
         }
      }
      return $leads;
   }

   /**
    * Returns lead meta data by lead id
    *
    * @param int $lead_id database row id
    */
   public static function get_lead_custom( $lead_id ) {

      if ( empty( $lead_id ) )
         return;

      self::init();

      return self::$wpdb->get_results(
         self::$wpdb->prepare(
            "SELECT * FROM " . self::$leadmeta_table . " WHERE lead_id = %d",
            $lead_id
         )
      );
   }

   /**
    * Insert lead into database
    *
    * @param array $lead_data an array of lead data containing
    * name, email, content, phone, residence
    */
   public static function insert_lead( $lead_data = [] ) {

      self::init();

      if ( empty( $lead_data['name'] ) || empty( $lead_data['email'] ) )
         return;

      // Create or get relation (user)
      if ( email_exists( $lead_data['email'] ) ) {
         $relation_id = get_user_by( 'email', $lead_data['email'] )->ID;
      } else {
         $relation_id = self::insert_relation( $lead_data['email'], $lead_data['name'] );
      }

      // Insert lead
      self::$wpdb->insert( self::$leads_table,
         array(
            'lead_relation'   => $relation_id,
            'lead_content'    => sanitize_textarea_field( $lead_data['content'] ),
            'lead_date'       => current_time( 'mysql' )
         )
      );
      $lead_id = self::$wpdb->insert_id;

      self::update_lead_status( $lead_id, 'open' );

      // Update relation data
      wp_update_user( ['ID' => $relation_id, 'display_name' => $lead_data['name']] );

      $relation_data = [];
      if ( ! empty( $lead_data['phone'] ) )
         $relation_data['user_phone'] = $lead_data['phone'];

      if ( ! empty( $lead_data['residence'] ) )
         $relation_data['user_residence'] = $lead_data['residence'];

      self::update_relation_meta( $relation_id, $relation_data );

      /* Store all lead data (except the content) to be sure, because relation data is stored
       * under user and can be changed when using same email address while inserting a new lead. */
      self::update_lead_meta( $lead_id, 'lead_data', array_filter( $lead_data, function( $key ) {
         return $key !== 'content';
      }, ARRAY_FILTER_USE_KEY ));

      return $lead_id;
   }

   /**
    * Updates lead from database
    *
    * @param int $lead_id database row id
    * @param array $lead_data an array of lead data containing
    * name, email, content, phone, residence
    */
   public static function update_lead( $lead_id, $lead_data = [] ) {
   }

   public static function delete_lead( $lead_id ) {

      self::init();

      if ( empty( $lead_id ) )
         return;

      // Delete lead itself
      self::$wpdb->delete( self::$leads_table, [
         'lead_id' => $lead_id,
      ]);

      // Delete lead meta
      self::delete_lead_meta( $lead_id );

      // Delete lead attachments
      $target = gb_get_lead_attachments_dir() . '/' . $lead_id;
      gb_delete_files( $target );

      return true;

   }

   /**
    * Returns lead meta by lead id and meta key
    *
    * @param int $lead_id database row id
    * @param string $meta_key key in meta data table
    */
   public static function get_lead_meta( $lead_id, $meta_key, $single = false ) {

      self::init();

      if ( empty( $lead_id ) )
         return;

      $row = self::$wpdb->get_row(
         self::$wpdb->prepare(
            "SELECT * FROM wp_leadmeta WHERE lead_id = %d AND meta_key = %s",
            $lead_id, $meta_key
         )
      );
      if ( empty( $row ) ) return false;

      if ( $single ) {
         return ( @unserialize( $row->meta_value ) !== false ) ? unserialize( $row->meta_value ) : $row->meta_value;
      }
      return $row;
   }

   /**
    * Updates lead meta row
    *
    * @param int $lead_id database row id
    * @param string $meta_key key in meta data table
    * @param string $meta_value the new value
    */
   public static function update_lead_meta( $lead_id, $meta_key, $meta_value ) {

      self::init();

      if ( empty( $lead_id ) )
         return;

      if ( is_array( $meta_value ) )
         $meta_value = serialize( $meta_value );

      if ( self::get_lead_meta( $lead_id, $meta_key ) ) {

         $data  = [
            'meta_value' => $meta_value
         ];
         $where = [
            'lead_id' => $lead_id,
            'meta_key' => $meta_key
         ];
         self::$wpdb->update( self::$leadmeta_table, $data, $where );

      } else {

         self::$wpdb->insert( self::$leadmeta_table,
            array(
               'lead_id'     => $lead_id,
               'meta_key'    => $meta_key,
               'meta_value'  => $meta_value
            )
         );
      }
      return true;
   }

   /**
    * Deletes lead meta row
    *
    * @param int $lead_id database row id
    * @param string $meta_key key in meta data table
    */
   public static function delete_lead_meta( $lead_id, $meta_key = '' ) {

      self::init();

      if ( empty( $lead_id ) )
         return;

      $where['lead_id'] = $lead_id;

      if ( ! empty( $meta_key ) ) {
         $where['meta_key'] = $meta_key;
      }

      self::$wpdb->delete( self::$leadmeta_table, $where );

   }

   /**
    * Updates lead owner in meta data table
    *
    * @param int $lead_id database row id
    * @param int $owner user id of lead owner
    */
   public static function update_lead_owner( $lead_id, $owner ) {

      self::init();

      if ( empty( $lead_id ) )
         return;

      if ( ! empty( $owner ) ) {
         self::update_lead_meta( $lead_id, 'lead_owner', $owner );
      }

      return true;

   }

   /**
    * Updates lead status
    *
    * @param int $lead_id database row id
    * @param string $status the new lead status
    */
   public static function update_lead_status( $lead_id, $status = 'open' ) {

      self::init();

      if ( empty( $lead_id ) )
         return;

      // Check whether is a valid status
      if ( ! self::accept_status( $status ) ) return;

      self::update_lead_meta( $lead_id, 'lead_status', $status );
      return true;
   }

   /**
    * Returns label by status key from statuses array
    *
    * @param string $status the lead status key
    */
   public static function get_status_label( $status ) {

      if ( empty( $status ) )
         return;

      self::init();
      $statuses  = self::get_lead_statuses();
      return ! empty( $statuses[$status] ) ? $statuses[$status] : false;

   }

   /**
    * Returns available lead statuses
    */
   public static function get_lead_statuses() {
      self::init();
      return ! empty( self::$statuses ) ? self::$statuses : false;
   }

   /**
    * Returns an array of relation objects
    */
   public static function get_relations() {

      $relations = false;
      $args = [
         'role' => 'relation'
      ];
      if ( $users = get_users( $args ) ) {
         foreach ( $users as $user ) {
            $relations[] = new Relation( $user->ID );
         }
      }
      return $relations;

   }

   /**
    * Updates relation metadata
    *
    * @param int $relation_id user id
    * @param array $relation_data array of fields that should be updated
    */
   public static function update_relation_meta( $relation_id, $relation_data = [] ) {

      if ( empty( $relation_id ) )
         return;

      if ( ! empty( $relation_data ) ) {
         foreach ( $relation_data as $meta_key => $meta_value ) {
            update_user_meta( $relation_id, $meta_key, $meta_value );
         }
      }
      return true;

   }

   /**
    * Inserts wordpress user with relation role
    *
    * @param string $email user email
    * @param string $name user display name
    */
   public static function insert_relation( $email, $name ) {

      $userdata = [
         'user_email'    => $email,
         'user_login'    => $email,
         'display_name'  => $name,
         'user_pass'     => $random_password = wp_generate_password( 12, false ),
         'role'          => 'relation',
      ];
      return wp_insert_user( $userdata );

   }

   /**
    * Returns all user with no 'relation' role
    */
   public static function get_owners() {

      $owners = false;
      $args = [
         'role__not_in' => ['relation']
      ];
      return get_users( $args );

   }

   public static function accept_status( string $status ) {
      return in_array( $status, array_keys( self::$statuses ) );
   }

}
