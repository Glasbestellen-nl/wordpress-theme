<?php
namespace Configurator;

class Configurator {

   // The configurator (post) id
   protected $_configurator_id;

   // The current configuration
   protected $_configuration = [];

   // The price table calculated based on the current configuration
   protected $_price_table = [];

   // The default configuration
   protected $_default_configuration = [];

   // The price table calculated based on the default configuration
   protected $_default_price_table = [];

   // The settings from to the current configurator
   protected $_settings = [];

   // Keeps the step objects
   protected $_steps = [];

   // The current step object
   protected $_current_step;

   // The current step index in the $_steps array
   protected $_current_step_index = 0;

   /**
    * Initializes a configurator
    *
    * Sets the configurator (post) id
    *
    * @uses set_settings() to store the settings data in the $_settings property
    * @uses set_steps() to create step objects from the steps in settings input
    * @uses set_defaults() to set default configuration and price table
    */
   public function __construct( int $configurator_id = 0 ) {
      $this->_configurator_id = $configurator_id;
      $this->set_settings();
      $this->set_steps();
      $this->set_defaults();
   }

   /**
    * Returns the current set configuration
    */
   public function get_configuration() {
      return $this->_configuration;
   }

   /**
    * Return total calculated price
    *
    * @param bool $round whether change the price so the vat included price is
    * a round price
    * @param bool $default_only whether to only calculate the total price of
    * the default configuration
    */
   public function get_total_price( bool $round = true, $default_only = false ) {

      $total = $this->calculate_subtotal( $default_only );

      if ( $shipping_price = $this->get_shipping_price() ) {
         $total += $shipping_price;
      }

      if ( $price_addition = $this->get_price_addition() ) {
         $total += $price_addition;
      }

      if ( $starting_price = $this->get_starting_price() ) {
         $total += $starting_price;
      }

      return ( $round ) ? \Money::round_including_vat( $total ) : $total;
   }

   /**
    * Calculates the subtotal price
    *
    * This is only the price of the product itself
    *
    * @param bool $default_only whether to only calculate the total price of
    * the default configuration
    */
   public function calculate_subtotal( $default_only = false ) {

      $subtotal = 0;
      $d = $this->_default_price_table;
      $c = $this->_price_table;

      if ( empty( $d ) ) return $subtotal;

      foreach ( $d as $step_id => $price ) {
         if ( ! empty( $c[$step_id] ) && ! $default_only ) {
            $subtotal += $c[$step_id];
         } else {
            $subtotal += $price;
         }
      }
      return $subtotal;
   }

   /**
    * Returns the number of steps
    */
   public function get_steps_count() {
      return ! empty( $this->_steps ) ? count( $this->_steps ) : 0;
   }

   /**
    * Returns the step objects
    */
   public function get_steps() {
      return $this->_steps;
   }

   /**
    * Returns a step object by it's step id
    */
   public function get_step_by_id( string $step_id = '' ) {
      $steps = array_values( array_filter( $this->_steps, function( $step ) use( $step_id ) {
         return $step->get_id() == $step_id;
      }));
      return isset( $steps[0] ) ? $steps[0] : false;
   }

   /**
    * Returns the configurator's (post) id
    */
   public function get_id() {
      return $this->_configurator_id;
   }

   /**
    * Updates the current configuration and price table
    *
    * @param array $configuration the updated configuration
    * @uses update_configuration() to update the configuration array
    * @uses update_price_table() to update the current price table based on the new configuration
    */
   public function update( array $configuration = [] ) {
      $this->update_configuration( $configuration );
      $this->update_price_table();
   }

   /**
    * Updates the current configured price table
    *
    * @uses calculate_price_table() to update the current price table
    */
   protected function update_price_table() {
      $this->_price_table = $this->calculate_price_table( $this->_configuration );
   }

   /**
    * Updates the current configuration
    *
    * @param array $configuration the updated configuration
    */
   protected function update_configuration( array $configuration = [] ) {
      if ( empty( $configuration ) ) return;
      $this->_configuration = $this->filter_configuration( $configuration );
   }

