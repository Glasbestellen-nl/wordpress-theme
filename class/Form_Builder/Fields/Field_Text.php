<?php
namespace Form_Builder\Fields;

class Field_Text extends Field {

   public function __construct( array $field_settings = [] ) {
      parent::__construct( $field_settings );
   }

   public function get_field_html() {
      return '<input type="text" class="' . $this->get_field_class() . '" name="' . $this->get_field_name() . '"' . ( ( $this->is_required() ) ? 'data-required="true"' : '' ) . '/>';
   }

}
