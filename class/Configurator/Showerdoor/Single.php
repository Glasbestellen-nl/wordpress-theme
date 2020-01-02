<?php
namespace Configurator\Showerdoor;

class Single extends \Configurator {

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

            $gw = $ow - 6;
            $gh = $oh - 5;

            if ( $slot ) {

               switch( $slot ) {

                  case '1':
                     $gh = $oh - 15;
                     break;
                  case '2':
                     $gw = $ow - 12;
                     break;
                  case '3':
                     $gw = $ow - 12;
                     $gh = $oh - 15;
                     break;
               }
            }
            $this->add_row( __( 'Glasmaten', 'glasbestellen' ), $gw . 'mm x ' . $gh . 'mm' );

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
