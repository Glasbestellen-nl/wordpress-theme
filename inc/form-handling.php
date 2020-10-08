<?php
/**
 * Handles lead form submit
 */
function gb_handle_lead_form_submit() {

   $additional_message = sprintf( __( 'Stuur een e-mail naar <strong>%s</strong> om de bijlages alsnog te versturen.', 'glasbestellen' ), get_option( 'company_email' ) );

   $response = [];
   $error = false;

   // Check nonce for security
   check_ajax_referer( GB_NONCE, 'nonce' );

   if ( ! empty( $_POST['lead'] ) ) {

      if ( ! empty( $_FILES['attachment'] ) ) {

         $count = count( $_FILES['attachment']['name'] );

         // Error checking and prepare files for upload
         for ( $i = 0; $i < $count; $i ++ ) {

            // Check file type
            if ( ! empty( $_FILES['attachment']['type'][$i] ) && ! in_array( $_FILES['attachment']['type'][$i], get_allowed_mime_types() ) ) {
               $error  = sprintf( __( 'Er kunnen helaas geen bijlages van het type "%s" verstuurd worden.', 'glasbestellen' ), $_FILES['attachment']['type'][$i] );
               $error .= ' ' . $additional_message;
               break;
            }

            $attachments[$i] = [
               'tmp_name' => $_FILES['attachment']['tmp_name'][$i],
               'name'     => $_FILES['attachment']['name'][$i],
               'size'     => $_FILES['attachment']['size'][$i],
               'type'     => $_FILES['attachment']['type'][$i]
            ];

         }
      }

      if ( ! $error ) {

         // Insert lead, retrieve lead id
         $lead_id = CRM::insert_lead( $_POST['lead'] );

         // Saves client related fields
         if ( ! empty( $_POST['client'] ) ) {
            foreach ( $_POST['client'] as $name => $value ) {
               if ( ! empty( $value ) ) {
                  CRM::update_lead_meta( $lead_id, $name, $value );
               }
            }
         }

         // Saves request uri
         if ( ! empty( $_POST['request_uri'] ) ) {
            CRM::update_lead_meta( $lead_id, 'request_uri', $_POST['request_uri'] );
         }

         // Saves attachments (files)
         if ( ! empty( $attachments ) ) {

            foreach ( $attachments as $index => $attachment ) {

               $filename = $attachment['name'];
               $path = gb_get_lead_attachments_dir() . '/' . $lead_id;
               if ( ! is_dir( $path ) ) {
                  mkdir( $path );
               }
               $destination = $path . '/' . $filename;
               move_uploaded_file( $attachment['tmp_name'], $destination );

            }
         }
         do_action( 'gb_lead_form_submit_before_redirect', $lead_id, $_POST );

         // Set redirect url on success
         $response['redirect'] = apply_filters( 'gb_lead_form_submit_redirect_url', get_permalink( get_option( 'page_lead_success' ) ), $_POST );

      } else {
         $response['error'] = $error;
      }

   }

   echo json_encode( $response );

   wp_die();

}
add_action( 'wp_ajax_handle_lead_form_submit', 'gb_handle_lead_form_submit' );
add_action( 'wp_ajax_nopriv_handle_lead_form_submit', 'gb_handle_lead_form_submit' );

function gb_handle_save_configuration_form_submit() {

   $response = [];

   echo json_encode( $response );

   wp_die();
}
add_action( 'wp_ajax_handle_save_configuration_form_submit', 'gb_handle_save_configuration_form_submit' );
add_action( 'wp_ajax_nopriv_handle_save_configuration_form_submit', 'gb_handle_save_configuration_form_submit' );

/**
 * Handles review form submit
 */
function gb_handle_review_form_submit() {

   $response = [];
   $error = false;

   // Check nonce for security
   check_ajax_referer( GB_NONCE, 'nonce' );

   if ( ! empty( $_POST['review'] ) ) {

      $review = [];

      foreach ( $_POST['review'] as $name => $value ) {
         if ( ! empty( $value ) ) {
            $review[$name] = $value;
         } else {
            $error = __( 'Er is iets mis gegaan, probeer het a.u.b. opnieuw', 'glasbestellen' );
            break;
         }
      }

      if ( ! $error ) {

         $postarr = [
            'post_title' => $review['title'],
            'post_content' => $review['message'],
            'post_type' => 'review',
         ];

         if ( $post_id = wp_insert_post( $postarr, true ) ) {
            foreach ( ['name', 'email', 'rating'] as $key ) {
               update_post_meta( $post_id, $key, $review[$key] );
            }
         }

         $response['redirect'] = get_permalink( get_option( 'page_review_success' ) );

      }
   }

   echo json_encode( $response );

   wp_die();
}
add_action( 'wp_ajax_handle_review_form_submit', 'gb_handle_review_form_submit' );
add_action( 'wp_ajax_nopriv_handle_review_form_submit', 'gb_handle_review_form_submit' );
