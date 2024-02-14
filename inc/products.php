<?php
/**
 * Adds schema.org json product data to head
 */
function gb_product_rich_snippets_head() {

   if ( is_tax( 'product_cat' ) ) {

      $queried_object_id = get_queried_object_id();
    
      $json['@context']    = 'https://schema.org/';
      $json['@type']       = 'Product';
      $json['name']        = single_term_title( null, false );
      $json['description'] = get_field( 'excerpt', 'term_' . $queried_object_id );
      $json['mpn']         = $queried_object_id;
      $json['brand']       = [
         '@type' => 'Thing',
         'name'  => get_bloginfo( 'name' )
      ];

      // Product reviews
      $review_category = get_field( 'review_category', 'term_' . $queried_object_id );

      if ( $reviews = gb_get_reviews( $number = -1, $review_category ) ) {

         foreach ( $reviews as $review ) {

            $json['review'][] = [
               '@type' => 'Review',
               'reviewRating' => [
                  '@type' => 'Rating',
                  'ratingValue' => get_post_meta( $review->ID, 'rating', true ),
                  'bestRating' => 5,
               ],
               'author' => [
                  '@type' => 'Person',
                  'name' => get_post_meta( $review->ID, 'name', true )
               ]
            ];
         }

         $json['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => gb_get_review_average( false, $review_category ),
            'reviewCount' => gb_get_review_count( $review_category )
         ];
      }

      // Product images
      if ( $gallery_images = get_field( 'gallery_images', 'term_' . $queried_object_id ) ) {
         foreach ( $gallery_images as $image ) {
            if (!empty($image['url']))
               $json['image'][] = $image['url'];
         }
      }

      $output  = '<script type="application/ld+json">';
      $output .= json_encode( $json, JSON_UNESCAPED_SLASHES );
      $output .= '</script>';

      echo $output;
   }

}
add_action( 'wp_head', 'gb_product_rich_snippets_head' );