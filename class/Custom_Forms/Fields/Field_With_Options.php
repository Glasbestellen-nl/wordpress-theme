<?php
namespace Custom_Forms\Fields;

abstract class Field_With_Options extends Field {

   protected $_options = [];

   public function __construct( array $field_settings = [] ) {
      parent::__construct( $field_settings );

      if ( ! empty( $field_settings['options'] ) )
         $this->set_options( $field_settings['options'] );
   }

   public function set_options( array $options = [] ) {
      $this->_options = $options;
   }

}
