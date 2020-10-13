<?php
/**
 * Registers admin menu pages
 */
function gb_crm_admin_menu() {
	add_menu_page( __( 'Leads', 'glasbestellen' ), __( 'Leads', 'glasbestellen' ), 'edit_theme_options', 'crm', 'gb_crm_admin_page', 'dashicons-email-alt', 1 );
}
add_action( 'admin_menu', 'gb_crm_admin_menu' );

/**
 * Admin lead pages
 */
function gb_crm_admin_page() {

   if ( ! empty( $_GET['lead_id'] ) ) {
		$lead = CRM::get_lead( $_GET['lead_id'] );
		$relation = $lead->get_relation();
		include( locate_template( 'template-parts/admin/lead-single.php' ) );
   } else {
      get_template_part( 'template-parts/admin/lead-archive' );
   }
}

/**
 * Updates lead
 */
function gb_update_lead() {

	if ( ! empty( $_POST['lead_id'] ) ) {

		if ( ! empty( $_POST['lead_status'] ) ) {
			CRM::update_lead_status( $_POST['lead_id'], $_POST['lead_status'] );
		}

		if ( ! empty( $_POST['lead_owner'] ) ) {
			CRM::update_lead_owner( $_POST['lead_id'], $_POST['lead_owner'] );
		}

		if ( ! empty( $_POST['lead_note'] ) ) {
			CRM::update_lead_meta( $_POST['lead_id'], 'lead_note', trim( $_POST['lead_note'] ) );
		}

	}
	wp_die();
}
add_action( 'wp_ajax_update_lead', 'gb_update_lead' );

/**
 * Deletes lead on ajax call
 */
function gb_delete_lead() {

	if ( ! empty( $_POST['lead_id'] ) ) {
		CRM::delete_lead( $_POST['lead_id'] );
	}

	// Redirect url
	echo admin_url( 'admin.php?page=crm' );

	wp_die();

}
add_action( 'wp_ajax_delete_lead', 'gb_delete_lead' );

/**
 * Deletes multiple leads at once
 */
function gb_delete_leads() {

	if ( ! empty( $_POST['lead'] ) ) {

		foreach ( $_POST['lead'] as $lead_id => $checked ) {
			CRM::delete_lead( $lead_id );
		}

		// Redirect url
		wp_redirect( admin_url( 'admin.php?page=crm' ) );
		exit;

	}

}
add_action( 'admin_post_delete', 'gb_delete_leads' );

/**
 * Deletes lead by get action parameter
 */
function gb_handle_action_delete() {

	if ( ! empty( $_GET['lead_id'] ) && ! empty( $_GET['action'] ) ) {

		if ( $_GET['action'] == 'delete' ) {

			CRM::delete_lead( $_GET['lead_id'] );

			// Redirect url
			wp_redirect( admin_url( 'admin.php?page=crm' ) );
			exit;
		}
	}

}
add_action( 'admin_init', 'gb_handle_action_delete' );

/**
 * Deletes leads owned by relation
 */
function gb_delete_relation( $user_id ) {

	if ( $leads = CRM::get_leads( "WHERE lead_relation = $user_id" ) ) {
		foreach ( $leads as $lead ) {
			CRM::delete_lead( $lead->get_id() );
		}
	}

}
add_action( 'delete_user', 'gb_delete_relation' );

/**
 * Handles ajax request to update current lead editor
 */
function gb_ajax_update_lead_current_editor() {

	$response = [
		'other_editor' => false
	];

	if ( ! empty( $_POST['lead_id'] ) ) {

		$lead_id = $_POST['lead_id'];
		$current_user_id = get_current_user_id();
		$crm = new CRM();

		$current_editor = $crm->get_lead_meta( $lead_id, 'current_editor', true );

		if ( $current_editor ) {
			if ( $current_editor != $current_user_id ) {
				$response['other_editor'] = true;
				$response['message'] = __( 'Iemand anders is deze lead aan het bewerken.' );
			}
		} else {
			$crm->update_lead_meta( $lead_id, 'current_editor', $current_user_id );
		}
	}

	wp_send_json( $response );
	wp_die();
}
add_action( 'wp_ajax_update_lead_current_editor', 'gb_ajax_update_lead_current_editor' );

/**
 * Handles ajax request to unset current lead editor
 */
function gb_ajax_unset_lead_current_editor() {

	$response = [];

	if ( ! empty( $_POST['lead_id'] ) ) {

		$lead_id = $_POST['lead_id'];
		$current_user_id = get_current_user_id();
		$crm = new CRM();

		$current_editor = $crm->get_lead_meta( $lead_id, 'current_editor', true );

		if ( $current_editor ) {
			if ( $current_editor == $current_user_id ) {
				$crm->delete_lead_meta( $lead_id, 'current_editor' );
			}
		}
	}
	wp_send_json( $response );
	wp_die();
}
add_action( 'wp_ajax_unset_lead_current_editor', 'gb_ajax_unset_lead_current_editor' );

/**
 * Handles ajax request check which leads are currently edited 
 */
function gb_ajax_check_leads_current_editor() {

	$edited_leads = [];

	if ( ! empty( $_GET['lead_ids'] ) ) {
		$crm = new CRM();

		foreach ( $_GET['lead_ids'] as $lead_id ) {
			$edited_leads[$lead_id] = $crm->get_lead_meta( $lead_id, 'current_editor', true );
		}
		wp_send_json( $edited_leads );
	}
	wp_die();
}
add_action( 'wp_ajax_check_leads_current_editor', 'gb_ajax_check_leads_current_editor' );
