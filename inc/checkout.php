<?php
/**
 * Handles checkout form
 */
function gb_handle_checkout_form() {

   // Check whether form is submitted and billing fields are too
   if ( ! isset( $_POST['submit_checkout_form'] ) || empty( $_POST['billing'] ) ) return;

   



   // Initialize mollie client
   $mollie = gb_get_mollie_client();

   // Initialize cart
   $cart = gb_get_cart();

   // Format the total value right (1000.00) including vat
   $value = number_format( Money::including_vat( $cart->get_total_price() ), 2, '.', '' );

   // Create payment
   $payment = $mollie->payments->create([
      "amount" => [
         "currency" => "EUR",
         "value"    => $value
      ],
      "description" => "My first API payment",
      "redirectUrl" => "https://webshop.example.org/order/12345/",
      "webhookUrl"  => "https://webshop.example.org/mollie-webhook/",
   ]);

   wp_redirect( $payment->getCheckoutUrl(), 303 );
   exit;

}
add_action( 'init', 'gb_handle_checkout_form' );

/**
 * Initializes mollie payment client
 */
function gb_get_mollie_client() {

   // Initialize mollie client
   $mollie = new \Mollie\Api\MollieApiClient();

   // Set mollie api key
   $mollie->setApiKey( 'test_1exrtgcKzYp3nAqiFJe7w9HZFFWGpj' );

   return $mollie;
}

/**
 * Returns checkout page url
 */
function gb_get_checkout_url() {
   if ( $page_id = get_page_id_by_template( 'checkout.php' ) )
   return get_permalink( $page_id );
}
