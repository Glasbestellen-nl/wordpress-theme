<?php
namespace Custom_Forms\Fields;

class Field_Textarea extends Field {

   protected $_field_rows = 5;

   public function __construct( array $field_settings = [] ) {
      $this->set_field_class( ['form-control'] );

      if ( ! empty( $field_settings['field_rows'] ) )
         $this->set_field_rows( $field_settings['field_rows'] );

      parent::__construct( $field_settings );
   }

   public function get_field_html() {
      return '<textarea name="' . $this->get_field_name() . '" class="' . $this->get_field_class() . '" placeholder="' . $this->get_field_placeholder() . '" rows="' . $this->get_field_rows() . '"'  . ( ( $this->is_required() ) ? ' data-required="true"' : '' ) . '></textarea>';
   }

   public function get_field_rows() {
      return $this->_field_rows;
   }

   public function set_field_rows( int $rows = 5 ) {
      $this->_field_rows = $rows;
      return true;
   }

}