   /**
    * Filters configuration
    *
    * @param array $configuration the updated configuration
    *
    * @uses get_step_by_id() to check whether step in configuration still exists as step
    * (when removing steps from configurator)
    */
   protected function filter_configuration( array $configuration = [] ) {
      if ( empty( $configuration ) ) return;
      $filtered = [];
      foreach ( $configuration as $step_id => $input ) {
         if ( ! empty( $input ) && $this->get_step_by_id( $step_id ) )
            $filtered[$step_id] = $input;
      }
      return $filtered;
   }

   /**
    * Sets default configuration and calculates default price table
    *
    * @uses set_default_configuration() to store the default configuration in $_default_configuration
    * @uses calculate_default_price_table() to calculate the price table based on $_default_configuration
    */
   protected function set_defaults() {
      $this->set_default_configuration();
      $this->calculate_default_price_table();
   }

   /**
    * Sets the default configuration based on the steps settings stored under the configurator (post)
    *
    * Loops over all steps and retrieves the default value
    */
   protected function set_default_configuration() {
      if ( empty( $this->_steps ) ) return;
      foreach ( $this->_steps as $step ) {
         $step_id = $step->get_id();
         $this->_default_configuration[$step_id] = $step->get_default();
      }
   }

   protected function filter_matrix_values_callback( $value = 0, $rules = [] ) {
      if ( ! empty( $rules['min'] ) && $rules['min'] > $value ) return;
      if ( ! empty( $rules['max'] ) && $rules['max'] < $value ) return;
      return ! empty( $value );
   }

   protected function map_insert_option_callback( $value = 0, $index = 0 ) {
      return [
         'id' => $index + 1,
         'title' => $value . ' mm',
         'value' => $value,
         'default' => $index == 1
      ];
   }

   protected function insert_step_options_from_matrix( $step ) {

      if ( empty( $step ) ) return;
      $matrix = $this->get_price_matrix();
      $rules = ! empty( $step['rules'] ) ? $step['rules'] : [];
      switch ( $step['id'] ) {
         case 'width' :
            $line_array = array_filter( $matrix->get_line(0), function( $value ) use( $rules ) { return $this->filter_matrix_values_callback( $value, $rules ); } );
            $step['options'] = array_map( [$this, 'map_insert_option_callback'], $line_array, array_keys( array_values( $line_array ) ) );
            break;
         case 'height' :
            $col_array = array_filter( $matrix->get_col(0), function( $value ) use( $rules ) { return $this->filter_matrix_values_callback( $value, $rules ); } );
            $step['options'] = array_map( [$this, 'map_insert_option_callback'], $col_array, array_keys( array_values( $col_array ) ) );
            break;
         default:
      }
      return $step;
   }

   /**
    * Creates an array of step objects from the steps settings input
    */
   protected function set_steps() {
      if ( empty( $this->_settings['steps'] ) ) return;
      $this->_steps = array_map( function( $step ) {
         if ( ! empty( $step['options_from_matrix'] ) && $this->get_price_matrix() ) {
            $step = $this->insert_step_options_from_matrix( $step );
         }
         return new Step( $step );
      }, $this->_settings['steps'] );
   }

   /**
    * Sets the currents pointer by step id
    *
    * @param string $step_id the id of the step
    * @uses get_step_by_id() to get the step from the $_steps property by id
    */
   protected function set_current_step( string $step_id = '' ) {
      if ( empty( $step_id ) ) return;
      $this->_current_step = $this->get_step_by_id( $step_id );
   }

   /**
    * Stores the settings from database inside the $_settings property
    */
   protected function set_settings( array $settings = [] ) {
      $this->_settings = get_post_meta( $this->_configurator_id, 'configurator_settings', true );
   }

   /**
    * Returns a setting from $_settings by key
    */
   public function get_setting( string $key = '' ) {
      return isset( $this->_settings[$key] ) ? $this->_settings[$key] : false;
   }

   /**
    * Return the shipping price when exists in $_settings
    *
    * @uses get_setting() to get a setting from the $_settings property
    */
   public function get_shipping_price() {
      return $this->get_setting( 'shipping' );
   }

   /**
    * Return the price addition when exists in $_settings
    *
    * @uses get_setting() to get a setting from the $_settings property
    */
   public function get_price_addition() {
      return $this->get_setting( 'price_addition' );
   }

