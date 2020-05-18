<?php
namespace Custom_Forms;

class Field_Setup {

   public static function get_instance( array $field_settings = [] ) {

      if ( empty( $field_settings['type'] ) ) return;

      switch ( $field_settings['type'] ) {
         case 'dropdown' :
            return new Fields\Field_Dropdown( $field_settings );
            break;
         case 'textarea' :
            return new Fields\Field_Textarea( $field_settings );
            break;
         case 'email' :
            return new Fields\Field_Email( $field_settings );
            break;
         case 'number' :
            return new Fields\Field_Number( $field_settings );
            break;
         case 'phone' :
            return new Fields\Field_Phone( $field_settings );
            break;
         case 'radio' :
            return new Fields\Field_Radio( $field_settings );
            break;
         case 'checkbox' :
            return new Fields\Field_Checkbox( $field_settings );
            break;
         case 'file' :
            return new Fields\Field_File( $field_settings );
            break;
         default :
            return new Fields\Field_Text( $field_settings );
      }

   }

}
