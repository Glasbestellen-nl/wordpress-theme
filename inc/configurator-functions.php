<?php
use Configurator\Configurator_Setup;

function gb_get_configurator( $configurator_id = 0, $auto_set = true ) {

   $type = gb_get_configurator_type( $configurator_id );

   $configurator = Configurator_Setup::get_instance( $type, $configurator_id );

   // If there is already something configured
   if ( gb_get_configuration_session( $configurator_id ) && $auto_set ) {
      $configurator->update( gb_get_configuration_session( $configurator_id ) );
   }
   return $configurator;
}

function gb_set_configuration_session( int $configurator_id, array $configuration = [] ) {
   if ( empty( $configurator_id ) || empty( $configuration ) ) return;
   $_SESSION['configuration'][$configurator_id] = $configuration;
}

function gb_unset_configuration_session( int $configurator_id ) {
   if ( empty( $configurator_id ) ) return;
   unset( $_SESSION['configuration'][$configurator_id] );
}

function gb_get_configuration_session( int $configurator_id ) {
   return ! empty( $_SESSION['configuration'][$configurator_id] ) ? $_SESSION['configuration'][$configurator_id] : false;
}

function gb_get_configurator_type( int $configurator_id ) {
   $settings = gb_get_configurator_settings( $configurator_id );
   return ( isset( $settings['type'] ) ) ? $settings['type'] : false;
}

function gb_get_configurator_settings( int $configurator_id ) {
   if ( $settings = get_post_meta( $configurator_id, 'configurator_settings', true ) ) {
      return $settings;
   }
   return false;
}

function gb_get_configurator_explanation_page_id( int $configurator_id = 0 ) {
   return get_field( 'explanation_page_id', $configurator_id );
}

function gb_get_configurator_save_form_cta( int $configurator_id = 0 ) {
   $term_id = get_first_term_by_id( $configurator_id, 'startopstelling' );
   if ( empty( $term_id ) ) return;
   return get_field( 'save_form_cta', 'term_' . $term_id );
}
