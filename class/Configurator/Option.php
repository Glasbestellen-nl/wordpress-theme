<?php
namespace Configurator;

class Option {

   protected $_data;

   protected $_default_price;

   public function __construct( array $data = [], float $default_price = 0 ) {
      $this->_data = $data;
      $this->_default_price = $default_price;
   }

   public function get_id() {
      return $this->get_field( 'id' );
   }

   public function get_title() {
      return $this->get_field( 'title' );
   }

   public function get_price() {
      return $this->get_field( 'price' );
   }

   public function get_validation_rules() {
      return ( $this->get_field( 'rules' ) ) ? json_encode( $this->get_field( 'rules' ) ) : false;
   }

   public function get_child_step() {
      return $this->get_field( 'child_step' );
   }

   public function get_field( string $field = '' ) {
      return ! empty( $this->_data[$field] ) ? $this->_data[$field] : false;
   }

   public function get_plus_price() {
      if ( empty( $this->_data['price'] ) ) return 0;
      return $this->_data['price'] - $this->_default_price;
   }

   public function is_default() {
      return $this->get_field( 'default' );
   }

}
