<?php
/**
 * Registers admin menu pages
 */
function gb_admin_menu() {
	add_menu_page( __( 'Theme settings', 'glasbestellen' ), __( 'Theme settings', 'glasbestellen' ), 'edit_theme_options', 'theme-settings-page', 'gb_theme_settings_page', 'dashicons-feedback' );
}
add_action( 'admin_menu', 'gb_admin_menu' );

/**
 * Admin theme settings page
 */
function gb_theme_settings_page() {
	?>

   <div class="wrap">

      <h2><?php _e( 'Theme settings', 'glasbestellen' ); ?></h2>

      <?php settings_errors(); ?>

      <form method="post" action="options.php">
         <?php
			settings_fields( 'theme-settings' );
         do_settings_sections( 'theme-settings-page' );
         submit_button();
			?>
      </form>

   </div>

	<?php
}

/**
 * Inititalize theme sections and options
 */
function gb_init_theme_options() {

   $page = 'theme-settings-page';

   /**
    * Company settings sections and fields
    */
   $section = 'company_settings_section';

   // Add company settings section
   add_settings_section( $section, __( 'Bedrijfsgegevens', 'glasbestellen' ), 'gb_display_company_settings_section', $page );

   // Add and register company street setting
   $id = 'company_street';
   add_settings_field( $id, __( 'Straat', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
   register_setting( 'theme-settings', $id );

   // Add and register company number setting
   $id = 'company_number';
   add_settings_field( 'company_number', __( 'Nummer', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
   register_setting( 'theme-settings', $id );

   // Add and register company zipcode setting
   $id = 'company_zipcode';
   add_settings_field( $id, __( 'Postcode', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
   register_setting( 'theme-settings', $id );

   // Add and register company city setting
   $id = 'company_city';
   add_settings_field( $id, __( 'Stad', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
   register_setting( 'theme-settings', $id );

   // Add and register company phone number setting
   $id = 'company_phone_number';
   add_settings_field( $id, __( 'Telefoonnummer', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
   register_setting( 'theme-settings', $id );

   // Add and register company email setting
   $id = 'company_email';
   add_settings_field( $id, __( 'E-mail', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
   register_setting( 'theme-settings', $id );

	// Add and register facebook url setting
	$id = 'company_facebook_url';
	add_settings_field( $id, __( 'Facebook URL', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id, 'large_field' => true ) );
	register_setting( 'theme-settings', $id );

	// Add and register twitter url setting
	$id = 'company_twitter_url';
	add_settings_field( $id, __( 'Twitter URL', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id, 'large_field' => true ) );
	register_setting( 'theme-settings', $id );

	// Add and register pinterest url setting
	$id = 'company_pinterest_url';
	add_settings_field( $id, __( 'Pinterest URL', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id, 'large_field' => true ) );
	register_setting( 'theme-settings', $id );

	// Add and register instagram url setting
	$id = 'company_instagram_url';
	add_settings_field( $id, __( 'Instagram URL', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id, 'large_field' => true ) );
	register_setting( 'theme-settings', $id );

	/**
	 * Page settings
	 */
	$section = 'page_settings_section';

	// Add redirect settings section
	add_settings_section( $section, __( 'Pages', 'glasbestellen' ), 'gb_display_page_settings_section', $page );

	// Add and register review page redirect setting
	$id = 'page_lead_success';
	add_settings_field( $id, __( 'Lead success', 'glasbestellen' ), 'gb_settings_select_pages', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
	register_setting( 'theme-settings', $id );

	// Add and register review page redirect setting
	$id = 'page_review_success';
	add_settings_field( $id, __( 'Review success', 'glasbestellen' ), 'gb_settings_select_pages', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
	register_setting( 'theme-settings', $id );

	/**
	 * Tracking settings
	 */
	$section = 'tracking_settings_section';

	// Add tracking settings section
	add_settings_section( $section, __( 'Tracking', 'glasbestellen' ), 'gb_display_tracking_settings_section', $page );

	// Add google analytics tracking id setting
	$id = 'ga_tracking_id';
	add_settings_field( $id, __( 'Google Analytics Tracking ID', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
	register_setting( 'theme-settings', $id );

	// Add google tag manager container id setting
	$id = 'gtm_container_id';
	add_settings_field( $id, __( 'GTM Container ID', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
	register_setting( 'theme-settings', $id );

	/**
	 * Payment settings
	 */
	$section = 'payment_settings_section';

	// Add redirect settings section
	add_settings_section( $section, __( 'Payment', 'glasbestellen' ), 'gb_display_payment_settings_section', $page );

	// Add payment webhook url setting
	$id = 'payment_webhook_url';
	add_settings_field( $id, __( 'Custom webhook URL', 'glasbestellen' ), 'gb_settings_text_field', $page, $section, array( 'id' => $id, 'label_for' => $id, 'large_field' => true ) );
	register_setting( 'theme-settings', $id );

	// Add payment redirect setting
	$id = 'payment_redirect_url';
	add_settings_field( $id, __( 'Payment redirect URL', 'glasbestellen' ), 'gb_settings_select_pages', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
	register_setting( 'theme-settings', $id );

	$id = 'conversion_selectable_products';
	add_settings_field( $id, __( 'Kiesbare producten', 'glasbestellen' ), 'gb_settings_comma_textarea', $page, $section, array( 'id' => $id, 'label_for' => $id ) );
	register_setting( 'theme-settings', $id );


}
add_action( 'admin_init', 'gb_init_theme_options' );

/**
 * Displays the desired company settings section content
 */
function gb_display_company_settings_section() {
	echo '<p>' . __( 'Stel hieronder de bedrijfsgegevens in', 'glasbestellen' ) . '.</p>';
}

/**
 * Displays the desired page settings section content
 */
function gb_display_page_settings_section() {
	echo '<p>' . __( 'Stel hieronder specifieke pagina\'s in', 'glasbestellen' ) . '.</p>';
}

/**
 * Displays the desired company settings section content
 */
function gb_display_tracking_settings_section() {
	echo '<p>' . __( 'Stel hieronder tracking gegevens in', 'glasbestellen' ) . '.</p>';
}

/**
 * Displays the desired company settings section content
 */
function gb_display_payment_settings_section() {
	echo '<p>' . __( 'Stel hieronder betaalgegevens in', 'glasbestellen' ) . '.</p>';
}



/**
 * Renders settings text field
 */
function gb_settings_text_field( $args ) {

	if ( isset( $args['id'] ) ) {

		// Get option
		$option = get_option( $args['id'] );

		// Add class for larger field
		$classes = array();
		if ( isset( $args['large_field'] ) && true == $args['large_field'] ) {
			$classes[] = 'regular-text';
		}

		$html = '';

		// Render text field
		$html .= '<input type="text" name="' . $args['id'] . '" id="' . $args['id'] . '" class="' . implode( ' ', $classes ) . '" value="' . $option . '">';

		// Add description
		if ( isset( $args['description'] ) ) {
			$html .= '<p class="description">' . $args['description'] . '</p>';
		}

		echo $html;

	}
}

/**
 * Renders settings select box with pages
 */
function gb_settings_select_pages( $args ) {

	if ( isset( $args['id'] ) ) {

		// Get option
		$option 	= get_option( $args['id'] );

		// Get pages
		$pages 	= get_posts(
			array(
				'post_type' 		=> 'page',
				'posts_per_page' 	=> -1
			)
		);

		// Render select box with page options
		$html  = '<select name="' . $args['id'] . '" id="' . $args['id'] . '">';
		$html .= '<option value="">-- ' . __( 'Selecteer pagina', 'glasbestellen' ) . ' --</option>';
		foreach( $pages as $page ) {
			$html .= '<option value="' . $page->ID . '" ' . selected( $page->ID, $option, false ) . '>' . $page->post_title . '</option>';
		}
		$html .= '</select>';

		echo $html;

	}

}

function gb_settings_comma_textarea( $args ) {

	$value = get_option( $args['id'] ); ?>

	<textarea class="regular-text" name="<?php echo $args['id']; ?>" rows="8"><?php echo $value; ?></textarea>
	<p class="description"><?php _e( 'Scheidt producten met komma.', 'glasbestellen' ); ?><p>

	<?php
}
