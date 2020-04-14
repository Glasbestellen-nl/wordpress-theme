<?php
namespace Configurator\Configurators\Tabletop;

class Round extends \Configurator\Configurator {

   public function __construct( int $configurator_id = 0 ) {
      parent::__construct( $configurator_id );
   }

   protected function calculate_price_table( array $configuration = [] ) {

      if ( empty( $configuration ) ) return;

      $price_table = [];

      $m2s = 0;

      if ( ! empty( $configuration['diameter'] ) ) {
         $m2s = \Calculate::to_square_meters( $configuration['diameter'], $configuration['diameter'] );
      }

      if ( $min_surface = $this->get_metadata( 'min_surface' ) ) {
         $m2s = ( $m2s < $min_surface ) ? $min_surface : $m2s;
      }

      if ( ! empty( $this->_settings['metadata']['edging_price'] ) ) {
         $edging_price = $this->_settings['metadata']['edging_price'];
         $circumference = \Calculate::to_circumference( $configuration['diameter'], $configuration['diameter'] );
         $price_table['edging'] = $circumference * $edging_price;
      }

      foreach ( $configuration as $step_id => $input ) {

         $option_price = 0;

         if ( $this->get_option_price( $step_id, $input ) ) {
            $option_price = $this->get_option_price( $step_id, $input );
         }

         switch ( $step_id ) {

            case 'glasstype' :
               $price_table[$step_id] = ( $m2s * $option_price ) * 1.8;
               break;

            default :
               $price_table[$step_id] = $option_price;
         }
      }

      return $price_table;

   }

}
