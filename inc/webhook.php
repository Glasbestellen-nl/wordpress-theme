<?php
use TheIconic\Tracking\GoogleAnalytics\Analytics;

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

            // 1. Send confirmation email to customer and admin
            $email_template = gb_get_order_confirmation_email_html( $transaction );
            $email = new Email( __( 'Orderbevestiging en Factuur', 'glasbestellen' ) );
            $email->set_template( $email_template );
            $email->add_receiver_email( $transaction->get_billing_data( 'email' ) );
            $email->add_receiver_email( get_bloginfo( 'admin_email' ) );
            $email->send();

            // 2. Send ecommerce data to google analytics
            $analytics = new Analytics();
            $analytics->setProtocolVersion('1')
               ->setTrackingId( get_option( 'ga_tracking_id' ) )
               ->setClientId( $transaction->get_client_data( 'gclid' ) );

            $analytics->setTransactionId( $transaction->get_transaction_id() )
               ->setAffiliation( 'online' )
               ->setRevenue( $transaction->get_total_price() )
               ->setShipping( $transaction->get_total_shipping_price() )
               ->setTax( Money::vat( $transaction->get_total_price() ) )
               ->sendTransaction();

            $cart = new Cart( $transaction->get_items() );

            // Transaction item requests to analytics
            while ( $cart->have_items() ) {
               $cart->the_item();
               $analytics->setTransactionId( $transaction->get_transaction_id() )
                  ->setItemName( $cart->get_item_title() )
                  ->setItemCode( $cart->get_item_post_id() )
                  ->setItemCategory( $cart->get_item_category() )
                  ->setItemPrice( $cart->get_item_price() )
                  ->setItemQuantity( $cart->get_item_quantity() )
                  ->sendItem();
            }

         }

      } catch ( \Mollie\Api\Exceptions\ApiException $e ) {
          echo "API call failed: " . htmlspecialchars( $e->getMessage() );
      }

      return;

   }

   return $template;

}
add_action( 'template_include', 'gb_webhook_template_include' );
