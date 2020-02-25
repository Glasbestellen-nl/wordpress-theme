<?php
namespace Configurator\Configurators\Using_Parts;

abstract class Configurator extends \Configurator\Configurator {

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

   public function get_formatted_step_configuration( $step_id = null ) {

      if ( empty( $step_id ) )
         $step_id = $this->_current_step->get_id();

      if ( empty( $this->_configuration[$step_id] ) ) return;

      $configured = $this->_configuration[$step_id];

      if ( $this->get_step_parts() ) {
         return get_the_title( $configured );

      } elseif ( is_array( $configured ) ) {
         if ( $format = $this->get_step_field( 'format', $step_id ) ) {
            foreach ( $configured as $field => $value ) {
               $format = str_replace( '{' . $field . '}', $value, $format );
            }
            return $format;
         }
      }
   }

   public function get_summary( string $message = '' ) {

      $summary = [];

      if ( empty( $this->_configuration ) ) return;

      foreach ( $this->_configuration as $step_id => $value ) {
         $summary[] = [
            'label' => $this->get_step_title( $step_id ),
            'value' => $this->get_formatted_step_configuration( $step_id )
         ];
      }

      if ( ! empty( $message ) ) {
         $summary[] = [
            'label' => __( 'Opmerking', 'glasbestellen' ),
            'value' => sanitize_textarea_field( $message )
         ];
      }

      return $summary;
   }


}
