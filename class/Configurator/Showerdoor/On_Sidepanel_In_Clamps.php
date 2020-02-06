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

         $this->add_row( __( 'Breedte opening (A)', 'glasbestellen' ), $input['opening_width'] . 'mm' );
         $this->add_row( __( 'Hoogte deur (B)', 'glasbestellen' ), $input['opening_height'] . 'mm' );
         $this->add_row( __( 'Breedte deur (C)', 'glasbestellen' ), $input['door_width'] . 'mm' );

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
