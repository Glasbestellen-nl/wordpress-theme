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

function gb_get_product_id_by_string( string $string ) {

	if ( empty( $string ) ) return;

	if ( $post = get_page_by_title( $string, OBJECT, 'product' ) ) {
		return $post->ID;
	}

	return false;
}

/**
 * Get first term by post id
 */
function get_first_term_by_id( $post_id, $taxonomy, $output = 'term_id' ) {
   if ( empty( $post_id ) || empty( $taxonomy ) ) return;

   $terms = get_the_terms( $post_id, $taxonomy );

   if ( empty( $terms ) ) return;

   $term = array_shift( $terms );
   return $term->$output;
}

/**
 * Returns list of selectable products to select
 * in offline conversion tracking
 */
function gb_get_selectable_products() {
	if ( $option = get_option( 'conversion_selectable_products' ) ) {
		$products_names = explode( ',', $option );
		$products_names = array_map( 'trim', $products_names );
		rsort( $products_names );
		return $products_names;
	}
	return false;
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

/**
 * Searches for a matching product with given string
 * Returns product object
 */
function gb_find_product_by_string( string $string ) {
	$products = get_posts( 'post_type=product&posts_per_page=-1' );
	if ( ! $products ) return;
	$match = false;
	foreach ( $products as $product ) {
		if ( preg_match( '/' . $product->post_title . '/i', $string, $matched ) )
			$match = $product;
	}
	return $match;
}
