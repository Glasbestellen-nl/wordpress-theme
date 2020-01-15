<?php
class Transaction {

   const STATUSES = [
      'open',
      'pending',
      'authorized',
      'paid',
      'failed',
      'expired',
      'canceled'
   ];

   protected $post_id;

   public function __construct( int $post_id = null ) {

      if ( empty( $post_id ) ) {
         $this->generate();
         return;
      }
      $this->post_id = $post_id;
   }

   protected function generate() {

      $transaction_id = $this->generate_transaction_id();

      $args = [
         'post_title' => __( 'Transactie', 'glasbestellen' ) . ' #' . $transaction_id,
         'post_type' => 'transactie',
         'post_status' => 'publish'
      ];
      $this->post_id = wp_insert_post( $args );

      // Store transaction id
      update_post_meta( $this->post_id, 'transaction_id', $transaction_id );

      // Update payment status
      $this->update_status();

      return true;
   }

   public function update_billing_data( array $data = [] ) {
      update_post_meta( $this->post_id, 'transaction_billing_data', $data );
   }

   public function update_delivery_data( array $data = [] ) {
      update_post_meta( $this->post_id, 'transaction_delivery_data', $data );
   }

   /**
    * Updates client data like ip address and client id
    */
   public function update_client_data( array $data = [] ) {
      update_post_meta( $this->post_id, 'transaction_client_data', $data );
   }

   public function update_items( array $items = [] ) {
      update_post_meta( $this->post_id, 'transaction_items', $items );
   }

   public function update_status( string $status = 'open' ) {
      if ( ! $this->accept_status( $status ) ) return;
      update_post_meta( $this->post_id, 'transaction_status', $status );
   }

   public function update_total_price( $price = 0 ) {
      update_post_meta( $this->post_id, 'transaction_total_price', $price );
   }

   public function get_transaction_id() {
      return get_post_meta( $this->post_id, 'transaction_id', true );
   }

   public function get_post_id() {
      return $this->post_id;
   }

   public function get_status() {
      return get_post_meta( $this->post_id, 'transaction_status', true );
   }

   public function get_items() {
      return get_post_meta( $this->post_id, 'transaction_items', true );
   }

   public function get_billing_data( $meta_key = null ) {
      $data = get_post_meta( $this->post_id, 'transaction_billing_data', true );
      if ( empty( $meta_key ) ) {
         return ! empty( $data[$meta_key] ) ? $data[$meta_key] : false;
      }
      return $data;
   }

   public function get_delivery_data() {
      return get_post_meta( $this->post_id, 'transaction_delivery_data', true );
   }

   public function get_client_data( $meta_key = null ) {
      $data = get_post_meta( $this->post_id, 'transaction_client_data', true );
      if ( empty( $meta_key ) ) {
         return ! empty( $data[$meta_key] ) ? $data[$meta_key] : false;
      }
      return $data;
   }

   public function get_total_price() {
      return get_post_meta( $this->post_id, 'transaction_total_price', true );
   }

   /**
    * Returns highest shipping price of all items
    */
   public function get_total_shipping_price() {

      $shipping_price = 0;

      if ( ! $this->get_items() ) return $shipping_price;

      $shipping_price = max( array_map( function( $item ) {
         $settings = gb_get_configurator_settings( $item['post_id'] );
         return ! empty( $settings['shipping'] ) ? $settings['shipping'] : 0;
      },
      $this->get_items() ) );

      return $shipping_price;
   }

   public function generate_transaction_id( int $start = 200 ) {

      // Get transaction id from options table
      $transaction_id = ( get_option( 'transaction_id' ) ) ? get_option( 'transaction_id' ) : $start;

      // Update option each time the function is called
      update_option( 'transaction_id', $transaction_id + 1 );

      return $transaction_id;
   }

   public function accept_status( string $status ) {
      return in_array( $status, self::STATUSES );
   }

}
