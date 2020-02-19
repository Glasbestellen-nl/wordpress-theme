<?php
namespace Configurator;

class Step {

   protected $_data;

   public function __construct( array $data = [] ) {
      $this->_data = $data;
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
      return $this->get_field( 'options' );
   }

   public function get_visual() {
      return $this->get_field( 'visual' );
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

   public function get_parts() {
      $parts = $this->get_field( 'parts' );
      if ( ! $parts ) return;
      return array_map( function( $part ) {
         return [
            'id' => $part['id'],
            'title' => get_the_title( $part['id'] ),
            'description' => get_the_excerpt( $part['id'] ),
            'price' => isset( $part['price'] ) ? $part['price'] : null,
            'img' => get_the_post_thumbnail_url( $part['id'], 'medium' )
         ];
      }, $parts );
   }

   public function get_default() {
      if ( ! empty( $this->_data['default'] ) ) {
         return $this->_data['default'];
      } elseif ( ! empty( $this->_data['parts'] ) ) {
         foreach ( $this->_data['parts'] as $part ) {
            if ( ! empty( $part['default'] ) ) return $part['id'];
         }
      }
      return false;
   }

}
