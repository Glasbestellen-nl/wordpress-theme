<?php
namespace Configurator\Configurators\Showerdoor;

class Configurator extends \Configurator\Configurator {

   public function __construct( int $configurator_id = 0 ) {
      parent::__construct( $configurator_id );
   }

   protected function calculate_price_table( array $configuration = [] ) {

      if ( empty( $configuration ) ) return;

      $price_table = [];
      $default = $this->_default_configuration;

      $m2s = 0;

      if ( ! empty( $configuration['width'] ) && ! empty( $configuration['height'] ) ) {
         $m2s = \Calculate::to_square_meters( $configuration['width'], $configuration['height'] );

         if ( ! empty( $default['glasstype'] ) ) {
            $price_table['glass'] = $m2s * $this->get_option_price( 'glasstype', $default['glasstype'] );
         }
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
            case 'coating' :
               $price_table[$step_id] = $m2s * $option_price;
               break;

            default :
               $price_table[$step_id] = $option_price;
         }

      }
      return $price_table;

   }

}
