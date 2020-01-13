<?php
/**
 * Renders order confirmation email html
 */
function gb_render_order_confirmation_email( $template ) {

   if ( ! empty( $_GET['order_email'] ) ) {

      $transaction_id = $_GET['order_email'];
      $transaction = new Transaction( $transaction_id );

      $email = gb_get_order_confirmation_email_object( $transaction );
      $email->render_html();

      return;
   }
   return $template;
}
add_action( 'template_include', 'gb_render_order_confirmation_email' );

/**
 * Initalized order confirmation object by transaction input
 */
function gb_get_order_confirmation_email_object( Transaction $transaction ) {

   if ( empty( $transaction ) ) return;

   $template_path = get_template_directory() . '/email-templates/order-confirmation.php';

   $data['billing']          = $transaction->get_billing_data();
   $data['delivery_address'] = $transaction->get_delivery_data();
   $data['order_id']         = $transaction->get_transaction_id();
   $data['total_price']      = $transaction->get_total_price();
   $data['items']            = $transaction->get_items();
   $data['shipping']         = true;

   $email = new HTML_Email( $template_path, $data );

   return $email;

}
