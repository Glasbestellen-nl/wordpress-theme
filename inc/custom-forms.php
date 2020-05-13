<?php
/**
 * Adds form meta boxes
 */
function gb_add_form_meta_boxes() {
   add_meta_box( 'form-settings-meta-box', __( 'Settings', 'glasbestellen' ), 'gb_form_settings_meta_box_callback', 'form' );
}
add_action( 'add_meta_boxes', 'gb_add_form_meta_boxes' );

/**
 * Renders form settings meta box
 */
function gb_form_settings_meta_box_callback( $post ) {

   $form_settings = gb_get_form_settings( $post->ID );
   $value = ( $form_settings ) ? json_encode( $form_settings, JSON_PRETTY_PRINT ) : '';

   $html = '<p><textarea name="form_settings" class="large-text tab-support js-tab-support" rows="20">' . $value . '</textarea></p>';
   echo $html;
}

/**
 * Saves form post settings
 */
function gb_save_form( $post_id ) {

   if ( ! empty( $_POST['form_settings'] ) ) {
      $value = stripslashes( $_POST['form_settings'] );
      if ( json_decode( $value ) != NULL ) {
         update_post_meta( $post_id, 'form_settings', json_decode( $value, true ) );
      }
   }
}
add_action( 'save_post_form', 'gb_save_form' );

/**
 * Returns form settings by form id
 */
function gb_get_form_settings( int $form_id ) {
   return get_post_meta( $form_id, 'form_settings', true );
}
