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

            $opening = new \Rectangle( $input['opening_width'], $input['opening_height'] );
            $door = new \Rectangle( $input['opening_width'] / 2, $input['opening_height'] );

            // Deduction per door
            $door->deduct_width(5);
            $door->deduct_length(5);

            if ( $slot ) {

               // Glass deduction by type of strips
               switch ( $slot ) {

                  case '1':
                     $door->deduct_length(10);
                     break;
                  case '2':
                     $door->deduct_width(7);
                     break;
                  case '3':
                     $door->deduct_width(7);
                     $door->deduct_length(10);
                     break;
               }
            }

            // Add customised rows to product summary
            $this->add_row( __( 'Afmetingen opening', 'glasbestellen' ), $opening->display_dimensions() );
            $this->add_row( __( 'Deur links', 'glasbestellen' ), $door->display_dimensions() );
            $this->add_row( __( 'Deur rechts', 'glasbestellen' ), $door->display_dimensions() );

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
