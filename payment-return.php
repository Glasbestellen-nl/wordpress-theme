<?php
// Template name: Payment return
get_header();
?>

   <main class="main-section main-section--space-around main-section--grey">

      <div class="container">

         <section class="layout">

            <div class="layout__column box-shadow text">

               <?php
               $headline = __( 'Geen betaling', 'glasbestellen' );
               $subline  = __( 'Er heeft geen betaling plaatsgevonden..', 'glasbestellen' );

               if ( ! empty( $_GET['order_id'] ) ) {
                  $transaction = new Transaction( $_GET['order_id'] );
                  $customer_email = $transaction->get_billing_data( 'email' );
                  switch ( $transaction->get_status() ) {
                     case 'paid' :
                        $headline = __( 'Betaling ontvangen!', 'glasbestellen' );
                        $subline  = '<p>' . sprintf( __( 'Bedankt voor je bestelling. We hebben een bevestigingsmail naar <strong>%s</strong> gestuurd.', 'glasbestellen' ), $customer_email ) . '</p>';
                        break;
                     case 'canceled' :
                        $headline = __( 'Betaling geannuleerd', 'glasbestellen' );
                        $subline  = '<p>' . sprintf( __( 'De betaling is geannuleerd. Bezoek de <a href="%s">checkout pagina</a> om je bestelling als nog af te ronden.', 'glasbestellen' ), gb_get_checkout_url() ) . '</p>';
                        break;
                  }
                  ?>

               <?php } ?>

               <h1><?php echo $headline; ?></h1>
               <?php echo $subline; ?>

            </div>

         </section>

      </div>

   </main>

<?php get_footer(); ?>
