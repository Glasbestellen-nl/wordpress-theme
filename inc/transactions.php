<?php
/*
* Add transactions custom table columns
*
* This function adds custom table columns to transactions
* admin overview
*/
function gb_transaction_table_head( $defaults ) {

  $columns = array();

  // Add new columns
  $defaults['total']    = __( 'Totaal incl. BTW.', 'glasbestellen' );
  $defaults['status'] 	= __( 'Status', 'glasbestellen' );

  foreach ( $defaults as $key => $value ) {

     // Place columns before date
     if ( 'date' == $key ) {
        $columns['total'] = '';
        $columns['status'] = '';
     }

     $columns[$key] = $value;
  }

  return $columns;

}
add_filter( 'manage_transactie_posts_columns', 'gb_transaction_table_head' );

/**
* Add transactions custom table columns content
*
* This function adds custom table columns content to transactions
* admin overview
*/
function gb_transaction_table_content( $column_name, $post_id ) {

   $transaction = new Transaction( $post_id );

  switch ( $column_name ) {

     case 'total' :
        echo Money::display( $transaction->get_total_price() );
        break;

     case 'status' :
        echo ucfirst( $transaction->get_status() );
        break;
  }

}
add_action( 'manage_transactie_posts_custom_column', 'gb_transaction_table_content', 10, 2 );

/**
 * Turns admin transactions order to newest first
 */
function gb_admin_transactions_order( $query ) {

   global $pagenow, $typenow;

   if ( 'transactie' === $typenow && 'edit.php' === $pagenow ) {
      $query->set( 'order', 'DESC' );
   }
   return $query;
}
add_action( 'pre_get_posts', 'gb_admin_transactions_order' );

/**
 * Adds transaction meta boxes
 */
