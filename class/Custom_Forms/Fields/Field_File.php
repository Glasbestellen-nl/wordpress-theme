<?php
namespace Custom_Forms\Fields;

class Field_File extends Field {

   public function __construct( array $field_settings = [] ) {
      parent::__construct( $field_settings );
   }

   public function get_field_html() {
      $html = '<div class="file-fields form-control">';
      for ( $i = 0; $i < 3; $i ++ ) {
         $html .= '<input type="file" name="attachment[]" class="file-fields__item" />';
      }
      $html .= '</div>';
      return $html;
   }

}
