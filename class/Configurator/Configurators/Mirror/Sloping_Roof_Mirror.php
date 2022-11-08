<?php
namespace Configurator\Configurators\Mirror;

class Sloping_Roof_Mirror extends \Configurator\Configurator {

   public function __construct( int $configurator_id = 0 ) {
      parent::__construct( $configurator_id );
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
      $allowed_null = ['width_top', 'width_bottom', 'height_left', 'height_right'];
      foreach ( $configuration as $step_id => $input ) {
         if ( ( $input == 0 && in_array( $step_id, $allowed_null ) || ! empty( $input ) ) && $this->get_step_by_id( $step_id ) )
            $filtered[$step_id] = $input;
      }
      return $filtered;
   }

   /**
    * Returns the current step configuration
    *
    * @param string $step_id for a specific step
    */
   public function get_step_configuration( string $step_id = '' ) {
      $this->set_current_step( $step_id );
      $step_id = $this->get_step_id();
      return isset( $this->_configuration[$step_id] ) ? $this->_configuration[$step_id] : false;
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
      $show_default = $this->_current_step->get_field( 'show_default' );
      if ( $value === false ) return $this->get_step_default() ? $this->get_step_default() : false;
      return $value;
   }

   protected function calculate_price_table( array $configuration = [] ) {

      if ( empty( $configuration ) ) return;

      $price_table = [
         'size' => 0,
         'large_shipping' => 0
      ];

      // Calculate square meters
      $width_top      = ! empty( $configuration['width_top'] ) ? $configuration['width_top'] : 0;
      $width_bottom   = ! empty( $configuration['width_bottom'] ) ? $configuration['width_bottom'] : 0;
      $height_left    = ! empty( $configuration['height_left'] ) ? $configuration['height_left'] : 0;
      $height_right   = ! empty( $configuration['height_right'] ) ? $configuration['height_right'] : 0;

      // Get largest height and width
      $width  = $width_top >= $width_bottom ? $width_top : $width_bottom;
      $height = $height_left >= $height_right ? $height_left : $height_right;

      if ( $width == 0 ) $width = $this->get_step_default( 'width_top' );
      if ( $height == 0 ) $height = $this->get_step_default( 'height_top' );

      // if ( $this->get_size_unit() == 'cm' ) {
      //    $width  = $this->convert_to_mm( $width );
      //    $height = $this->convert_to_mm( $height );
      // }

      if ( $price_matrix = $this->get_price_matrix() ) {
         $price_table['size'] = $price_matrix->get_price( $width, $height );
         if ( $multiplier = $this->get_metadata( 'price_matrix_multiplier' ) ) {
            $price_table['size'] *= $multiplier;
         }
      }

      // Extra shipping large products
      if ( ( $width > 1199 ) || ( $height > 1199 ) ) {
         $price_table['large_shipping'] = $this->get_metadata( 'large_shipping' );
      }

      // Price addition for large sizes
      if ( $size_price_additions = $this->get_setting( 'size_price_additions' ) ) {

         $largest_size = ( $width >= $height ) ? $width : $height;
         $price_addition = 0;
         $latest_largest = 0;

         foreach ( $size_price_additions as $row ) {
            if ( $largest_size > $row['size'] && $row['size'] > $latest_largest ) {
               $price_addition = $row['price'];
               $latest_largest = $row['size'];
            }
         }
         $price_table['large_size'] = $price_addition;
      }

      foreach ( $configuration as $step_id => $input ) {

         $option_price = 0;

         if ( $this->get_option_price( $step_id, $input ) !== false ) {
            $option_price = $this->get_option_price( $step_id, $input );
            $price_table[$step_id] = $option_price;
         }

      }
      return $price_table;
   }

}
