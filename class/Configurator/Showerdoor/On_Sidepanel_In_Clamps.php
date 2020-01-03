<?php
namespace Configurator\Showerdoor;

class On_Sidepanel_In_Clamps extends \Configurator {

   public function __construct( $configurator_id ) {
      parent::__construct( $configurator_id );
   }

   public function set_configuration( $configuration = [] ) {

      if ( empty( $configuration ) )
         return;

      foreach ( $configuration as $step_id => $input ) {

         if ( $step_id == 'dimensions' ) {

            $slot = $this->get_part_slot( $step_id, $configuration['strips'] );

            $opening  = new \Rectangle( $input['opening_width'], $input['opening_height'] );
            $door     = new \Rectangle( $input['door_width'], $input['opening_height'] );
            $panel    = new \Rectangle( $input['opening_width'] - $input['door_width'], $input['opening_height'] );

            // Default deduction
            $door->deduct_width(4);
            $door->deduct_length(5);
            $panel->deduct_width(5);

            // Deduction based on strips
            switch ( $slot ) {

               case 1 :
                  $door->deduct_length(10);
                  break;

               case 2 :
                  $door->deduct_width(6);
                  break;

               case 3 :
                  $door->deduct_width(6);
                  $door->deduct_height(10);
                  break;
            }

            // Add rows to product summary
            $this->add_row( __( 'Afmetingen opening', 'glasbestellen' ), $opening->display_dimensions() );
            $this->add_row( __( 'Afmetingen deur', 'glasbestellen' ), $door->display_dimensions() );
            $this->add_row( __( 'Afmetingen zijpaneel', 'glasbestellen' ), $panel->display_dimensions() );

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
