<?php
namespace Configurator\Showerdoor;

class Double extends \Configurator {

   public function __construct( $configurator_id ) {
      parent::__construct( $configurator_id );
   }

   public function set_configuration( $configuration = [] ) {

      if ( empty( $configuration ) )
         return;

      foreach ( $configuration as $step_id => $input ) {

         if ( $step_id == 'dimensions' ) {

            $slot = $this->get_part_slot( $step_id, $configuration['strips'] );

            $opening_width  = $input['opening_width'];
            $opening_height = $input['opening_height'];

            // Deduction per door
            $deduct_width  = 5;
            $deduct_height = 5;

            if ( $slot ) {

               // Glass deduction by type of strips
               switch ( $slot ) {

                  case '1':
                     $deduct_height = 15;
                     break;
                  case '2':
                     $deduct_width - 13;
                     break;
                  case '3':
                     $deduct_width = 13;
                     $deduct_height = 15;
                     break;
               }
            }

            $glass_width  = ( $opening_width / 2 ) - $deduct_width;
            $glass_height = $opening_height - $deduct_height;

            // Add customised rows to product summary
            $this->add_row( __( 'Afmetingen opening', 'glasbestellen' ), $opening_width . 'mm x ' . $opening_height . 'mm' );
            $this->add_row( __( 'Deur links', 'glasbestellen' ), $glass_width . 'mm x ' . $glass_height . 'mm' );
            $this->add_row( __( 'Deur rechts', 'glasbestellen' ), $glass_width . 'mm x ' . $glass_height . 'mm' );

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

}
