<?php
/**
 * Adds configurator meta boxes
 */
function gb_add_configurator_meta_boxes() {
   add_meta_box( 'configurator-settings-meta-box', __( 'Settings', 'glasbestellen' ), 'gb_configurator_settings_meta_box_callback', 'configurator' );
}
add_action( 'add_meta_boxes', 'gb_add_configurator_meta_boxes' );

/**
 * Renders configurator settings meta box
 */
function gb_configurator_settings_meta_box_callback( $post ) {

   if ( $value = gb_get_configurator_settings( $post->ID ) ) {
      $value = json_encode( $value, JSON_PRETTY_PRINT );
   } else {
      $value = '';
   }
   $html = '<p><textarea name="configurator_settings" class="large-text tab-support js-tab-support" rows="20">' . $value . '</textarea></p>';
   echo $html;
}

/**
 * Saves configurator post settings
 */
function gb_save_configurator( $post_id ) {

   if ( ! empty( $_POST['configurator_settings'] ) ) {

      // Strip slashes
      $value = stripslashes( $_POST['configurator_settings'] );

      // Check is valid json
      if ( json_decode( $value ) != NULL ) {

         // Update to database
         update_post_meta( $post_id, 'configurator_settings', json_decode( $value, true ) );
      }
   }
}
add_action( 'save_post_configurator', 'gb_save_configurator' );