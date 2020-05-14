<?php
namespace Custom_Forms;

class Form_Settings {

   protected $_settings = [];

   public function __construct( array $form_settings = [] ) {
      $this->_settings = $form_settings;
   }

   public function get_element( string $field_name = '' ) {
      return ! empty( $this->_settings[$field_name] ) ? $this->_settings[$field_name] : false;
   }

   public function get_action() {
      return $this->get_element( 'form_action' );
   }

   public function get_method() {
      return $this->get_element( 'form_method' );
   }

   public function get_class() {
      return $this->get_element( 'form_class' );
   }

   public function get_submit_button_class() {
      return $this->get_element( 'submit_button_class' );
   }

   public function get_fields() {
      return $this->get_element( 'fields' );
   }

   public function get_field_label_by_name( string $name = '' ) {
      $fields = $this->get_fields();
      if ( empty( $fields ) ) return;
      foreach ( $fields as $field ) {
         if ( $field['field_name'] == $name ) return $field['label'];
      }
      return false;
   }

}