   /**
    * Return the size unit (cm or mm)
    *
    * @uses get_setting() to get a setting from the $_settings property
    */
   public function get_size_unit() {
      return $this->get_setting( 'size_unit' ) ? $this->get_setting( 'size_unit' ) : 'mm';
   }

   /**
    * Converts dimension to milimeters based on size unit
    *
    * @uses get_size_unit() to get the set size unit
    */
   public function convert_to_mm( $value = 0 ) {
      return ( $this->get_size_unit() == 'cm' ) ? $value * 10 : $value;
   }

   /**
    * Return a value from the metadata array when exists in $_settings
    *
    * @param string $key the meta key in the metadata array in $_settings
    * @uses get_setting() to get a setting from the $_settings property
    */
   public function get_metadata( string $key = '' ) {
      $metadata = $this->get_setting( 'metadata' );
      if ( ! $metadata ) return;
      return ! empty( $metadata[$key] ) ? $metadata[$key] : false;
   }

   /**
    * Returns a price matrix object
    *
    * When the attachment id of the price matrix csv is set in the metadata array in $_settings
    */
   public function get_price_matrix() {
      if ( $attachment_id = $this->get_metadata( 'price_matrix_csv' ) ) {
         return new \Price_Matrix( get_attached_file( $attachment_id ) );
      }
      return false;
   }

   /**
    * Checks whether a step is done
    *
    * @param string $step_id the id of the step to check
    */
   public function is_step_done( string $step_id = '' ) {

      if ( empty( $step_id ) )
         $step_id = $this->_current_step->get_id();

      return isset( $this->_configuration[$step_id] );
   }

   /**
    * Checks whether a step is required
    *
    * @param string $step_id the id of the step to check
    */
   public function is_step_required( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->is_required();
   }

   /**
    * Checks whether there are steps left to loop over
    */
   public function have_steps() {
      return $this->_current_step_index < $this->get_steps_count();
   }

   /**
    * Sets the current step object and index
    */
   public function the_step() {
      $this->_current_step = $this->_steps[$this->_current_step_index];
      $this->_current_step_index ++;
   }

   /**
    * Returns the more price of the step
    */
   public function get_step_price() {

      $price = 0;

      $step_id = $this->_current_step->get_id();

      $d = $this->_default_price_table;
      $c = $this->_price_table;

      $c_price = isset( $c[$step_id] ) ? $c[$step_id] : 0;
      $d_price = isset( $d[$step_id] ) ? $d[$step_id] : 0;

      if ( $c_price > $d_price ) {
         $price = $c_price - $d_price;
      }
      return $price;
   }

   /**
    * Returns the step's chosen value
    *
    * @param string $step_id the id of the step
    * @param bool $default whether to return the default option as backup
    */
   public function get_step_choice( string $step_id = '', bool $default = true ) {

      if ( ! empty( $this->_configuration[$step_id] ) )
         return $this->_configuration[$step_id];

      return ( $default ) ? $this->_default_configuration[$step_id] : false;
   }

   /**
    * Returns the (step) option object
    *
    * @param string $step_id the step id
    * @param int $option_id the id of the option
    */
   public function get_option( string $step_id = '', $option_id ) {
      $options = $this->get_step_options( $step_id );
      if ( ! $options ) return;
      foreach ( $options as $option ) {
         if ( $option->get_id() == $option_id ) return $option;
      }
      return false;
   }

   /**
    * Returns the (step) option price
    *
    * @param string $step_id the step id
    * @param int $option_id the id of the option
    */
   public function get_option_value( string $step_id = '', $option_id ) {
      $option = $this->get_option( $step_id, $option_id );
      if ( ! $option ) return;
      return $option->get_value();
   }

   /**
    * Returns the (step) option price
    *
    * @param string $step_id the step id
    * @param int $option_id the id of the option
    */
   public function get_option_price( string $step_id = '', $option_id ) {
      $option = $this->get_option( $step_id, $option_id );
      if ( ! $option ) return;
      return $option->get_price();
   }

   /**
    * Returns the (step) option title
    *
    * @param string $step_id the step id
    * @param int $option_id the id of the option
    */
   public function get_option_title( string $step_id = '', $option_id ) {
      $option = $this->get_option( $step_id, $option_id );
      if ( ! $option ) return;
      return $option->get_title();
   }

