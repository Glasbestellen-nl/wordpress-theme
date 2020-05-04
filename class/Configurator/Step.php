<?php
namespace Configurator;

class Step {

   protected $_data;

   protected $_default;

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

   public function get_title() {
      return $this->get_field( 'title' );
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
         return new Option( $option, $this->_default->get_price() );
      }, $options );
   }

   public function get_options_html( $value = null ) {
      $options = $this->get_options();
      if ( $options ) {
         $html = '';
         $hide_price = $this->get_field( 'hide_price' );
         foreach ( $options as $option ) {
            $selected     = selected( $value, $option->get_id(), false );
            $rules        = ( $option->get_validation_rules() ) ? 'data-validation-rules=\'' . $option->get_validation_rules() . '\'' : '';
            $child_step   = ( $option->get_child_step() ) ? 'data-child-step="' . $option->get_child_step() . '"' : '';
            $plus_price   = ( ! $hide_price  && ! $option->is_default() ) ? apply_filters( 'gb_step_part_price_difference', \Money::display( $option->get_plus_price() ), $this->get_id() ) : '';
            $html .= '<option value="' . $option->get_id() . '" data-option-id="' . $option->get_id() . '" ' . $rules . ' ' . $child_step . ' ' . $selected . '>' . $option->get_title() . ' ' . $plus_price . '</option>';
         }
         return $html;
      }
      return false;
   }

   public function render_options( $value = null ) {
      echo $this->get_options_html( $value );
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

      if ( $parent = $this->get_parent() )
         $classes[] = 'js-step-parent-' . $parent;

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

   public function get_validation_rules( string $field = '' ) {
      $rules = $this->get_field( 'rules' );
      if ( ! empty( $field ) ) {
         $rules = ! empty( $rules[$field] ) ? $rules[$field] : $rules;
      }
      return ! empty( $rules ) ? json_encode( $rules ) : false;
   }

   public function is_required() {
      return $this->get_field( 'required' );
   }

   public function get_field( string $field = '' ) {
      return ! empty( $this->_data[$field] ) ? $this->_data[$field] : false;
   }

   public function get_default() {
      if ( is_a( $this->_default, 'Configurator\Option' ) ) {
         return $this->_default->get_id();
      }
      return $this->_default;
   }

   protected function set_default() {

      if ( ! empty( $this->_data['default'] ) ) {
         $this->_default = $this->_data['default'];
      } elseif ( ! empty( $this->_data['options'] ) ) {
         foreach ( $this->_data['options'] as $option ) {
            if ( ! empty( $option['default'] ) )
               $this->_default = new Option( $option );
         }
      }

   }

}
