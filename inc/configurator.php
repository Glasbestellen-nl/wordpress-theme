<?php
use Configurator\Configurator_Setup;

function gb_configurator_show_price_table_array() {

   if ( ! empty( $_GET['show_price_table'] ) && is_singular( 'configurator' ) ) {

      global $post;

      $configurator = gb_get_configurator( $post->ID );
      echo '<pre>';
      var_dump( $configurator->get_price_table() );
      echo '</pre>';
   }
}
add_action( 'wp', 'gb_configurator_show_price_table_array' );


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

   if ( ! empty( $_GET['product_id'] ) ) {
      $product = wc_get_product( $_GET['product_id'] );
      $configurator = $product->get_configurator();
      echo wc_price( wc_get_price_including_tax( $product ) );
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

   global $woocommerce;

   $response = [];

   if ( empty( $_POST['product_id'] ) ) wp_die();

   $product = wc_get_product( $_POST['product_id'] );
   $configurator = $product->get_configurator();

   $cart_item_data = ['custom_price' => $configurator->get_total_price()];
   $woocommerce->cart->add_to_cart( $_POST['product_id'], $_POST['quantity'], null, null, $cart_item_data );
   $woocommerce->cart->calculate_totals();
   $woocommerce->cart->set_session();
   $woocommerce->cart->maybe_set_cart_cookies();

   gb_unset_configuration_session( $configurator->get_id() );

   $response['url'] = wc_get_cart_url();

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
