<?php
namespace Configurator\Configurators\Showerdoor;

class Configurator extends \Configurator\Configurators\Using_Parts\Configurator {

   public function __construct( int $configurator_id = 0 ) {
      parent::__construct( $configurator_id );
   }

   protected function calculate_price_table( array $configuration = [] ) {

      if ( empty( $configuration ) ) return;

      $price_table = [];
      $default = $this->_default_configuration;

      $m2s = 0;

      if ( ! empty( $configuration['dimensions']['opening_width'] ) && ! empty( $configuration['dimensions']['opening_height'] ) ) {
         $m2s = \Calculate::to_square_meters( $configuration['dimensions']['opening_width'], $configuration['dimensions']['opening_height'] );
      }

      foreach ( $configuration as $step_id => $input ) {

         $part_price = 0;

         if ( $this->get_part_price( $step_id, $input ) ) {
            $part_price = $this->get_part_price( $step_id, $input );
         }

         switch ( $step_id ) {

            case 'dimensions' :
               if ( ! empty( $default['glasstype'] ) ) {
                  $price_table[$step_id] = $m2s * $this->get_part_price( 'glasstype', $default['glasstype'] );
               }
               break;

            case 'glasstype' :
               if ( ! empty( $default['glasstype'] ) ) {
                  $price_default         = $this->get_part_price( 'glasstype', $default['glasstype'] );
                  $price_table[$step_id] = $m2s * ( $part_price - $price_default );
               }
               break;

            case 'coating' :
               $price_table[$step_id] = $m2s * $part_price;
               break;

            default :
               $price_table[$step_id] = $part_price;
         }
         $price_table[$step_id] = $part_price;

      }
      return $price_table;
   }

}
