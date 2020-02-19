<?php
namespace Configurator;

class Parts_Configurator extends Configurator {

   public function __construct( int $configurator_id = 0 ) {
      parent::__construct( $configurator_id );
   }

   public function get_step_parts( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_parts();
   }

   public function get_step_part( $step_id = null, $part_id = null ) {
      $parts = $this->get_step_parts( $step_id );
      if ( ! $parts ) return;
      $index = array_search( $part_id, array_column( $parts, 'id' ) );
      return $parts[$index];
   }

   public function get_part_price( $step_id = null, $part_id = null ) {
      if ( $part = $this->get_step_part( $step_id, $part_id ) ) {
         return isset( $part['price'] ) ? $part['price'] : 0;
      }
      return 0;
   }

   public function get_part_price_difference( $step_id = null, $part_id = null ) {

      if ( empty( $this->_default_configuration[$step_id] ) ) return 0;

      $default_price = $this->get_part_price( $step_id, $this->_default_configuration[$step_id] );
      $custom_price  = $this->get_part_price( $step_id, $part_id );
      return $custom_price - $default_price;
   }

}
