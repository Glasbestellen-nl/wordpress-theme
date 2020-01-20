<?php
abstract class Configurator {

   // Holds configurator (post) id
   protected $id;

   // Holds settings
   protected $settings;

   // Holds steps
   protected $steps;

   // Holds current step
   protected $step;

   // Holds current step index
   protected $current_step;

   // Holds configuration
   protected $configuration = [];

   // Holds array of errors
   protected $errors;

   // Holds array of configuration summary
   protected $summary;

   public function __construct( $configurator_id ) {
      $this->id = $configurator_id;
      $this->settings = gb_get_configurator_settings( $configurator_id );
      $this->steps = ! empty( $this->settings['steps'] ) ? $this->settings['steps'] : false;
      $this->step = false;
      $this->current_step = 0;
      $this->errors = false;
   }

   /**
    * Sets configuration
    */
   abstract function set_configuration( $configuration = [] );

   /**
    * Returns configuration
    */
   public function get_configuration( $step_id = null, $field = null ) {

      if ( empty( $step_id ) )
         return $this->configuration;

      if ( empty( $this->configuration[$step_id] ) )
         return;

      if ( ! is_array( $this->configuration[$step_id] ) )
         return $this->configuration[$step_id];

      if ( ! empty( $field ) )
         return $this->configuration[$step_id][$field];
   }

   /**
    * Returns default configuration
    */
   public function get_default_configuration( $step_id = null ) {

      $configuration = [];

      if ( empty( $this->steps ) )
         return;

      foreach ( $this->steps as $step ) {
         $id = $step['id'];
         if ( ! empty( $step['default'] ) ) {
            $configuration[$id] = $step['default'];
         } elseif ( ! empty( $step['parts'] ) ) {
            foreach ( $step['parts'] as $part ) {
               if ( ! empty( $part['default'] ) ) {
                  $configuration[$id] = $part['id'];
               }
            }
         }
      }

      if ( ! empty( $step_id ) ) {
         return ! empty( $configuration[$step_id] ) ? $configuration[$step_id] : [];
      }

      return $configuration;
   }

   /**
    * Returns total price
    */
   public function get_total_price( $round = true ) {

      $total = 0;
      $d = $this->calculate_price_table( $this->get_default_configuration() );
      $c = $this->calculate_price_table( $this->configuration );

      if ( ! empty( $d ) ) {
         foreach ( $d as $step_id => $price ) {
            if ( ! empty( $c[$step_id] ) ) {
               $total += $c[$step_id];
            } else {
               $total += $price;
            }
         }
      }

      // Shipping
      if ( ! empty( $this->settings['shipping'] ) ) {
         $total += $this->settings['shipping'];
      }

      // Rounds off so that the included VAT price is always a round number
      if ( $round ) {
         $vat = ( get_option( 'vat_percentage' ) ) ? ( get_option( 'vat_percentage' ) / 100 ) + 1 : 1.21;
         $total = ceil( $total * $vat ) / $vat;
      }

      return $total;
   }

   /**
    * Returns errors
    */
   public function get_errors() {
      return $this->errors;
   }

   /**
    * Adds error
    */
   public function add_error( $id, $message ) {
      $this->errors[] = [
         'id' => $id,
         'message' => $message
      ];
   }

   /**
    * Checks whether all steps are configured
    */
   public function configuration_done() {
      return ( count( $this->configuration ) === count( $this->steps ) );
   }

   /**
    * Checks whether there are steps available
    */
   public function have_steps() {
      return $this->current_step < count( $this->steps );
   }

   /**
    * Sets current step and sets pointer to next step
    */
   public function the_step() {
      $this->step = $this->steps[$this->current_step];
      $this->current_step ++;
   }

   /**
    * Returns configurator id
    */
   public function get_id() {
      return $this->id;
   }

   /**
    * Returns step id
    */
   public function get_step_id() {
      return $this->get_step_field( 'id' );
   }

   /**
    * Returns step title
    */
   public function get_step_title( $step_id = null ) {
      return $this->get_step_field( 'title', $step_id );
   }

