<?php
namespace Custom_Forms\Fields;

class Field_Number extends Field_Text {

   protected $_attr_type = 'number';

   public function __construct( array $field_settings = [] ) {
      parent::__construct( $field_settings );
   }

}
