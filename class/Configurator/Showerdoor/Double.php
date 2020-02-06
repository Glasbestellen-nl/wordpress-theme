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

}
