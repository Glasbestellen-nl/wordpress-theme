<?php
/**
 * Rewrites product url so that a next level configurator is possible
 */
function gb_add_configurable_product_rewrite_rules() {
   add_rewrite_rule( '^' . _x( 'producten', 'Product slug', 'glasbestellen' ) . '/([^/]*)/([^/]*)/?$', 'index.php?post_type=configurator&name=$matches[2]', 'top' );
}
add_action( 'init', 'gb_add_configurable_product_rewrite_rules', 10, 0 );

/**
 * Replaces tag in configurator with (parent) product
 */
function gb_filter_configurator_post_link( $permalink, $post ) {

   if ( ( 'configurator' !== $post->post_type ) || ( false === strpos( $permalink, '%product%' ) ) )
      return $permalink;

   $term_id = get_first_term_by_id( $post->ID, 'startopstelling' );

   if ( empty( $term_id ) ) return $permalink;

   $products = get_posts([
      'post_type'    => 'product',
      'meta_key'     => 'configurator',
      'meta_value'   => $term_id
   ]);

   if ( ! empty( $products[0] ) )
      $permalink = str_replace( '%product%', $products[0]->post_name, $permalink );

   return $permalink;
}
add_filter( 'post_type_link', 'gb_filter_configurator_post_link', 10, 2 );

/**
 * Returns child configurators of product
 *
 * @param int product_id the parent product id
 */
function gb_get_configurators_by_id( int $product_id ) {

   if ( empty( $product_id ) ) return;

   $args = [
      'post_type' => 'configurator',
      'post_per_page' => -1,
      'meta_query' => [
         [
            'key' => 'product',
            'value' => $product_id
         ]
      ]
   ];
   return new WP_Query( $args );
}

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
