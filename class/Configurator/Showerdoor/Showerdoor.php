<?php
namespace Configurator\Showerdoor;

class Showerdoor extends \Configurator {

   public function __construct( $configurator_id ) {
      parent::__construct( $configurator_id );
   }

   public function set_configuration( $configuration = [] ) {

      if ( empty( $configuration ) )
         return;

      foreach ( $configuration as $step_id => $input ) {

         if ( 'dimensions' == $step_id ) {
            $this->add_row( __( 'Breedte opening (A)', 'glasbestellen' ), $input['opening_width'] . 'mm' );
            $this->add_row( __( 'Hoogte opening (B)', 'glasbestellen' ), $input['opening_height'] . 'mm' );
         } else {
            $this->add_row(
               $this->get_step_title( $step_id ),
               get_the_title( $input )
            );
         }
      }

      if ( ! $this->get_errors() ) {
         $this->configuration = $configuration;
      }
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
