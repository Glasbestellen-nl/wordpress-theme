<?php
namespace Custom_Forms\Fields;

class Field_Radio extends Field_With_Options {

   protected $_options = [];

   public function __construct( array $field_settings = [] ) {
      $this->set_label_class( ['small-space-below'] );
      parent::__construct( $field_settings );
   }

   public function get_field_html() {
      $html = '';
      if ( ! empty( $this->_options ) ) {
         $count = 0;
         $html .= '<div class="form-check-group">';
         foreach ( $this->_options as $option ) {
            $checked = $count == 0 ? 'checked="checked"' : '';
            $html .= '<label class="form-check form-check-group__item">';
            $html .= '<input type="radio" name="' . $this->get_field_name() . '" class="form-check__input" value="' . $option['value'] . '" ' . $checked . '/> <span class="form-check__label">' . $option['label'] . '</span>';
            $html .= '</label>';
            $count ++;
         }
         $html .= '</div>';
      }
      return $html;
   }

}
