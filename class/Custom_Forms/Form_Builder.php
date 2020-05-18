<?php
use Custom_Forms\Form_Settings;
namespace Custom_Forms;

class Form_Builder {

   protected $_form_id;

   protected $_form_action;

   protected $_form_method;

   protected $_form_class = [];

   protected $_fields_html = [];

   protected $_submit_button_text;

   protected $_submit_button_class = [];

   public function __construct( Form_Settings $form_settings, int $form_id = 0 ) {

      $this->_form_id = $form_id;

      $this->set_form_defaults();

      if ( $form_settings->get_action() )
         $this->set_form_action( $form_settings->get_action() );

      if ( $form_settings->get_method() )
         $this->set_form_method( $form_settings->get_method() );

      if ( $form_settings->get_class() )
         $this->set_form_class( $form_settings->get_class() );

      if ( $form_settings->get_submit_button_class() )
         $this->set_submit_button_class( $form_settings->get_submit_button_class() );

      if ( $form_settings->get_fields() )
         $this->build_fields_html( $form_settings->get_fields() );

   }

   protected function set_form_defaults() {
      $this->set_form_action( 'handle_lead_form_submit' );
      $this->set_form_method( 'post' );
      $this->set_form_class( ['js-form-validation'] );
      $this->set_submit_button_text( __( 'Verstuur', 'glasbestellen' ) );
      $this->set_submit_button_class( ['btn btn--next btn--primary'] );
      return true;
   }

   public function get_field_html( array $field_settings = [] ) {
      $field = Field_Setup::get_instance( $field_settings );
      return $field->get_html();
   }

   public function get_fields_html() {
      $html  = '<div class="row">';
      $html .= implode( '', $this->_fields_html );
      $html .= '</div>';
      return $html;
   }

   public function get_form_opening_html() {
      return '<form method="' . $this->get_form_method() . '" class="' . $this->get_form_class() . '" enctype="multipart/form-data" novalidate>';
   }

   public function get_submit_button_html() {
      $html  = '<div class="d-flex">';
      $html .= '<button type="submit" class="' . $this->get_submit_button_class() . '">' . $this->get_submit_button_text() . '</button>';
      $html .= '</div>';
      return $html;
   }

   public function get_form_hidden_fields_html() {
      $html  = '<input type="hidden" name="client[remote_address]" value="' . $_SERVER['REMOTE_ADDR'] . '">';
      $html .= '<input type="hidden" name="client[gclid]" class="gclid_field" value="">';
      $html .= '<input type="hidden" name="action" class="js-form-action" value="' . $this->get_form_action() . '" />';
      $html .= '<input type="hidden" name="form_id" value="' . $this->_form_id . '">';
      return $html;
   }

   public function get_form_closing_html() {
      $html  = $this->get_form_hidden_fields_html();
      $html .= '</form>';
      return $html;
   }

   public function get_form_messages_html() {
      return '<p class="alert alert--danger js-error-alert" style="display: none;"></p>';
   }

   public function get_form_html() {
      $html  = $this->get_form_opening_html();
      $html .= $this->get_form_messages_html();
      $html .= $this->get_fields_html();
      $html .= $this->get_submit_button_html();
      $html .= $this->get_form_closing_html();
      return $html;
   }

   public function get_form_method() {
      return $this->_form_method;
   }

   public function get_form_action() {
      return $this->_form_action;
   }

   public function get_form_class() {
      return implode( ' ', $this->_form_class );
   }

   public function get_submit_button_text() {
      return $this->_submit_button_text;
   }

   public function get_submit_button_class() {
      return implode( ' ', $this->_submit_button_class );
   }

   public function set_form_action( string $action = '' ) {
      $this->_form_action = $action;
      return true;
   }

   public function set_form_method( string $method = '' ) {
      if ( ! in_array( $method, ['post', 'get'] ) ) return;
      $this->_form_method = $method;
      return true;
   }

   public function set_form_class( array $additional_classes = [] ) {
      if ( empty( $additional_classes ) ) return;
      $this->_form_class = array_merge( $this->_form_class, $additional_classes );
      return true;
   }

   public function set_submit_button_text( string $text = '' ) {
      $this->_submit_button_text = $text;
      return true;
   }

   public function set_submit_button_class( array $additional_classes = [] ) {
      if ( empty( $additional_classes ) ) return;
      $this->_submit_button_class = array_merge( $this->_submit_button_class, $additional_classes );
      return true;
   }

   public function build_fields_html( array $fields = [] ) {
      if ( empty( $fields ) ) return;
      $this->_fields_html = array_map( [$this, 'get_field_html'], $fields );
   }

   public function render() {
      echo $this->get_form_html();
   }

}
