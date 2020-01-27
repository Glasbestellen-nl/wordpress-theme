<?php
/**
 * Handles checkout form
 */
function gb_handle_checkout_form() {

   $response = [];

   // Check whether form is submitted and billing fields are too
   if ( empty( $_POST['billing'] ) ) wp_die();

   $cart = gb_get_cart();
   $transaction = new Transaction;

   $billing = array_filter( $_POST['billing'], function( $value ) {
      return ! empty( $value );
   });
   $delivery_address = array_filter( $_POST['delivery_address'], function( $value ) {
      return ! empty( $value );
   });

   $transaction->update_billing_data( $billing );
   $transaction->update_delivery_data( $delivery_address );
   $transaction->update_client_data( $_POST['client'] );
   $transaction->update_items( $cart->get_items() );
   $transaction->update_total_price( $cart->get_total_price() );

   // Format the total value right (1000.00) including vat
   $value = number_format( Money::including_vat( $cart->get_total_price() ), 2, '.', '' );

   // Initialize mollie client
   $mollie = gb_get_mollie_client();

   // Create payment
   $payment = $mollie->payments->create([
      "amount" => [
         "currency" => "EUR",
         "value"    => $value
      ],
      "description" => sprintf( __( 'Bestelling #%s', 'glasbestellen' ), $transaction->get_transaction_id() ),
      "redirectUrl" => gb_get_payment_redirect_url(),
      "webhookUrl"  => gb_get_payment_webhook_url(),
      "metadata" => [
         "order_id" => $transaction->get_post_id(),
      ],
   ]);

   $response['redirect'] = $payment->getCheckoutUrl();

   echo json_encode( $response );

   wp_die();

}
add_action( 'wp_ajax_handle_checkout_form', 'gb_handle_checkout_form' );
add_action( 'wp_ajax_nopriv_handle_checkout_form', 'gb_handle_checkout_form' );

/**
 * Initializes mollie payment client
 */
function gb_get_mollie_client() {

   $api_key = ( get_option( 'payment_test_mode' ) )
      ? get_option( 'payment_api_key_test' ) 
      : get_option( 'payment_api_key_live' );

   // Initialize mollie client
   $mollie = new \Mollie\Api\MollieApiClient();

   // Set mollie api key
   $mollie->setApiKey( $api_key );

   return $mollie;
}

/**
 * Returns checkout page url
 */
function gb_get_checkout_url() {
   if ( $page_id = get_page_id_by_template( 'checkout.php' ) )
   return get_permalink( $page_id );
}

/**
 * Returns payment redirect url from options table
 */
function gb_get_payment_redirect_url() {
   return get_permalink( get_option( 'payment_redirect_url' ) );
}

/**
 * Returns payment webhook url from options table
 */
function gb_get_payment_webhook_url() {
   $option = get_option( 'payment_webhook_url' );
   return ( ! empty( $option ) ) ? $option : site_url( '/webhook' );
}
