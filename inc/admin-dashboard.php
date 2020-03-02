<?php
/**
 * Adds widgets to dashboard
 */
function gb_dashboard_setup() {

   wp_add_dashboard_widget( 'leads', __( 'Leads', 'glasbestellen' ), 'gb_leads_dashboard_widget' );
   wp_add_dashboard_widget( 'transactions', __( 'Transacties', 'glasbestellen' ), 'gb_transactions_dashboard_widget' );

}
add_action( 'wp_dashboard_setup', 'gb_dashboard_setup' );

/**
 * Leads dashboard widget
 */
function gb_leads_dashboard_widget() {

   $period = 'day';

   if ( ! empty( $_GET['leads_period'] ) ) {
      $period = $_GET['leads_period'];
   }

   if ( CRM::get_leads() )
      $leads = array_filter( CRM::get_leads(), function( $lead ) use( $period ) {
         return gb_filter_leads_by_date( $lead, $period );
      });

   if ( CRM::get_leads_by_status( 'open' ) )
      $open_leads = array_filter( CRM::get_leads_by_status( 'open' ), function( $lead ) use( $period ) {
         return gb_filter_leads_by_date( $lead, $period );
      });

   ?>

   <div class="widget-summary">

      <form method="post" class="widget-summary-form">

         <div class="widget-summary-row">

            <select name="leads_period" class="widget-summary-dropdown" onchange="this.form.submit()">
               <option value="day" <?php selected( $period, 'day' ); ?>><?php _e( 'Vandaag', 'glasbestellen' ); ?></option>
               <option value="week" <?php selected( $period, 'week' ); ?>><?php _e( 'Laatste 7 dagen', 'glasbestellen' ); ?></option>
               <option value="month" <?php selected( $period, 'month' ); ?>><?php _e( 'Laatste 30 dagen', 'glasbestellen' ); ?></option>
            </select>

         </div>

         <div class="widget-summary-row widget-summary-stats">
            <div class="widget-summary-stat">
               <span class="description"><?php _e( 'Totaal', 'glasbestellen' ); ?></span>
               <span class="value"><?php echo ! empty( $leads ) ? count( $leads ) : 0; ?></span>
            </div>
            <div class="widget-summary-stat">
               <span class="description"><?php _e( 'Open', 'glasbestellen' ); ?></span>
               <span class="value"><?php echo ! empty( $open_leads ) ? count( $open_leads ) : 0; ?></span>
            </div>
         </div>

      </form>

      <?php if ( ! empty( $open_leads ) ) { ?>

         <div class="widget-summary-table">
            <table class="wp-list-table widefat fixed striped">
               <thead>
                  <tr>
                     <th scope="col" width="60%"><?php _e( 'Open leads', 'glasbestellen' ); ?></th>
                     <th scope="col" width="40%"><?php _e( 'Datum', 'glasbestellen' ); ?></th>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach ( $open_leads as $lead ) { ?>
                     <tr>
                        <td><a href="<?php echo admin_url( 'admin.php?page=crm&lead_id=' . $lead->lead_relation ); ?>"><?php echo $lead->relation_name; ?></a></td>
                        <td><?php echo date_format( date_create( $lead->lead_date ), 'd M Y H:i' ); ?></td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>

      <?php } ?>

   </div>

   <?php

}

/**
 * Transaction dashboard widget
 */
function gb_transactions_dashboard_widget() {

   $args = [
      'post_type' => 'transactie',
      'post_per_page' => -1,
      'post_status' => 'publish',
      'meta_query' => [
         [
            'key' => 'transaction_status',
            'value' => 'paid',
         ]
      ]
   ];

   $period = 'day';

   if ( ! empty( $_GET['transactions_period'] ) ) {
      $period = $_GET['transactions_period'];
   }

   switch ( $period ) {

      // Last 30 days
      case 'month' :
         $date_query = [
            'after' => '1 month ago'
         ];
         break;

      // Last 7 days
      case 'week' :
         $date_query = [
            'after' => '1 week ago'
         ];
         break;

      // Today
      case 'day' :
         $date = getdate();
         $date_query = [
            'year'   => $date['year'],
            'month'  => $date['mon'],
            'day'    => $date['mday']
         ];
         break;
   }
   $args['date_query'][] = $date_query;

   $transactions = get_posts( $args );

   $total_revenue = array_reduce( $transactions, function( $carry, $item ) {
      $transaction = new Transaction( $item->ID );
      $carry += $transaction->get_total_price();
      return $carry;
   });
   ?>

   <div class="widget-summary">

      <form method="post" class="widget-summary-form">

         <div class="widget-summary-row">

            <select name="transactions_period" class="widget-summary-dropdown" onchange="this.form.submit()">
               <option value="day" <?php selected( $period, 'day' ); ?>><?php _e( 'Vandaag', 'glasbestellen' ); ?></option>
               <option value="week" <?php selected( $period, 'week' ); ?>><?php _e( 'Laatste 7 dagen', 'glasbestellen' ); ?></option>
               <option value="month" <?php selected( $period, 'month' ); ?>><?php _e( 'Laatste 30 dagen', 'glasbestellen' ); ?></option>
            </select>

         </div>

         <div class="widget-summary-row widget-summary-stats">
            <div class="widget-summary-stat">
               <span class="description"><?php _e( 'Aantal', 'glasbestellen' ); ?></span>
               <span class="value"><?php echo ! empty( $transactions ) ? count( $transactions ) : 0; ?></span>
            </div>
            <div class="widget-summary-stat">
               <span class="description"><?php _e( 'Omzet ex. BTW.', 'glasbestellen' ); ?></span>
               <span class="value"><?php echo Money::display( $total_revenue, false ); ?></span>
            </div>
         </div>

      </form>

      <?php if ( ! empty( $transactions ) ) { ?>
         <div class="widget-summary-table">
            <table class="wp-list-table widefat fixed striped">
               <thead>
                  <tr>
                     <th scope="col" width="60%"><?php _e( 'Product', 'glasbestellen' ); ?></th>
                     <th scope="col" width="40%"><?php _e( 'Omzet', 'glasbestellen' ); ?></th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  foreach ( $transactions as $post ) {
                     $transaction = new Transaction( $post->ID );
                     $items = array_map( function( $item ) {
                        return get_the_title( $item['post_id'] );
                     }, $transaction->get_items() );
                     ?>
                     <tr>
                        <td><a href="<?php echo get_edit_post_link( $transaction->get_post_id() ); ?>"><?php echo implode( ',', $items ); ?></a></td>
                        <td><?php echo Money::display( $transaction->get_total_price(), false ); ?></td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
      <?php } ?>

   </div>

   <?php
}

/**
 * Callback function to filter leads by date
 */
function gb_filter_leads_by_date( $lead, $period = 'day' ) {

   $now = time();
   $lead_time = strtotime( $lead->lead_date );

   switch ( $period ) {
      case 'day' :
         $period_time = strtotime( '-1 day', $now );
         break;
      case 'week' :
         $period_time = strtotime( '-1 week', $now );
         break;
      case 'month' :
         $period_time = strtotime( '-1 month', $now );
         break;
   }
   return $lead_time >= $period_time;
}

/**
 * Dashboard widget form submissions
 */
function gb_dashboard_widget_submit() {

   // Check if there are already arguments set
   $args = ! empty( $_GET ) ? $_GET : [];

   // Transactions period
   if ( isset( $_POST['transactions_period'] ) ) {
      $args['transactions_period'] = $_POST['transactions_period'];
      $redirect = add_query_arg( $args, admin_url() );
   }

   // Leads period
   if ( isset( $_POST['leads_period'] ) ) {
      $args['leads_period'] = $_POST['leads_period'];
      $redirect = add_query_arg( $args, admin_url() );
   }

   if ( isset( $redirect ) ) {
      exit( wp_redirect( $redirect ) );
   }

}
add_action( 'admin_init', 'gb_dashboard_widget_submit' );
