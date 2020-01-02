<?php
namespace Configurator\Showerdoor;

class Single extends \Configurator {

   public function __construct( $configurator_id ) {
      parent::__construct( $configurator_id );
   }

   public function set_configuration( $configuration = [] ) {

      if ( empty( $configuration ) )
         return;

      foreach ( $configuration as $step_id => $input ) {

         if ( 'dimensions' == $step_id ) {

            $slot = $this->get_part_slot( $step_id, $configuration['strips'] );

            $opening_width  = $input['opening_width'];
            $opening_height = $input['opening_height'];

            // Default glass dimensions
            $glass_width    = $opening_width  - 6;
            $glass_height   = $opening_height - 5;

            if ( $slot ) {

               // Glass deduction by type of strips
               switch ( $slot ) {

                  case '1':
                     $glass_height = $opening_height - 15;
                     break;

                  case '2':
                     $glass_width  = $opening_width  - 12;
                     break;

                  case '3':
                     $glass_width  = $opening_width  - 12;
                     $glass_height = $opening_height - 15;
                     break;
               }
            }

            // Add customised rows to product summary
            $this->add_row( __( 'Afmetingen opening', 'glasbestellen' ), $opening_width . 'mm x ' . $opening_height . 'mm' );
            $this->add_row( __( 'Glasmaten', 'glasbestellen' ), $glass_width . 'mm x ' . $glass_height . 'mm' );

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
