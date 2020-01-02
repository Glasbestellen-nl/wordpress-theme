<?php
/**
 * Pre get products hook
 */
function gb_pre_get_products( $query ) {

   $taxonomy = 'product-categorie';
   $terms = get_terms( ['taxonomy' => $taxonomy] );

   if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'product' ) ) {
      $query->set( 'posts_per_page', -1 );
      $query->set( 'orderby', 'menu_order' );
      $query->set( 'order', 'ASC' );
      $query->set( 'tax_query', [
      	[
      		'taxonomy' 	=> 'product-categorie',
      		'field'		=> 'term_id',
      		'terms'		=> wp_list_pluck( $terms, 'term_id' )
      	]
		]);
   }
   return $query;
}
add_action( 'pre_get_posts', 'gb_pre_get_products' );

/**
 * Adds schema.org json product data to head
 */
function gb_product_rich_snippets_head() {

   if ( is_singular( 'product' ) ) {

      global $post;

      $json['@context']    = 'https://schema.org/';
      $json['@type']       = 'Product';
      $json['name']        = $post->post_title;
      $json['description'] = $post->post_excerpt;
      $json['mpn']         = $post->ID;
      $json['brand']       = [
         '@type' => 'Thing',
         'name'  => get_bloginfo( 'name' )
      ];

      // Product reviews
      if ( $review_category = get_field( 'review_category' ) ) {

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
         }

         $json['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => gb_get_review_average( false, $review_category ),
            'reviewCount' => gb_get_review_count( $review_category )
         ];
      }

      // Product images
      if ( $gallery_images = get_field( 'gallery_images', $post->ID ) ) {
         foreach ( $gallery_images as $image ) {
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
