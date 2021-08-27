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

   public function get_title( $args = [] ) {
      $title = $this->get_field( 'title' );
      if ( ! empty( $args['size_unit'] ) && $args['size_unit'] == 'cm' ) {
         $title = preg_replace_callback( '/\d+(?:[,.]\d+)?(?=\s*(?:mm))/', function( $matches ) {
            return ( $matches[0] / 10 );
         }, $title );
         $title = str_replace( 'mm', 'cm', $title );
      }
      return $title;
   }

   public function get_price() {
      return $this->get_field( 'price' );
   }

   public function get_value( $size_unit = 'mm' ) {
      $value = $this->get_field( 'value' );
      return ( $size_unit == 'cm' && is_numeric( $value ) ) ? $value / 10 : $value;
   }

   public function get_validation_rules() {
      return ( $this->get_field( 'rules' ) ) ? json_encode( $this->get_field( 'rules' ) ) : false;
   }

   public function get_child_steps() {
      return $this->get_field( 'child_steps' );
   }

   public function is_child_step( string $step_id = '' ) {
      $child_steps = $this->get_child_steps();
      if ( ! $child_steps ) return;
      if ( is_array( $child_steps ) ) return in_array( $step_id, $child_steps );
      else return ( $step_id == $child_steps );
   }

   public function get_child_steps_attr() {
      $child_steps = $this->get_child_steps();
      if ( ! $child_steps ) return;
      return ( is_array( $child_steps ) ) ? json_encode( $child_steps ) : $child_steps;
   }

   public function get_field( string $field = '' ) {
      return isset( $this->_data[$field] ) ? $this->_data[$field] : 0;
   }

   public function get_plus_price() {
      if ( empty( $this->_data['price'] ) ) return 0;
      return $this->_data['price'] - $this->_default_price;
   }

   public function is_default() {
      return $this->get_field( 'default' );
   }

}
