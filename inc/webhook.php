<?php
/**
 * Adds webhook query var
 */
function gb_add_webhook_query_vars( $vars ) {
   $vars[] = 'webhook';
   return $vars;
}
add_action( 'query_vars', 'gb_add_webhook_query_vars' );

/**
 * Adds webhook rewrite rule
 */
function gb_add_webhook_rewrite_rules() {
   add_rewrite_rule( '^webhook/?', 'index.php?webhook=1', 'top' );
}
add_action( 'init', 'gb_add_webhook_rewrite_rules' );

/**
 * Handles webhook requests on template include hook
 */
function gb_webhook_template_include( $template ) {

   if ( get_query_var( 'webhook' ) ) {

      if ( empty( $_POST['id'] ) ) return;

      try {

         $mollie  = gb_get_mollie_client();
         $payment = $mollie->payments->get( $_POST['id'] );
         $post_id = $payment->metadata->order_id;

         $transaction = new Transaction( $post_id );
         $transaction->update_status( $payment->status );

         if ( $payment->isPaid() && ! $payment->hasRefunds() && ! $payment->hasChargebacks() ) {

            // Send order confirmation email
            gb_get_order_confirmation_email_object( $transaction );
            $email->send();

            // Send data to Google Analytics


         } elseif ( $payment->isOpen() ) {
         } elseif ( $payment->isPending() ) {
         } elseif ( $payment->isFailed() ) {
         } elseif ( $payment->isExpired() ) {
         } elseif ( $payment->isCanceled() ) {
         } elseif ( $payment->hasRefunds() ) {
         } elseif ( $payment->hasChargebacks() ) {
         }

      } catch ( \Mollie\Api\Exceptions\ApiException $e ) {
          echo "API call failed: " . htmlspecialchars( $e->getMessage() );
      }

      return;

   }

   return $template;

}
add_action( 'template_include', 'gb_webhook_template_include' );
