<?php
namespace Configurator;

abstract class Configurator {

   protected $_configurator_id;

   protected $_configuration = [];

   protected $_price_table = [];

   protected $_default_configuration = [];

   protected $_default_price_table = [];

   protected $_settings = [];

   protected $_steps = [];

   protected $_current_step;

   protected $_current_step_index = 0;

   public function __construct( int $configurator_id = 0 ) {
      $this->_configurator_id = $configurator_id;
      $this->set_settings();
      $this->set_steps();
      $this->set_defaults();
   }

   public function get_configuration() {
      return $this->_configuration;
   }

   public function get_configured_value( string $field = '' ) {

      if ( empty( $this->_configuration ) ) return;

      foreach ( $this->_configuration as $step_id => $input ) {
         if ( is_array( $input ) ) {
            foreach ( $input as $key => $val ) {
               if ( $key == $field )
                  return $val;
            }
         }
         if ( $step_id == $field )
            return $input;
      }
   }

   public function get_total_price( bool $round = true ) {

      $total = $this->calculate_subtotal();

      if ( ! empty( $this->_settings['shipping'] ) ) {
         $total += $this->_settings['shipping'];
      }
      return ( $round ) ? \Money::round_including_vat( $total ) : $total;
   }

   protected function calculate_subtotal() {

      $subtotal = 0;
      $d = $this->_default_price_table;
      $c = $this->_price_table;

      if ( empty( $d ) ) return $subtotal;

      foreach ( $d as $step_id => $price ) {
         if ( ! empty( $c[$step_id] ) ) {
            $subtotal += $c[$step_id];
         } else {
            $subtotal += $price;
         }
      }
      return $subtotal;
   }

   public function get_steps_count() {
      return ! empty( $this->_steps ) ? count( $this->_steps ) : 0;
   }

   public function get_steps() {
      return $this->_steps;
   }

   public function get_step_by_id( string $step_id = '' ) {
      $steps = array_values( array_filter( $this->_steps, function( $step ) use( $step_id ) {
         return $step->get_id() == $step_id;
      }));
      return isset( $steps[0] ) ? $steps[0] : false;
   }

   public function get_id() {
      return $this->_configurator_id;
   }

   public function update( array $configuration = [] ) {
      $this->update_configuration( $configuration );
      $this->update_price_table();
   }

   protected function update_price_table() {
      $configuration = $this->get_merged_configuration();
      $this->_price_table = $this->calculate_price_table( $configuration );
   }

   protected function update_configuration( array $configuration = [] ) {
      $this->_configuration = $configuration;
   }

   protected function get_merged_configuration() {
      $configuration = $this->_configuration;
      if ( empty( $this->_default_configuration ) ) return;
      foreach ( $this->_default_configuration as $step_id => $input ) {
         if ( empty( $configuration[$step_id] ) )
            $configuration[$step_id] = $this->_default_configuration[$step_id];
      }
      return $configuration;
   }

   protected function set_defaults() {
      $this->set_default_configuration();
      $this->calculate_default_price_table();
   }

   protected function set_default_configuration() {
      if ( empty( $this->_steps ) ) return;
      foreach ( $this->_steps as $step ) {
         $step_id = $step->get_id();
         $this->_default_configuration[$step_id] = $step->get_default();
      }
   }

   protected function set_steps() {
      if ( empty( $this->_settings['steps'] ) ) return;
      $this->_steps = array_map( function( $step ) {
         return new Step( $step );
      }, $this->_settings['steps'] );
   }

   protected function set_current_step( string $step_id = '' ) {
      if ( empty( $step_id ) ) return;
      $this->_current_step = $this->get_step_by_id( $step_id );
   }

   protected function set_settings( array $settings = [] ) {
      $this->_settings = get_post_meta( $this->_configurator_id, 'configurator_settings', true );
   }

   public function is_configuration_done() {
      return count( $this->_configuration ) === $this->get_steps_count();
   }

   public function is_step_done( string $step_id = '' ) {

      if ( empty( $step_id ) )
         $step_id = $this->_current_step->get_id();

      return isset( $this->_configuration[$step_id] );
   }

   public function is_step_required( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->is_required();
   }

   public function have_steps() {
      return $this->_current_step_index < $this->get_steps_count();
   }

   public function the_step() {
      $this->_current_step = $this->_steps[$this->_current_step_index];
      $this->_current_step_index ++;
   }

   public function get_step_price() {

      $price = 0;

      $step_id = $this->_current_step->get_id();

      $d = $this->_default_price_table;
      $c = $this->_price_table;

      $c_price = isset( $c[$step_id] ) ? $c[$step_id] : 0;
      $d_price = isset( $d[$step_id] ) ? $d[$step_id] : 0;

      if ( $c_price > $d_price ) {
         $price = $c_price - $d_price;
      }
      return $price;
   }

   public function get_step_image( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      $choice = $this->get_step_choice( $this->get_step_id(), false );
      if ( ! $choice ) return;
      return get_the_post_thumbnail_url( $choice, 'medium' );
   }

   public function get_step_choice( string $step_id = '', bool $default = true ) {

      if ( ! empty( $this->_configuration[$step_id] ) )
         return $this->_configuration[$step_id];

      if ( $default ) return $this->_default_configuration[$step_id];

      return false;
   }

   public function get_option_price( string $step_id = '', string $option_id ) {
      $options = $this->get_step_options( $step_id );
      if ( ! $options ) return 0;
      foreach ( $options as $option ) {
         if ( $option['title'] == $option_id ) return $option['price'];
      }
      return 0;
   }

   public function get_step_id() {
      return $this->_current_step->get_id();
   }

   public function get_step_type( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_type();
   }

   public function get_step_title( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_title();
   }

   public function get_step_description( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_description();
   }

   public function get_step_placeholder( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_placeholder();
   }

   public function get_step_options( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_options();
   }

   public function get_step_visual( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_visual();
   }

   public function get_step_field( string $field = '', string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_field( $field );
   }

   public function get_step_explanation_id( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_explanation_id();
   }

   public function get_validation_rules( string $step_id = '', string $field = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_validation_rules( $field );
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

   public function get_usps() {
      return ! empty( $this->_settings['usps'] ) ? $this->_settings['usps'] : false;
   }

   protected function calculate_default_price_table() {
      $this->_default_price_table = $this->calculate_price_table( $this->_default_configuration );
   }

   public function get_summary() {

      $summary = [];

      if ( empty( $this->_configuration ) ) return;

      foreach ( $this->_configuration as $step_id => $value ) {
         $summary[] = [
            'label' => $this->get_step_title( $step_id ),
            'value' => $this->get_formatted_step_configuration( $step_id )
         ];
      }
      return $summary;
   }

   abstract protected function calculate_price_table( array $configuration = [] );

}
