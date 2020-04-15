<?php
/**
 * Hooks into lead form handling to save configuration data
 */
function gb_lead_form_submit_save_configuration( $lead_id, $post_data ) {

   if ( ! empty( $post_data['configurator_id'] ) ) {
      CRM::update_lead_meta( $lead_id, 'saved_configurator', $post_data['configurator_id'] );
   }

   if ( ! empty( $post_data['configuration'] ) ) {
      CRM::update_lead_meta( $lead_id, 'saved_configuration', $post_data['configuration'] );
   }

   $email_template = gb_get_order_confirmation_email_html( $lead_id );
   $email = new Email( __( 'Uw opgeslagen samenstelling', 'glasbestellen' ) );
   $email->set_template( $email_template );
   $email->add_receiver_email( $post_data['lead']['email'] );
   $email->send();

}
add_action( 'gb_lead_form_submit_before_redirect', 'gb_lead_form_submit_save_configuration', 10, 2 );

/**
 * Changes lead submit redirect url when lead contains saved configuration
 */
function gb_save_configuration_redirect_url( $redirect_url, $post_data ) {

   if ( ! empty( $post_data['configuration'] ) ) {
      $redirect_url = get_permalink( get_option( 'page_save_configuration_success' ) );
   }
   return $redirect_url;
}
add_filter( 'gb_lead_form_submit_redirect_url', 'gb_save_configuration_redirect_url', 10, 2 );