   /**
    * Returns step placeholder
    */
   public function get_step_placeholder( $step_id = null ) {
      return $this->get_step_field( 'placeholder', $step_id );
   }

   /**
    * Returns step description
    */
   public function get_step_description( $step_id = null ) {
      return $this->get_step_field( 'description', $step_id );
   }

   /**
    * Returns step type
    */
   public function get_step_type( $step_id = null ) {
      return $this->get_step_field( 'type', $step_id );
   }

   /**
    * Returns step visual
    */
   public function get_step_visual( $step_id = null ) {
      return $this->get_step_field( 'visual', $step_id );
   }

   /**
    * Returns step configured image
    */
   public function get_step_image( $step_id = null ) {

      if ( empty( $step_id ) )
         $step_id = $this->step['id'];

      if ( $choice = $this->get_step_choice( $step_id, false ) ) {
         if ( $image_url = get_the_post_thumbnail_url( $choice, 'medium' ) ) {
            return $image_url;
         }
         return false;
      }
      return false;
   }

   /**
    * Returns step parts
    */
   public function get_step_parts( $step_id = null ) {
      if ( $parts = $this->get_step_field( 'parts', $step_id ) ) {
         return array_map( function( $part ) {
            return [
               'id' => $part['id'],
               'title' => get_the_title( $part['id'] ),
               'description' => get_the_excerpt( $part['id'] ),
               'price' => isset( $part['price'] ) ? $part['price'] : null,
               'img' => get_the_post_thumbnail_url( $part['id'], 'medium' )
            ];
         },
         $parts );
      }
      return false;
   }

   /**
    * Returns step part
    */
   public function get_step_part( $step_id = null, $part_id = null ) {
      if ( $parts = $this->get_step_parts( $step_id ) ) {
         $index = array_search( $part_id, array_column( $parts, 'id' ) );
         return $parts[$index];
      }
      return false;
   }

   /**
    * Returns part price
    */
   public function get_part_price( $step_id = null, $part_id = null ) {
      if ( $part = $this->get_step_part( $step_id, $part_id ) ) {
         return isset( $part['price'] ) ? $part['price'] : 0;
      }
      return 0;
   }

   /**
    * Returns part slot
    */
   public function get_part_slot( $step_id = null, $part_id = null ) {

      if ( empty( $part_id ) )
         return;

      if ( $part = $this->get_step_part( $step_id, $part_id ) ) {
         return isset( $part['slot'] ) ? $part['slot'] : false;
      }
      return false;
   }

   /**
    * Returns part price difference
    */
   public function get_part_price_difference( $step_id = null, $part_id = null ) {

      $c_price = $this->get_part_price( $step_id, $part_id );

      if ( $default_part = $this->get_default_configuration( $step_id ) ) {
         $d_price = $this->get_part_price( $step_id, $default_part );
         return $c_price - $d_price;
      }
      return 0;
   }

   /**
   * Returns the price of a step based on the difference of
   * the base price table and configured price table
   */
   public function get_step_price() {

      $price = 0;

      $step_id = $this->step['id'];

      $d = $this->calculate_price_table( $this->get_default_configuration() );
      $c = $this->calculate_price_table( $this->configuration );

      if ( isset( $c[$step_id] ) ) {
         $c_price = $c[$step_id];
      } else {
         $c_price = 0;
      }

      if ( isset( $d[$step_id] ) ) {
         $d_price = $d[$step_id];
      } else {
         $d_price = 0;
      }

      if ( $c_price > $d_price ) {
         $price = $c_price - $d_price;
      }

      return $price;
   }


   /**
    * Returns current step
    */
   public function get_current_step() {
      return $this->step;
   }

   /**
    * Returns step choice
    */
   public function get_step_choice( $step_id = null, $default = true ) {
      if ( ! empty( $this->configuration[$step_id] ) ) {
         return $this->configuration[$step_id];
      } elseif ( $default ) {
         $default_configuration = $this->get_default_configuration();
         return $default_configuration[$step_id];
      }
      return false;
   }

