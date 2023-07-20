<?php
namespace Configurator\Configurators\Door;

class Sliding_Door_Simple extends \Configurator\Configurator {

   public function __construct( int $configurator_id = 0 ) {
      parent::__construct( $configurator_id );
   }

   protected function calculate_price_table( array $configuration = [] ) {

      if ( empty( $configuration ) ) return;

      $price_table = [
         'size' => 0,
         'large_shipping' => 0
      ];

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
