<?php
namespace Custom_Forms\Fields;

abstract class Field {

   const LEAD_FIELD_NAMES = [
      'name',
      'email',
      'phone',
      'residence',
      'content'
   ];

   protected $_field_name;

   protected $_field_class = [];

   protected $_field_id;

   protected $_field_value;

   protected $_field_placeholder;

   protected $_col_span;

   protected $_col_class = [];

   protected $_label;

   protected $_label_class = [];

   protected $_required = false;

   public function __construct( array $field_settings = [] ) {

      $this->set_field_defaults();

      if ( ! empty( $field_settings['col_span'] ) ) {
         $this->set_col_span( $field_settings['col_span'] );
      } else {
         $this->set_col_span(1);
      }

      if ( ! empty( $field_settings['field_name'] ) )
         $this->set_field_name( $field_settings['field_name'] );

      if ( ! empty( $field_settings['field_id'] ) )
         $this->set_field_id( $field_settings['id'] );

      if ( ! empty( $field_settings['field_placeholder'] ) )
         $this->set_field_placeholder( $field_settings['field_placeholder'] );

      if ( ! empty( $field_settings['field_class'] ) )
         $this->set_field_id( $field_settings['field_class'] );

      if ( ! empty( $field_settings['label'] ) )
         $this->set_label( $field_settings['label'] );

      if ( ! empty( $field_settings['label_class'] ) )
         $this->set_label_class( $field_settings['label_class'] );

      if ( ! empty( $field_settings['required'] ) )
         $this->set_required( $field_settings['required'] );

   }

   abstract public function get_field_html();

   protected function set_field_defaults() {
      $this->set_col_class( ['form-group', 'js-form-group'] );
      $this->set_label_class( ['form-label'] );
      $this->set_field_class( ['js-form-validate'] );
      return true;
   }

   public function get_html() {
      $html  = $this->get_col_opening_html();
      $html .= $this->get_label_html();
      $html .= $this->get_field_html();
      $html .= $this->get_field_feedback_html();
      $html .= $this->get_col_closing_html();
      return $html;
   }

   protected function get_label_html() {
      return '<label class="' . $this->get_label_class() . '">' . $this->get_label() . ':' . ( ( $this->is_required() ) ? ' <span class="req">*</span>' : '' ) . '</label>';
   }

   protected function get_col_opening_html() {
      return '<div class="' . $this->get_col_class() . '">';
   }

   protected function get_col_closing_html() {
      return '</div>';
   }

   protected function get_field_feedback_html() {
      return '<div class="invalid-feedback js-invalid-feedback"></div>';
   }

   public function get_field_name() {
      $field_name = in_array( $this->_field_name, self::LEAD_FIELD_NAMES ) ? 'lead[' . $this->_field_name . ']' : 'custom_form[' . $this->_field_name . ']';
      return $field_name;
   }

   public function get_field_id() {
      return $this->_field_id;
   }

   public function get_field_placeholder() {
      return $this->_field_placeholder;
   }

   public function get_field_class() {
      return implode( ' ', $this->_field_class );
   }

   public function get_col_class() {
      return implode( ' ', $this->_col_class );
   }

   public function get_label() {
      return $this->_label;
   }

   public function get_label_class() {
      return implode( ' ', $this->_label_class );
   }

   public function is_required() {
      return $this->_required;
   }

   public function set_field_class( array $additional_classes = [] ) {
      if ( empty( $additional_classes ) ) return;
      $this->_field_class = array_merge( $this->_field_class, $additional_classes );
      return true;
   }

   public function set_field_name( string $name = '' ) {
      $this->_field_name = $name;
      return true;
   }

   public function set_field_id( string $id = '' ) {
      $this->_field_id = $id;
      return true;
   }

   public function set_col_span( int $col_span = 1 ) {
      $col_width = 12 / $col_span;
      $this->set_col_class( ['col-12', 'col-md-' . $col_width] );
      return true;
   }

   public function set_field_placeholder( string $placeholder = '' ) {
      $this->_field_placeholder = $placeholder;
      return true;
   }

   public function set_col_class( array $additional_classes = [] ) {
      if ( empty( $additional_classes ) ) return;
      $this->_col_class = array_merge( $this->_col_class, $additional_classes );
      return true;
   }

   public function set_label( string $label = '' ) {
      $this->_label = $label;
      return true;
   }

   public function set_label_class( array $additional_classes = [] ) {
      if ( empty( $additional_classes ) ) return;
      $this->_label_class = array_merge( $this->_label_class, $additional_classes );
      return true;
   }

   public function set_required( bool $required = false ) {
      $this->_required = $required;
      return true;
   }
}
