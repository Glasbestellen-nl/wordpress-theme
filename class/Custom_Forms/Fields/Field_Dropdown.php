<?php
namespace Custom_Forms\Fields;

class Field_Dropdown extends Field_With_Options {

   protected $_options = [];

   public function __construct( array $field_settings = [] ) {
      parent::__construct( $field_settings );
      $this->set_field_class( ['dropdown'] );
   }

   public function get_field_html() {
      $html  = '<select name="' . $this->get_field_name() . '" class="' . $this->get_field_class() . '">';
      if ( ! empty( $this->_options ) ) {
         foreach ( $this->_options as $option ) {
            $option_value = ! empty( $option['value'] ) ? $option['value'] : '';
            $option_label = ! empty( $option['label'] ) ? $option['label'] : '';
            $html .= '<option value="' . $option_value . '">' . $option_label . '</option>';
         }
      }
      $html .= '</select>';
      return $html;
   }

}
