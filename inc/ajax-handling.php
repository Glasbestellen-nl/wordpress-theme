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
         require_once( TEMPLATEPATH . '/template-parts/' . $_GET['formtype'] . '-form.php' );
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

   $html .= '<div class="modal__column text">';
   ob_start();
   $explanation = new WP_Query( 'post_type=uitleg&p=' . $_GET['post_id'] );
   if ( $explanation->have_posts() ) {
      while ( $explanation->have_posts() ) {
         $explanation->the_post();
         $html .= the_content();
      }
   }
   $html .= ob_get_clean();
   $html .= '</div>';

   $response['html']  = $html;
   $response['title'] = get_the_title( $_GET['post_id'] );

   wp_send_json( $response );

   wp_die();

}
add_action( 'wp_ajax_get_explanation_content', 'gb_handle_get_explanation_content' );
add_action( 'wp_ajax_nopriv_get_explanation_content', 'gb_handle_get_explanation_content' );
