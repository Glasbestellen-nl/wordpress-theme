<?php
/**
 * Renders order confirmation email html
 */
function gb_render_email_template( $template ) {

   if ( current_user_can( 'administrator' ) ) {

      if ( ! empty( $_GET['lead_email'] ) ) {
         $html = gb_get_lead_request_email_html( $_GET['lead_email'] );
         echo $html;
         return;
      }

      elseif ( ! empty( $_GET['configuration_email'] ) ) {

         $html = gb_get_saved_configuration_email_html( $_GET['configuration_email'] );
         echo $html;
         return;
      }
   }
   return $template;
}
add_action( 'template_include', 'gb_render_email_template' );

/**
 * Sends email when lead form is submitted correctly
 */
function gb_send_lead_request_email( $lead_id, $post_data ) {

   $email_template = gb_get_lead_request_email_html( $lead_id );
   $email = new Email( __( 'We gaan voor u aan de slag!', 'glasbestellen' ) );
   $email->set_template( $email_template );
   $email->add_receiver_email( $post_data['lead']['email'] );
   $email->send();

}
add_action( 'gb_lead_form_submit_before_redirect', 'gb_send_lead_request_email', 0, 2 );


/**
 * Returns lead request email html
 */
function gb_get_lead_request_email_html( $lead_id ) {

   if ( empty( $lead_id ) ) return;

   $lead = CRM::get_lead( $lead_id );
   $relation = $lead->get_relation();

   $template_path = TEMPLATEPATH . '/email-templates/lead-request.php';

   $data = [
      'relation_name'   => $relation->get_name(),
      'message'         => $lead->get_content()
   ];

   $builder = new Email_Template_Builder( $template_path, $data );
   return $builder->get_html();
}

/**
 * Returns saved configuration email html
 */
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
