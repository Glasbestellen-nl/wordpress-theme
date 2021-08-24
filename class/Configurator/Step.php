<?php
namespace Configurator;

class Step {

   protected $_data;

   protected $_default = false;

   public function __construct( array $data = [] ) {
      $this->_data = $data;
      $this->set_default();
   }

   public function get_id() {
      return $this->get_field( 'id' );
   }

   public function get_type() {
      return $this->get_field( 'type' );
   }

   public function get_title( $args = [] ) {
      $title = $this->get_field( 'title' );
      if ( ! empty( $args['size_unit'] ) && $args['size_unit'] == 'cm' ) {
         $title = str_replace( 'mm', 'cm', $title );
      }
      return $title;
   }

   public function get_description() {
      return $this->get_field( 'description' );
   }

   public function get_placeholder() {
      return $this->get_field( 'placeholder' );
   }

   public function get_options() {
      $options = $this->get_field( 'options' );
      if ( ! $options ) return;
      return array_map( function( $option ) {
         $default_price = ( $this->_default ) ? $this->_default->get_price() : 0;
         return new Option( $option, $default_price );
      }, $options );
   }

   public function get_option_by_id( int $option_id = 0 ) {
      if ( empty( $option_id ) ) return;
      $options = $this->get_options();
      if ( ! $options ) return;
      foreach ( $options as $option ) {
         if ( $option->get_id() == $option_id ) return $option;
      }
      return false;
   }

   public function get_options_html( $value = null, $args = [] ) {
      $options = $this->get_options();
      if ( ! $options ) return;

      $size_unit = ! empty( $args['size_unit'] ) ? $args['size_unit'] : 'mm';

      $html = '';
      $hide_price = $this->get_field( 'hide_price' );

      if ( ! $this->get_default() ) {
         $html .= '<option value="">' .  __( 'Geen' ) . '</option>';
      }

      foreach ( $options as $option ) {
         $selected     = selected( $value, $option->get_id(), false );
         $title        = $option->get_title( ['size_unit' => $size_unit] );
         $rules        = ( $option->get_validation_rules() ) ? 'data-validation-rules=\'' . $option->get_validation_rules() . '\'' : '';
         $child_steps  = ( $option->get_child_steps() ) ? 'data-child-steps=\'' . $option->get_child_steps_attr() . '\'' : '';
         $plus_price   = ( ! $hide_price  && ! $option->is_default() ) ? apply_filters( 'gb_step_part_price_difference', \Money::display( $option->get_plus_price() ), $this->get_id() ) : '';
         $html .= '<option value="' . $option->get_id() . '" data-option-value="' . $option->get_value( $size_unit ) . '" data-option-id="' . $option->get_id() . '" ' . $rules . ' ' . $child_steps . ' ' . $selected . '>' . $title . ' ' . $plus_price . '</option>';
      }
      return $html;
   }

   public function render_options( $value = null, $args = [] ) {
      echo $this->get_options_html( $value, $args );
   }

   public function get_visual() {
      return $this->get_field( 'visual' );
   }

   public function get_parent() {
      return $this->get_field( 'parent_step' );
   }

   public function get_class( array $additional_classes = [] ) {

      $classes = [
         'js-step-' . $this->get_id()
      ];

      if ( ! empty( $additional_classes ) ) {
         foreach ( $additional_classes as $class ) {
            $classes[] = $class;
         }
      }
      return implode( ' ', $classes );
   }

   public function get_explanation_id() {
      $field = $this->get_field( 'description' );
      return ! empty( $field['id'] ) ? $field['id'] : false;
   }

   public function get_validation_rules( string $field = '', $size_unit = 'mm' ) {
      $rules = $this->get_field( 'rules' );
      if ( ! empty( $field ) ) {
         $rules = ! empty( $rules[$field] ) ? $rules[$field] : $rules;
      }
      $rules = array_map( function( $value ) use( $size_unit ) {
         if ( ! is_array( $value ) ) {
            return ( $size_unit == 'cm' && is_numeric( $value ) ) ? $value / 10 : $value;
         } else {
            return array_map( function( $value ) use( $size_unit ) {
               return ( $size_unit == 'cm' && is_numeric( $value ) ) ? $value / 10 : $value;
            }, $value );
         }
      }, $rules );
      return ! empty( $rules ) ? json_encode( $rules ) : false;
   }

   public function is_required() {
      return $this->get_field( 'required' );
   }

   public function get_field( string $field = '' ) {
      return ! empty( $this->_data[$field] ) ? $this->_data[$field] : false;
   }

   public function get_default() {
      if ( ! $this->_default ) return;
      return is_a( $this->_default, 'Configurator\Option' ) ? $this->_default->get_id() : $this->_default;
   }

   protected function set_default() {

      if ( ! empty( $this->_data['default'] ) ) {
         $this->_default = $this->_data['default'];
      } elseif ( ! empty( $this->_data['options'] ) ) {
         foreach ( $this->_data['options'] as $option ) {
            if ( ! empty( $option['default'] ) ) {
               $this->_default = new Option( $option );
            }
         }
      }

   }

}