   /**
    * Returns the current step id
    */
   public function get_step_id() {
      return $this->_current_step->get_id();
   }

   /**
    * Returns the current step configuration
    *
    * @param string $step_id for a specific step
    */
   public function get_step_configuration( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      $step_id = $this->get_step_id();
      return ! empty( $this->_configuration[$step_id] ) ? $this->_configuration[$step_id] : false;
   }

   /**
    * Return the step value
    *
    * Makes it possible to choose to show the default value
    *
    * @param string $step_id for a specific step
    */
   public function get_step_value( string $step_id = '' ) {
      $value = $this->get_step_configuration( $step_id );
      if ( ! $value && $this->_current_step->get_field( 'show_default' ) ) {
         return $this->get_step_default() ? $this->get_step_default() : false;
      }
      return $value;
   }

   /**
    * Returns the current step type
    *
    * @param string $step_id for a specific step
    */
   public function get_step_type( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_type();
   }

   /**
    * Returns the current step title
    *
    * @param string $step_id for a specific step
    */
   public function get_step_title( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      $args = [
         'size_unit' => $this->get_size_unit()
      ];
      return $this->_current_step->get_title( $args );
   }

   /**
    * Returns the current step description
    *
    * @param string $step_id for a specific step
    */
   public function get_step_description( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_description();
   }

   /**
    * Returns the current step placeholder
    *
    * @param string $step_id for a specific step
    */
   public function get_step_placeholder( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_placeholder();
   }

   /**
    * Returns the current step options
    *
    * @param string $step_id for a specific step
    */
   public function get_step_options( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_options();
   }

   /**
    * Returns the current step visual
    *
    * @param string $step_id for a specific step
    */
   public function get_step_visual( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_visual();
   }

   /**
    * Returns the current step parent
    *
    * @param string $step_id for a specific step
    */
   public function get_step_parent( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_parent();
   }

   /**
    * Returns a step's parent and the parents of their parents
    *
    * @param string $step_id for a specific step
    */
   public function get_step_parents( string $step_id = '' ) {

      $parent_ids = false;

      $step = $this->get_step_by_id( $step_id );
      if ( ! $step ) return $parent_ids;

      $parent_id = $step->get_parent();
      if ( ! $parent_id ) return $parent_ids;

      $parent_ids[] = $parent_id;

      if ( $grand_parent_ids = $this->get_step_parents( $parent_id ) ) {
         $parent_ids = array_merge( $parent_ids, $grand_parent_ids );
      }
      return $parent_ids;
   }

   /**
    * Checks whether step is child of an option of a configured step
    *
    * @param string $step_id for a specific step
    */
   public function is_child_of_configured_option( string $step_id = '' ) {

      $parent_step_id = $this->get_step_parent( $step_id );
      if ( $parent_step_id && ! empty( $this->_configuration[$parent_step_id] ) ) {

         $parent_step  = $this->get_step_by_id( $parent_step_id );
         $option_id    = $this->_configuration[$parent_step_id];

         $option = $parent_step->get_option_by_id( $option_id );
         if ( ! $option ) return;

         return $option->is_child_step( $this->_current_step->get_id() );
      }
      return false;
   }

   /**
    * Returns the current step css classes
    *
    * Adds display none class when step has parent and does not exist in configuration
    *
    * @param string $step_id for a specific step
    */
   public function get_step_class( string $step_id = '' ) {

      $this->set_current_step( $step_id );

      $parents_steps_ids = $this->get_step_parents( $step_id );
      if ( $parents_steps_ids ) {
         $additional_classes = [];
         foreach ( $parents_steps_ids as $parent_step_id ) {
            $additional_classes[] = 'js-parent-step-' . $parent_step_id;
         }
         if ( ! $this->is_child_of_configured_option() ) {
            $additional_classes[] = 'd-none';
         }
         return $this->_current_step->get_class( $additional_classes );
      }
      return $this->_current_step->get_class();
   }

   /**
    * Returns the current step default value
    *
    * @param string $step_id for a specific step
    */
   public function get_step_default( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      $args = [
         'size_unit' => $this->get_size_unit()
      ];
      return $this->_current_step->get_default( $args );
   }

