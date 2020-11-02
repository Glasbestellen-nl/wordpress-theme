<?php
/**
 * Inserts contact box between the content
 */
function gtp_insert_action_boxes( $content ) {

	global $post;

   ob_start();
   get_template_part( 'template-parts/contact-box' );
   $insertation = ob_get_contents();
   ob_end_clean();

	if ( is_singular( 'artikel' ) && ! is_admin() && ! get_post_meta( $post->ID, 'hide_contact_box', true ) ) {
		return gb_insert_after_paragraph( $insertation, 2, $content, 6 );
	}

	return $content;

}
add_filter( 'the_content', 'gtp_insert_action_boxes' );

/**
 * Inserts content after paragraph
 */
function gb_insert_after_paragraph( $insertation, $paragraph_id, $content, $min_paragraphs = null ) {

	$closing_p = '</p>';
	$paragraphs = explode( $closing_p, $content );

	foreach( $paragraphs as $index => $paragraph ) {

		if ( trim( $paragraph ) ) {
			$paragraphs[$index] .= $closing_p;
		}

		if ( $paragraph_id == $index + 1 ) {

			if ( isset( $min_paragraphs ) ) {
				if ( $min_paragraphs <= count( $paragraphs ) )
					$paragraphs[$index] .= $insertation;

			} else {
				$paragraphs[$index] .= $insertation;
			}
		}
	}
	return implode( '', $paragraphs );
}