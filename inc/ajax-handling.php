<?php
/**
 * Handles AJAX request to retrieve data for building modal body
 */
function gb_handle_get_form_modal_input() {

   $html = '';

   if ( ! empty( $_GET['formtype'] ) ) {

      // Create form html by form type
      $html .= '<div class="modal__column">';
         ob_start();
         get_template_part( 'template-parts/' . $_GET['formtype'] . '-form' );
         $html .= ob_get_clean();
      $html .= '</div>';

   }
   echo $html;

   wp_die();

}
add_action( 'wp_ajax_get_form_modal_input', 'gb_handle_get_form_modal_input' );
add_action( 'wp_ajax_nopriv_get_form_modal_input', 'gb_handle_get_form_modal_input' );

/**
 * Handles AJAX request to retrieve explanation content
 */
function gb_handle_get_explanation_content() {

   $response = [];
   $html = '';

   if ( empty( $_GET['post_id'] ) ) wp_die();

   $post = get_post( $_GET['post_id'] );

   $html .= '<div class="modal__column text">';
      $html .= wpautop( $post->post_content );
   $html .= '</div>';

   $response['html'] = $html;
   $response['title'] = $post->post_title;

   wp_send_json( $response );

   wp_die();

}
add_action( 'wp_ajax_get_explanation_content', 'gb_handle_get_explanation_content' );
add_action( 'wp_ajax_nopriv_get_explanation_content', 'gb_handle_get_explanation_content' );
