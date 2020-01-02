<?php
/**
 * Get page ID by template
 */
function get_page_id_by_template( $template = '' ) {

	if ( isset( $template ) ) {

		// Set arguments
		$args = [
			'post_type' => 'page',
			'fields' => 'ids',
			'nopaging' => true,
			'meta_key' => '_wp_page_template',
			'meta_value' => $template
		];

		// Get pages
		$pages = get_posts( $args );

		// Return first page
		return ! empty( $pages[0] ) ? $pages[0] : false;

	}
}

/*
 * Returns path to lead attachments directory
 */
function gb_get_lead_attachments_dir() {
	$upload_dir = wp_get_upload_dir();
	$attachments_dirname = $upload_dir['basedir'] . '/lead-attachments';
	return $attachments_dirname;
}

/*
 * Return url to lead attachments directory
 */
function gb_get_lead_attachments_uri() {
	$upload_dir = wp_get_upload_dir();
	$attachments_dirname = $upload_dir['baseurl'] . '/lead-attachments';
	return $attachments_dirname;
}

/*
 * Deletes directories recursively
 */
function gb_delete_files( $target ) {

	if ( is_dir( $target ) ) {

		$files = glob( $target . '*', GLOB_MARK );

		foreach( $files as $file ){
			gb_delete_files( $file );
		}
		rmdir( $target );

	} elseif( is_file($target ) ) {
		unlink( $target );
	}
}

/*
 * Returns cover image url by post id
 */
function gb_get_cover_image_url( $post_id ) {
	if ( $cover_image = get_field( 'cover_image', $post_id ) ) {
		return $cover_image;
	}
	return get_template_directory_uri() . '/assets/images/default-banner.jpg';
}
