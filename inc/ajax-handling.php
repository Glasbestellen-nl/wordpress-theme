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

/**
 * Handles AJAX request to get single pin html
 */
function gb_get_single_popup_html() {

   if ( empty( $_GET['post_id'] ) ) wp_die();

   $query = new WP_Query( 'post_type=inspiratie&p=' . $_GET['post_id'] );

   if ( $query->have_posts() ) {
      while ( $query->have_posts() ) {
         $query->the_post();
         echo '<div class="large-space-around">';
            get_template_part( 'template-parts/single-pin' );
         echo '</div>';
      }
   }
   wp_die();
}
add_action( 'wp_ajax_get_single_popup_html', 'gb_get_single_popup_html' );
add_action( 'wp_ajax_nopriv_get_single_popup_html', 'gb_get_single_popup_html' );
