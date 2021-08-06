<?php
namespace Configurator\Configurators\Mirror;

class Led_Mirror extends \Configurator\Configurator {

   public function __construct( int $configurator_id = 0 ) {
      parent::__construct( $configurator_id );
   }

   protected function calculate_price_table( array $configuration = [] ) {

      if ( empty( $configuration ) ) return;

      $price_table = [
         'size' => 0,
         'large_shipping' => 0
      ];

      // Calculate square meters
      if ( ! empty( $configuration['width'] ) && ! empty( $configuration['height'] ) ) {

         if ( $price_matrix = $this->get_price_matrix() ) {
            $price_table['size'] = $price_matrix->get_price( $configuration['width'], $configuration['height'] );
            if ( $multiplier = $this->get_metadata( 'price_matrix_multiplier' ) ) {
               $price_table['size'] *= $multiplier;
            }
         }

         // Extra shipping large products
         if ( ( $configuration['width'] > 1199 ) || ( $configuration['height'] > 1199 ) ) {
            $price_table['large_shipping'] = $this->get_metadata( 'large_shipping' );
         }

         // Price addition for large sizes
         if ( $size_price_additions = $this->get_setting( 'size_price_additions' ) ) {

            $largest_size = ( $configuration['width'] >= $configuration['height'] ) ? $configuration['width'] : $configuration['height'];
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

         if ( $this->get_option_price( $step_id, $input ) !== false ) {
            $option_price = $this->get_option_price( $step_id, $input );
            $price_table[$step_id] = $option_price;
         }

      }
      return $price_table;
   }

}
