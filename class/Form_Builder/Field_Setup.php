<?php
namespace Form_Builder;

class Field_Setup {

   public static function get_instance( array $field_settings = [] ) {

      if ( empty( $field_settings['type'] ) ) return;

      switch ( $field_settings['type'] ) {
         case 'dropdown' :
            return new Fields\Field_Dropdown( $field_settings );
            break;
         default :
            return new Fields\Field_Text( $field_settings );
      }

   }

}