   /**
    * Returns step field
    */
   public function get_step_field( $field, $step_id = null ) {

      if ( $step_id ) {
         $step = $this->get_step_by_id( $step_id );
      } else {
         $step = $this->step;
      }

      return isset( $step[$field] ) ? $step[$field] : false;
   }

   /**
    * Returns a step by id
    */
   public function get_step_by_id( $step_id ) {
      $index = array_search( $step_id, array_column( $this->steps, 'id' ) );
      if ( $index !== FALSE ) {
         return $this->steps[$index];
      }
      return false;
   }

   /**
    * Checks whether a step is done
    */
   public function is_step_done( $step_id = null ) {

      if ( empty( $step_id ) )
         $step_id = $this->step['id'];

      return isset( $this->configuration[$step_id] );
   }

   /**
    * Returns formatted step configuration
    */
   public function get_formatted_step_configuration( $step_id = null ) {

      if ( empty( $step_id ) )
         $step_id = $this->step['id'];

      if ( ! empty( $this->configuration[$step_id] ) ) {

         $configuration = $this->configuration[$step_id];

         if ( $this->get_step_parts() ) {
            $part_id = $configuration;
            return get_the_title( $part_id );

         } elseif ( is_array( $configuration ) ) {
            if ( $format = $this->get_step_field( 'format', $step_id ) ) {
               foreach ( $configuration as $field => $value ) {
                  $format = str_replace( '{' . $field . '}', $value, $format );
               }
               return $format;
            }
         }
      }
      return false;
   }

   /**
    * Returns validation rules for a field
    */
   public function get_validation_rules( $step_id = null, $field = null ) {

      if ( $step = $this->get_step_by_id( $step_id ) ) {
         return ! empty( $step['rules'][$field] ) ? json_encode( $step['rules'][$field] ) : false;
      }
      return false;
   }

   public function get_usps() {
      return ! empty( $this->settings['usps'] ) ? $this->settings['usps'] : false;
   }

   /**
    * Returns configuration summary
    */
   public function get_summary() {
      return ! empty( $this->summary ) ? $this->summary : false;
   }

   /**
    * Adds a row to the summary
    */
   public function add_row( $label, $value ) {
      $this->summary[] = [
         'label' => $label,
         'value' => $value
      ];
      return true;
   }

   /**
    * Calculates square meters
    */
   public function calculate_square_meters( $width = 0, $length = 0 ) {
      return ( $width * $length ) / 1000000;
   }

   /**
    * Calculates prices per steps
    */
   public function calculate_price_table( $c = [] ) {

      $price_table = [];

      $d = $this->get_default_configuration();

      if ( ! empty( $c ) ) {

         $m2s = 0;

         if ( ! empty( $c['dimensions']['opening_width'] ) && ! empty( $c['dimensions']['opening_height'] ) ) {
            $m2s = $this->calculate_square_meters( $c['dimensions']['opening_width'], $c['dimensions']['opening_height'] );
         }

         foreach ( $c as $step_id => $input ) {

            $part_price = 0;
            $price_default = 0;

            if ( $this->get_part_price( $step_id, $input ) ) {
               $part_price = $this->get_part_price( $step_id, $input );
            }

            switch ( $step_id ) {

               case 'dimensions' :
                  if ( ! empty( $d['glasstype'] ) ) {
                     $price_table[$step_id] = $m2s * $this->get_part_price( 'glasstype', $d['glasstype'] );
                  }
                  break;

               case 'glasstype' :
                  if ( ! empty( $d['glasstype'] ) ) {
                     $price_default         = $this->get_part_price( 'glasstype', $d['glasstype'] );
                     $price_table[$step_id] = $m2s * ( $part_price - $price_default );
                  }
                  break;

               case 'coating' :
                  $price_table[$step_id] = $m2s * $part_price;
                  break;

               default :
                  $price_table[$step_id] = $part_price;
            }
         }
      }
      return $price_table;
   }

}
