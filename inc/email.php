<?php
/**
 * Renders order confirmation email html
 */
function gb_render_order_confirmation_email( $template ) {

   if ( ! empty( $_GET['order_email'] ) ) {

      $transaction_id = $_GET['order_email'];
      $transaction = new Transaction( $transaction_id );

      $html = gb_get_order_confirmation_email_html( $transaction );
      echo $html;
      return;
   }
   elseif ( ! empty( $_GET['configuration_email'] ) ) {

      $html = gb_get_saved_configuration_email_html( $_GET['configuration_email'] );
      echo $html;
      return;
   }
   return $template;
}
add_action( 'template_include', 'gb_render_order_confirmation_email' );

/**
 * Returns order confirmation email html by transaction input
 */
function gb_get_order_confirmation_email_html( Transaction $transaction ) {

   if ( empty( $transaction ) ) return;

   $template_path = TEMPLATEPATH . '/email-templates/order-confirmation.php';

   $data['billing']          = $transaction->get_billing_data();
   $data['delivery_address'] = $transaction->get_delivery_data();
   $data['order_id']         = $transaction->get_transaction_id();
   $data['total_price']      = $transaction->get_total_price();
   $data['items']            = $transaction->get_items();
   $data['shipping']         = true;

   $builder = new Email_Template_Builder( $template_path, $data );

   return $builder->get_html();

}

function gb_get_saved_configuration_email_html( $lead_id ) {

   if ( empty( $lead_id ) ) return;

   $lead = CRM::get_lead( $lead_id );
   $relation = $lead->get_relation();

   $configurator_id     = CRM::get_lead_meta( $lead_id, 'saved_configurator', true );
   $raw_configuration   = CRM::get_lead_meta( $lead_id, 'saved_configuration', true );

   if ( empty( $configurator_id ) || empty( $raw_configuration ) ) return;

   $configuration = json_decode( stripslashes( $raw_configuration ), true );
   $configurator  = gb_get_configurator( $configurator_id, false );
   $configurator->update( $configuration );

   $template_path = TEMPLATEPATH . '/email-templates/saved-configuration.php';

   $data = [
      'relation_name'       => $relation->get_name(),
      'configurator_name'   => get_the_title( $configurator_id ),
      'configuration_url'   => $configurator->get_configuration_url(),
      'configuration_price' => $configurator->get_total_price(),
      'summary' => $configurator->get_summary(),
      'message' => $lead->get_content()
   ];

   $builder = new Email_Template_Builder( $template_path, $data );

   return $builder->get_html();

}

/**
 * Changes admin from email address
 */
function gb_mail_from( $email ) {
    $email = get_bloginfo( 'admin_email' );
    return $email;
}
add_filter( 'wp_mail_from', 'gb_mail_from' );

/**
 * Changes admin from email name
 */
function gb_mail_from_name( $name ) {
	$name = get_bloginfo( 'name' );
	return $name;
}
add_filter( 'wp_mail_from_name', 'gb_mail_from_name' );
