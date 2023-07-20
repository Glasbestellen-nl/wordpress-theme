<?php
namespace Configurator\Configurators\Mirror;

class Oval_Mirror extends \Configurator\Configurator {

   public function __construct( int $configurator_id = 0 ) {
      parent::__construct( $configurator_id );
   }

   protected function calculate_price_table( array $configuration = [] ) {

      if ( empty( $configuration ) ) return;

      $price_table = [
         'size' => 0,
         'large_shipping' => 0
      ];

      if ( ! empty( $configuration['width'] ) && ! empty( $configuration['height'] ) ) {

         $width  = $configuration['width'];
         $height = $configuration['height'];

         if ( $this->get_step_options( 'width' ) ) {
            $width = $this->get_option_value( $configuration['width'], 'width' );
         }
         if ( $this->get_step_options( 'height' ) ) {
            $height = $this->get_option_value( $configuration['height'], 'height' );
         }

         if ( $price_matrix = $this->get_price_matrix() ) {

            if ( $this->get_size_unit() == 'cm' ) {
               $x_value  = $this->convert_to_mm( $width );
               $y_value  = $this->convert_to_mm( $height );
            }

            $price_table['size'] = $price_matrix->get_price( $x_value, $y_value );

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

            $largest_size   = ( $width >= $height ) ? $width : $height;
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
      }

      foreach ( $configuration as $step_id => $input ) {

         $option_price = 0;

         if ( $this->get_option_price( $input, $step_id ) !== false ) {
            $option_price = $this->get_option_price( $input, $step_id );
            $price_table[$step_id] = $option_price;
         }

      }
      return $price_table;
   }

}
