<?php
/**
 * Handles AJAX request to retrieve data for building modal body
 */
function gb_handle_get_form_modal_input() {

   $html = '';
   $response = [];

   if ( ! empty( $_GET['formtype'] ) ) {

      // Set title by form type
      switch ( $_GET['formtype'] ) {
         case 'lead' :
            $response['title'] = __( 'Offerte aanvragen', 'glasbestellen' );
            break;
         case 'review' :
            $response['title'] = __( 'Ervaring schrijven', 'glasbestellen' );
            break;
      }

      // Create form html by form type
      $html .= '<div class="modal__column">';
         ob_start();
         get_template_part( 'template-parts/' . $_GET['formtype'] . '-form' );
         $html .= ob_get_clean();
      $html .= '</div>';

      $response['html'] = $html;

   }

   echo json_encode( $response );
   wp_die();

}
add_action( 'wp_ajax_get_form_modal_input', 'gb_handle_get_form_modal_input' );
add_action( 'wp_ajax_nopriv_get_form_modal_input', 'gb_handle_get_form_modal_input' );
