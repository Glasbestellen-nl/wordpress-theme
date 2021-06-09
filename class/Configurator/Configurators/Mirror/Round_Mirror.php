<?php
namespace Configurator\Configurators\Mirror;

class Round_Mirror extends \Configurator\Configurator {

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

         if ( $this->get_option_price( $step_id, $input ) !== false ) {
            $option_price = $this->get_option_price( $step_id, $input );
            $price_table[$step_id] = $option_price;
         }

      }
      return $price_table;
   }

}
