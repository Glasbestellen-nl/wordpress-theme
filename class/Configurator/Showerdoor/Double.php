<?php
namespace Configurator\Showerdoor;

class Double extends \Configurator {

   public function __construct( $configurator_id ) {
      parent::__construct( $configurator_id );
   }

   public function set_configuration( $c = [] ) {

      if ( empty( $c ) )
         return;

      foreach ( $c as $step_id => $input ) {

         if ( $step_id == 'dimensions' ) {

            $slot = false;

            if ( ! empty( $c['strips'] ) ) {
               $part = $this->get_step_part( $step_id, $c['strips'] );
               if ( ! empty( $part['slot'] ) ) {
                  $slot = $part['slot'];
               }
            }

            $ow = $input['opening_width'];
            $oh = $input['opening_height'];

            $this->add_row( __( 'Afmetingen opening', 'glasbestellen' ), $ow . 'mm x ' . $oh . 'mm' );

            // Deduction per door
            $ddw = 5;
            $ddh = 5;

            if ( $slot ) {

               switch( $slot ) {

                  case '1':
                     $ddh = 15;
                     break;
                  case '2':
                     $ddw - 13;
                     break;
                  case '3':
                     $ddw = 13;
                     $ddh = 15;
                     break;
               }
            }

            $gw = ( $ow / 2 ) - $ddw;
            $gh = $oh - $ddh;

            $this->add_row( __( 'Deur links', 'glasbestellen' ), $gw . 'mm x ' . $gh . 'mm' );
            $this->add_row( __( 'Deur rechts', 'glasbestellen' ), $gw . 'mm x ' . $gh . 'mm' );

         } else {
            $this->add_row(
               $this->get_step_title( $step_id ),
               get_the_title( $input )
            );
         }

      }

      if ( ! $this->get_errors() ) {
         $this->configuration = $c;
      }
   }

}