function gb_add_transaction_meta_boxes() {
   add_meta_box( 'transaction_billing_meta_box', __( 'Factuur gegevens', 'glasbestellen' ), 'gb_transaction_billing_meta_box', 'transactie' );
   add_meta_box( 'transaction_delivery_meta_box', __( 'Afleveradres', 'glasbestellen' ), 'gb_transaction_delivery_meta_box', 'transactie' );
   add_meta_box( 'transaction_items_meta_box', __( 'Bestelde producten', 'glasbestellen' ), 'gb_transaction_items_meta_box', 'transactie' );
   add_meta_box( 'transaction_client_meta_box', __( 'Technische gegevens', 'glasbestellen' ), 'gb_transaction_client_meta_box', 'transactie' );
   add_meta_box( 'transaction_order_meta_box', __( 'Order gegevens', 'glasbestellen' ), 'gb_transaction_order_meta_box', 'transactie', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'gb_add_transaction_meta_boxes' );

/**
 * Transaction billing meta box
 */
function gb_transaction_billing_meta_box( $post ) {
   $transaction = new Transaction( $post->ID );
   if ( $data = $transaction->get_billing_data() ) {
   ?>

      <div class="space-medium">

         <?php if ( isset( $data['first_name'] ) && isset( $data['last_name'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Klant', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['first_name'] . ' ' . $data['last_name']; ?></span>
            </div>
         <?php } ?>

         <?php if ( isset( $data['email'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'E-mail', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['email']; ?></span>
            </div>
         <?php } ?>

         <?php if ( isset( $data['phone'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Telefoonnummer', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['phone']; ?></span>
            </div>
         <?php } ?>

         <?php if ( isset( $data['street'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Adres', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['street'] . ' ' . $data['number'] . ' ' . ( ! empty( $data['addition'] ) ? $data['addition'] : '' ) . ' ' . $data['zipcode'] . ', ' . $data['city']; ?></span>
            </div>
         <?php } ?>

         <?php if ( isset( $data['company'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Bedrijf', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['company']; ?></span>
            </div>
         <?php } ?>

         <?php if ( isset( $data['reference'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Referentie', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['reference']; ?></span>
            </div>
         <?php } ?>

      </div>

   <?php
   }
}

/**
 * Transaction delivery address meta box
 */
function gb_transaction_delivery_meta_box( $post ) {
   $transaction = new Transaction( $post->ID );
   if ( $data = $transaction->get_delivery_data() ) { ?>

      <div class="space-medium">

         <?php if ( isset( $data['street'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Straat', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['street']; ?></span>
            </div>
         <?php } ?>

         <?php if ( isset( $data['number'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Huisnummer', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['number']; ?></span>
            </div>
         <?php } ?>

         <?php if ( isset( $data['addition'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Toevoeging', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['addition']; ?></span>
            </div>
         <?php } ?>

         <?php if ( isset( $data['zipcode'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Postcode', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['zipcode']; ?></span>
            </div>
         <?php } ?>

         <?php if ( isset( $data['city'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Stad', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['city']; ?></span>
            </div>
         <?php } ?>

         <?php if ( isset( $data['country'] ) ) { ?>
            <div class="form-row">
               <label class="form-row-label"><?php _e( 'Land', 'glasbestellen' ); ?>:</label>
               <span><?php echo $data['country']; ?></span>
            </div>
         <?php } ?>

      </div>

   <?php
   } else {
      echo '<p>' . __( 'Gelijk aan factuuradres.', 'glasbestellen' ) . '</p>';
   }
}

/**
 * Transaction items meta box
 */
function gb_transaction_items_meta_box( $post ) {
   $transaction = new Transaction( $post->ID );
   if ( $items = $transaction->get_items() ) {
      $cart = new Cart( $items ); ?>

      <div class="space-medium">

         <table width="100%" class="items-table wp-list-table widefat fixed posts">

            <thead>
   				<tr>
   					<th><?php _e( 'Product', 'gtp_translate' ); ?></th>
   					<th><?php _e( 'Aantal', 'gtp_translate' ); ?></th>
   					<th><?php _e( 'Totaal', 'gtp_translate' ); ?></th>
   				</tr>
   			</thead>

            <tbody>

               <?php
               $count = 0;
               while ( $cart->have_items() ) {
                  $cart->the_item();
                  $count ++;
                  ?>

                  <tr class="<?php echo ( $count % 2 ) ? 'alternate' : ''; ?>">
                     <td>
                        <span class="item-title"><?php echo $cart->get_item_title(); ?> <a href="#" class="js-toggle-target" data-toggle-target="<?php echo '#item_summary_' . $count; ?>">(<?php _e( 'Details', 'glasbestellen' ); ?>)</a></span>

                        <?php if ( $cart->get_item_summary() ) { ?>

                           <div class="item-summary" id="<?php echo 'item_summary_' . $count; ?>" style="display: none;">

                              <?php if ( $configurator_reference = get_post_meta( $cart->get_item_post_id(), 'configurator_reference', true ) ) { ?>
                                 <div class="item-summary-row">
                                    <div class="item-summary-col item-summary-col-title"><?php _e( 'Referentie', 'glasbestellen' ); ?>:</div>
                                    <div class="item-summary-col"><?php echo $configurator_reference; ?></div>
                                 </div>
                              <?php } ?>

                              <?php foreach ( $cart->get_item_summary() as $row ) { ?>

                                 <div class="item-summary-row">
                                    <div class="item-summary-col item-summary-col-title"><?php echo $row['label']; ?>:</div>
                                    <div class="item-summary-col"><?php echo $row['value']; ?></div>
                                 </div>

                              <?php } ?>

                           </div>

                        <?php } ?>

                     </td>
                     <td><?php echo $cart->get_item_quantity(); ?></td>
                     <td><?php echo Money::display( $cart->get_item_price() ); ?></td>
                  </tr>

               <?php } ?>

            </tbody>

         </table>

      </div>

   <?php
   }
}

/**
 * Transaction order details meta box
 */
function gb_transaction_order_meta_box( $post ) {
   $transaction = new Transaction( $post->ID );
   if ( $transaction->get_total_price() ) {
   ?>

      <div class="space-medium">

         <div class="form-row">
            <label class="form-row-label"><?php _e( 'Order ID', 'glasbestellen' ); ?>:</label>
            <span><?php echo $transaction->get_transaction_id(); ?></span>
         </div>

         <div class="form-row">
            <label class="form-row-label"><?php _e( 'Status', 'glasbestellen' ); ?>:</label>
            <span><?php echo $transaction->get_status(); ?></span>
         </div>

         <div class="form-row">
            <label class="form-row-label"><?php _e( 'Totaal ex. 21% BTW', 'glasbestellen' ); ?>:</label>
            <span><?php echo Money::display( $transaction->get_total_price(), false ); ?></span>
         </div>

         <div class="form-row">
            <label class="form-row-label"><?php _e( '21% BTW', 'glasbestellen' ); ?>:</label>
            <span><?php echo Money::display( Money::vat( $transaction->get_total_price() ), false ); ?></span>
         </div>

         <div class="form-row">
            <label class="form-row-label"><?php _e( 'Totaal incl. 21% BTW', 'glasbestellen' ); ?>:</label>
            <span><?php echo Money::display( $transaction->get_total_price() ); ?></span>
         </div>

      </div>

   <?php
   }
}

/**
 * Transaction client details meta box
 */
function gb_transaction_client_meta_box( $post ) {
   $transaction = new Transaction( $post->ID );
   ?>

   <div class="space-medium">

      <div class="form-row">
         <label class="form-row-label"><?php _e( 'IP address', 'glasbestellen' ); ?>:</label>
         <span><?php echo $transaction->get_client_data( 'remote_address' ); ?></span>
      </div>

      <div class="form-row">
         <label class="form-row-label"><?php _e( 'Client ID', 'glasbestellen' ); ?>:</label>
         <span><?php echo $transaction->get_client_data( 'gclid' ); ?></span>
      </div>

   </div>

   <?php
}
