<?php
namespace Configurator;

class Option {

   protected $_data;

   protected $_default_price;

   public function __construct( array $data = [], float $default_price = 0 ) {
      $this->_data = $data;
      $this->_default_price = $default_price;
   }

   public function get_title() {
      return $this->get_field( 'title' );
   }

   public function get_price() {
      return $this->get_field( 'price' );
   }

   public function get_field( string $field = '' ) {
      return isset( $this->_data[$field] ) ? $this->_data[$field] : false;
   }

   public function get_plus_price( $price = 0 ) {
      return $this->_data['price'] - $this->_default_price;
   }

   public function is_default() {
      return $this->get_field( 'default' );
   }

}
