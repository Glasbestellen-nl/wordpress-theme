<?php
/**
 * Pre get reviews hook
 */
function gb_pre_get_reviews( $query ) {

   if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'review' ) ) {
      $query->set( 'posts_per_page', -1 );
   }
   return $query;
}
add_action( 'pre_get_posts', 'gb_pre_get_reviews' );

/**
 * Returns avarage review rating
 *
 * @param bool $double return avarage as out of 5 or 10
 */
function gb_get_review_average( $double = false, $category = null ) {

   $total = 0;
   $reviews = gb_get_reviews( -1, $category );

   if ( ! empty( $reviews ) ) {
      foreach ( $reviews as $review ) {
         if ( $rating = get_field( 'rating', $review->ID ) ) {
            $total += $rating;
         }
      }
      $avarage = $total / count( $reviews );
      $avarage = ( $double ) ? $avarage * 2 : $avarage;
      return round( $avarage, 1 );
   }

   return 5;
}

function gb_get_review_count( $category = null ) {

   if ( $reviews = gb_get_reviews( -1, $category ) ) {
      return count( $reviews );
   }
   return 0;

}

/*
 * Returns reviews
 */
function gb_get_reviews( $number = -1, $category = null ) {
	$args = [
		'post_type' => 'review',
		'posts_per_page' => $number
	];
	if ( isset( $category ) ) {
		$args['tax_query'] = [
			[
				'taxonomy' => 'review-product',
				'terms' => $category,
				'field' => 'term_id'
			]
		];
	}
	return get_posts( $args );
}