   /**
    * Returns a current step field
    *
    * @param string $step_id for a specific step
    */
   public function get_step_field( string $field = '', string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_field( $field );
   }

   /**
    * Renders the step options html
    *
    * @param string $step_id for a specific step
    */
   public function render_step_options( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      $args = [
         'size_unit' => $this->get_size_unit()
      ];
      $this->_current_step->render_options( $this->get_step_configuration(), $args );
      return true;
   }

   /**
    * Returns the current step explanation (post) id
    *
    * An id of a post in the database with post type 'explanation'
    *
    * @param string $step_id for a specific step
    */
   public function get_step_explanation_id( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_explanation_id();
   }

   /**
    * Returns the current step validation rules
    *
    * @param string $step_id for a specific step
    * @param string $field for a specific rule
    */
   public function get_validation_rules( string $step_id = '', string $field = '' ) {
      $this->set_current_step( $step_id );
      return $this->_current_step->get_validation_rules( $field, $this->get_size_unit() );
   }

   /**
    * Returns an array of usps when exist in $_settings
    */
   public function get_usps() {
      return ! empty( $this->_settings['usps'] ) ? $this->_settings['usps'] : false;
   }

   /**
    * Calculates the default price table based on $_default_configuration
    */
   protected function calculate_default_price_table() {
      $this->_default_price_table = $this->calculate_price_table( $this->_default_configuration );
   }

   /**
    * Returns a summary array of the configuration
    *
    * @param string $message a message to add to the summary array
    */
   public function get_summary( string $message = '' ) {

      $summary = [];

      if ( empty( $this->_configuration ) ) return;

      foreach ( $this->_configuration as $step_id => $input ) {

         if ( ! empty( $input ) ) {
            $option_title = $this->get_option_title( $step_id, $input );
            $value = $option_title ? $option_title : $input;
         } else {
            $value = __( 'Geen' );
         }

         $summary[] = [
            'label' => $this->get_step_title( $step_id ),
            'value' => $value
         ];
      }

      if ( ! empty( $message ) ) {
         $summary[] = [
            'label' => __( 'Opmerking', 'glasbestellen' ),
            'value' => sanitize_textarea_field( $message )
         ];
      }
      return $summary;
   }

   /**
    * Used to set a start price that is always included inside the total
    */
   public function get_starting_price() {
      return ! empty( $this->_settings['starting_price'] ) ? str_replace( ',', '.', $this->_settings['starting_price'] ) : 0;
   }

   /**
    * Returns the current configuration price table
    */
   public function get_price_table() {
      return $this->_price_table;
   }

   /**
    * Returns a configurator url with configuration encoded included
    */
   public function get_configuration_url() {
      if ( empty( $this->_configuration ) ) return;
      $data = [
         'configurator_id' => $this->_configurator_id,
         'configuration'   => urlencode( json_encode( $this->_configuration ) )
      ];
      return add_query_arg( $data, get_permalink( $this->_configurator_id ) );
   }

   /**
    * Default price table calculation
    *
    * Is often overruled by specific price table methods in child configurators
    */
   protected function calculate_price_table( array $configuration = [] ) {

      if ( empty( $configuration ) ) return;

      $price_table = [];
      $default = $this->_default_configuration;

      $m2s = 0;

      if ( ! empty( $configuration['width'] ) && ! empty( $configuration['height'] ) ) {
         $m2s = \Calculate::to_square_meters( $configuration['width'], $configuration['height'] );
      }

      if ( ! empty( $default['glasstype'] ) ) {
         $price_table['glass'] = $m2s * $this->get_option_price( 'glasstype', $default['glasstype'] );
      }

      foreach ( $configuration as $step_id => $input ) {

         $option_price = 0;

         if ( $this->get_option_price( $step_id, $input ) ) {
            $option_price = $this->get_option_price( $step_id, $input );
         }

         switch ( $step_id ) {

            case 'glasstype' :
               if ( ! empty( $default['glasstype'] ) ) {
                  $price_default         = $this->get_option_price( 'glasstype', $default['glasstype'] );
                  $price_table[$step_id] = $m2s * ( $option_price - $price_default );
               }
               break;

            default :
               $price_table[$step_id] = $option_price;
         }

      }
      return $price_table;

   }

}
