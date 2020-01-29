<?php
namespace Offline_Conversion_Tracking;

class Conversion_Data {

   protected $data = [];

   public function __construct( $data = [] ) {

      if ( empty( $data ) ) return;

      if ( ! empty( $data['revenue'] ) )
         $this->set_revenue( $data['revenue'] );

      if ( ! empty( $data['shipping_price'] ) )
         $this->set_shipping_price( $data['shipping_price'] );

      if ( ! empty( $data['items'] ) ) {
         foreach ( $data['items'] as $item ) {
            $this->add_item( $item['name'], $item['price'], $item['quantity'] );
         }
      }
   }

   public function set_revenue( float $value = 0 ) {
      $this->data['revenue'] = $value;
   }

   public function set_shipping_price( float $value = 0 ) {
      $this->data['shipping_price'] = $value;
   }

   public function add_item( string $name = '', float $price = 0, int $quantity = 1 ) {
      $item = [
         'name'     => $name,
         'price'    => $price,
         'quantity' => $quantity
      ];
      $this->data['items'][] = $item;
      return true;
   }

   public function get_revenue() {
      return $this->get_data( 'revenue' );
   }

   public function get_shipping_price() {
      return $this->get_data( 'shipping_price' );
   }

   public function get_items() {
      return $this->get_data( 'items' );
   }

   public function get_data( $key = '' ) {
      if ( empty( $key ) ) return $this->data;
      return isset( $this->data[$key] ) ? $this->data[$key] : false;
   }

}
