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
 * Hooks into lead form submit handling to save custom form input
 */
function gb_submit_form_to_lead( $lead_id, $postdata ) {

   if ( empty( $postdata['form_id'] ) || empty( $postdata['custom_form'] ) ) return;

   $custom_form_data = [];
   $form_settings = gb_get_form_settings_object( $postdata['form_id'] );

   foreach ( $postdata['custom_form'] as $name => $value ) {
      $custom_form_data[$name] = [
         'name'  => $name,
         'label' => $form_settings->get_field_label_by_name( $name ),
         'value' => ! is_array( $value ) ? sanitize_text_field( $value ) : $value
      ];
   }

   CRM::update_lead_meta( $lead_id, 'custom_form_data', $custom_form_data );
   CRM::update_lead_meta( $lead_id, 'custom_form_id', $postdata['form_id'] );

}
add_action( 'gb_lead_form_submit_before_redirect', 'gb_submit_form_to_lead', 0, 2 );

/**
 * Renders custom form data in admin lead single summary
 */
function gb_custom_form_data_admin_lead_single_summary( $lead_id ) {

   $custom_form_data = CRM::get_lead_meta( $lead_id, 'custom_form_data', true );
   $custom_form_id   = CRM::get_lead_meta( $lead_id, 'custom_form_id', true );

   if ( ! $custom_form_data || ! $custom_form_id ) return;

   foreach ( $custom_form_data as $data ) {

      if ( ! empty( $data['value'] ) ) {

         $value = is_array( $data['value'] ) ? implode( ', ', $data['value'] ) : $data['value']; ?>

         <div class="form-row">
            <label class="form-row-label"><?php echo $data['label']; ?>:</label>
            <div class="form-row-text"><?php echo $value; ?></div>
         </div>

      <?php
      }
   }

}
add_action( 'gb_admin_lead_single_summary', 'gb_custom_form_data_admin_lead_single_summary' );

/**
 * Returns form settings by form id
 */
function gb_get_form_settings( int $form_id = 0 ) {
   return get_post_meta( $form_id, 'form_settings', true );
}

/**
 * Returns form settings by form id
 */
function gb_get_form_settings_object( int $form_id = 0 ) {
   $settings_array = gb_get_form_settings( $form_id );
   if ( ! $settings_array ) return;
   return new Custom_Forms\Form_Settings( $settings_array );
}

/**
 * Returns a form builder object by form id
 */
function gb_get_form_by_id( int $form_id = 0 ) {
   $form_settings = gb_get_form_settings_object( $form_id );
   if ( ! $form_settings ) return;
   $form = new Custom_Forms\Form_Builder( $form_settings, $form_id );
   return $form;
}
