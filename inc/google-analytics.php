<?php
use TheIconic\Tracking\GoogleAnalytics\Analytics;

/**
 * Adds datalayer to site header to exchange data google tag manager
 */
function gb_google_analytics_datalayer() { ?>

   <script>
      dataLayer = [];
   </script>

   <?php
   if ( ! empty( $_GET['order_id'] ) ) {
      $transaction = new Transaction( $_GET['order_id'] );
      if (
         get_queried_object_id() == get_option( 'payment_redirect_url' )
         && 'paid' == $transaction->get_status() ) { ?>

         <script>
            dataLayer.push({
               'event': 'paymentSuccess',
               'transactionRevenue': <?php echo $transaction->get_total_price(); ?>
            });
         </script>
      <?php
      }
   }
   ?>

<?php
}
add_action( 'gb_top_of_head', 'gb_google_analytics_datalayer' );

/**
 * Handles webhook requests on template include hook
 */
function gb_push_order_data_to_google_analytics( $order_id ) {

   try {

      $order = wc_get_order( $order_id );
      $ga_tracking_id = get_option( 'ga_tracking_id' );
      $gclid = get_field( 'gclid', $order_id );

      if ( ! $ga_tracking_id || ! $gclid ) return;

      // Send ecommerce data to google analytics
      $analytics = new Analytics();
      $analytics->setProtocolVersion('1')
         ->setTrackingId( $ga_tracking_id )
         ->setClientId( $gclid );

      $analytics->setTransactionId( $order_id )
         ->setAffiliation( 'online' )
         ->setRevenue( $order->get_total() )
         ->setShipping( $order->get_shipping_total() )
         ->setTax( $order->get_total_tax() )
         ->sendTransaction();

      // Transaction item requests to analytics
      $category_ids = [];
      $acw = Active_Campaign_Wrapper::get_instance();

      $billing_email = $order->get_billing_email();
      $items = $order->get_items();
      if ( $items ) {
         foreach ( $items as $item_id => $item ) {
            $category_id = get_first_term_by_id( $item->get_product_id(), 'product_cat', 'term_id' );
            $analytics->setTransactionId( $item_id )
               ->setItemName( $item->get_name() )
               ->setItemCode( $item->get_product_id() )
               ->setItemCategory( $category_id )
               ->setItemPrice( $item->get_total() )
               ->setItemQuantity( $item->get_quantity() )
               ->sendItem();

            // ActiveCampaign
            if ( $category_id && ! in_array( $category_id, $category_ids ) ) {
               $acw->log_event( $billing_email, 'configured_product_purchase', 'category_' . $category_id );
            }
            $category_ids[] = $category_id;
         }
      }

   } catch ( \Mollie\Api\Exceptions\ApiException $e ) {
         echo "API call failed: " . htmlspecialchars( $e->getMessage() );
   }
}
add_action( 'woocommerce_order_status_completed', 'gb_push_order_data_to_google_analytics' );