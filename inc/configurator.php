<?php
use Configurator\Configurator_Setup;

/**
 * Add configurator body classes
 */
function gb_configurator_body_class( $class ) {

   if ( is_tax( 'startopstelling' ) || ( is_singular( 'configurator' ) && ! is_page_template() ) )
      $class[] = 'body--grey';

   if ( is_singular( 'configurator' ) )
      $class[] = 'js-configurator';

   return $class;
}
add_action( 'body_class', 'gb_configurator_body_class' );

/**
 * Hide main nav in configurator
 */
function gb_configurator_hide_main_nav( $show_nav ) {

   if ( is_tax( 'startopstelling' ) || ( is_singular( 'configurator' ) && ! is_page_template() ) ) {
      $show_nav = false;
   }

   return $show_nav;
}
add_filter( 'gb_show_main_nav', 'gb_configurator_hide_main_nav' );

/**
 * Changes step part price difference output based on step id
 */
function gb_filter_part_price_difference( $value, $step_id ) {

   if ( in_array( $step_id, ['glasstype', 'coating'] ) ) {
      $value = sprintf( __( '%s per m2', 'glasbestellen' ), $value );
   }
   elseif ( $step_id == 'rotate_direction' ) {
      return;
   }
   return '+ ' . $value;
}
add_filter( 'gb_step_part_price_difference', 'gb_filter_part_price_difference', 10, 2 );

/**
 * AJAX handles get total configuration price
 */
function gb_get_configurator_total_price() {

   if ( ! empty( $_GET['configurator_id'] ) ) {
      $configurator_id = $_GET['configurator_id'];
      $configurator = gb_get_configurator( $configurator_id );
      echo Money::display( $configurator->get_total_price() );
   }
   wp_die();

}
add_action( 'wp_ajax_get_configurator_total_price', 'gb_get_configurator_total_price' );
add_action( 'wp_ajax_nopriv_get_configurator_total_price', 'gb_get_configurator_total_price' );

/**
 * Handles AJAX configurator step submit
 */
function gb_handle_configurator_form_submit() {

   $response = [];

   if ( empty( $_POST['configurator_id'] ) ) wp_die();

   $configurator_id = $_POST['configurator_id'];

   if ( ! empty( $_POST['configuration'] ) ) {

      $configurator = gb_get_configurator( $configurator_id );
      $configurator->update( $_POST['configuration'] );

      $_SESSION['configuration'][$configurator_id] = $configurator->get_configuration();
   }

   wp_send_json( $response );
   wp_die();
}
add_action( 'wp_ajax_handle_configurator_form_submit', 'gb_handle_configurator_form_submit' );
add_action( 'wp_ajax_nopriv_handle_configurator_form_submit', 'gb_handle_configurator_form_submit' );

function gb_handle_configurator_to_cart() {

   $response = [];

   if ( empty( $_POST['configurator_id'] ) ) wp_die();

   $configurator_id = $_POST['configurator_id'];
   $configurator = gb_get_configurator( $configurator_id );

   $cart = gb_get_cart();

   $price         = $configurator->get_total_price();
   $summary       = $configurator->get_summary( $_POST['message'] );
   $configuration = $configurator->get_configuration();
   $cart->add_item( $configurator_id, $price, $_POST['quantity'], $summary, $configuration );

   gb_update_cart_session_items( $cart->get_items() );
   gb_unset_configuration_session( $configurator_id );

   $response['url'] = gb_get_cart_url();

   wp_send_json( $response );

   wp_die();
}
add_action( 'wp_ajax_handle_configurator_to_cart', 'gb_handle_configurator_to_cart' );
add_action( 'wp_ajax_nopriv_handle_configurator_to_cart', 'gb_handle_configurator_to_cart' );

/**
 * Load configuration by url
 */
function gb_handle_configuration_load() {

   if ( ! empty( $_GET['configurator_id'] ) && ! empty( $_GET['configuration'] ) ) {

      // Store configuration in session
      $configuration = json_decode( stripslashes( $_GET['configuration'] ), true );
      gb_set_configuration_session( $_GET['configurator_id'], $configuration );

      // Redirect to url without parameters so the paramters could not be set again
      $redirect_url = remove_query_arg( ['configurator_id', 'configuration'] );
      wp_redirect( $redirect_url );
      exit;
   }
}
add_action( 'init', 'gb_handle_configuration_load' );

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
