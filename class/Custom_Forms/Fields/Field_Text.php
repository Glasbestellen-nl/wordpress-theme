<?php
namespace Custom_Forms\Fields;

class Field_Text extends Field {

   protected $_attr_type = 'text';

   public function __construct( array $field_settings = [] ) {
      parent::__construct( $field_settings );
      $this->set_field_class( ['form-control'] );
   }

   public function get_field_html() {
      return '<input type="' . $this->_attr_type . '" class="' . $this->get_field_class() . '" name="' . $this->get_field_name() . '" placeholder="' . $this->get_field_placeholder() . '"'  . ( ( $this->is_required() ) ? 'data-required="true"' : '' ) . '/>';
   }

}
