<?php
namespace Custom_Forms\Fields;

class Field_Phone extends Field_Text {

   protected $_attr_type = 'phone';

   public function __construct( array $field_settings = [] ) {
      parent::__construct( $field_settings );
   }

}
