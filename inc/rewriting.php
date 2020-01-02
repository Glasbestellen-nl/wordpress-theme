<?php
/**
 * Adds 'onderwerp' term to post type url
 */
function gb_rewrite_tax_url( $url, $post ) {

	if ( strpos( $url, '%onderwerp%' ) !== false ) {

		$post = get_post( $post );
		if ( ! $post ) return $url;

		$terms = wp_get_object_terms( $post->ID, 'onderwerp' );
		if ( ! is_wp_error( $terms ) && ! empty( $terms ) && is_object( $terms[0] ) )
			$taxonomy_slug = $terms[0]->slug;

		return str_replace( '%onderwerp%', $taxonomy_slug, $url );

	}
	return $url;

}
add_filter( 'post_type_link', 'gb_rewrite_tax_url', 10, 2 );
