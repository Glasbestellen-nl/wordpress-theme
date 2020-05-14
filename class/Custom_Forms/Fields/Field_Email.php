<?php
namespace Custom_Forms\Fields;

class Field_Email extends Field_Text {

   protected $_attr_type = 'email';

   public function __construct( array $field_settings = [] ) {
      parent::__construct( $field_settings );
   }

}
