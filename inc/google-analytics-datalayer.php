<?php
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
