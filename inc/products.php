<?php
/**
 * Rewrites product url so that a configurator level visitable
 */
function gb_add_configurable_product_rewrite_rules() {
   add_rewrite_rule( '^' . _x( 'producten', 'Product slug', 'glasbestellen' ) . '/([^/]*)/([^/]*)/?$', 'index.php?post_type=configurator&name=$matches[2]', 'top' );
}
add_action( 'init', 'gb_add_configurable_product_rewrite_rules', 10, 0 );

/**
 * Modifies breadcrumbs for configurator connected to product
 */
function gb_modify_configurator_breadcrumb( $links ) {

   global $post;

   // Is single onfigurator connected to product
   if ( is_singular( 'configurator' ) && gb_get_product_by_configurator_id( $post->ID ) ) {

      $product = gb_get_product_by_configurator_id( $post->ID );

      $new_links[] = $links[0]; // Home
      $new_links[] = ['ptarchive' => 'product']; // Product archive
      $new_links[] = ['id' => $product->ID]; // Product single
      $new_links[] = ['id' => $post->ID]; // Configurator single

      return $new_links;
   }
   return $links;
}
add_filter( 'wpseo_breadcrumb_links', 'gb_modify_configurator_breadcrumb' );

/**
 * Replaces tag in configurator with (parent) product
 */
function gb_filter_configurator_post_link( $permalink, $post ) {

   if ( ( 'configurator' !== $post->post_type ) || ( false === strpos( $permalink, '%product%' ) ) )
      return $permalink;

   if ( $product = gb_get_product_by_configurator_id( $post->ID ) )
      $permalink = str_replace( '%product%', $product->post_name, $permalink );

   return $permalink;
}
add_filter( 'post_type_link', 'gb_filter_configurator_post_link', 10, 2 );

/**
 * Handles submit of filters on configurator archive
 */
function gb_handle_configurator_filter_submit() {

   $empty_filters = [];
   $args = [];

   if ( ! empty( $_POST['filter'] ) ) {

      foreach ( $_POST['filter'] as $parent_filter => $child_filter ) {
         if ( ! empty( $child_filter ) )
            $args[$parent_filter] = $child_filter;
         else
            $empty_filters[] = $parent_filter;
      }
      $filter_url = add_query_arg( $args, remove_query_arg( $empty_filters ) );
      wp_redirect( $filter_url );
      exit;
   }

}
add_action( 'init', 'gb_handle_configurator_filter_submit' );

/**
 * Returns the product connected to configurator
 *
 * @param int configurator_id the configurator id
 */
function gb_get_product_by_configurator_id( int $configurator_id ) {

   if ( empty( $configurator_id ) ) return;

   $term_id = get_first_term_by_id( $configurator_id, 'startopstelling' );

   if ( empty( $term_id ) ) return;

   $products = get_posts([
      'post_type'    => 'product',
      'meta_key'     => 'configurator',
      'meta_value'   => $term_id
   ]);

   return ! empty( $products[0] ) ? $products[0] : false;
}

function gb_get_configurator_faq_page_id( int $configurator_id = 0 ) {
   $parent_product = gb_get_product_by_configurator_id( $configurator_id );
   if ( ! $parent_product ) return;
   return get_field( 'faq_post_id', $parent_product->ID );
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
      $review_category = get_field( 'review_category' );

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
