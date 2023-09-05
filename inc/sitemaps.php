<?php
/**
 * Exclude sitemaps
 */
function sitemap_exclude_post_type( $value, $post_type ) {
  if ( $post_type == 'product' ) return true;
}
add_filter( 'wpseo_sitemap_exclude_post_type', 'sitemap_exclude_post_type', 10, 2 );

/**
 * Change products sitemap
 */
function gb_change_products_sitemap() {
  global $wpseo_sitemaps;
  if ( empty( $wpseo_sitemaps ) ) return;
  $wpseo_sitemaps->register_sitemap( 'products', 'create_product_sitemap' );
}
add_action( 'init', 'gb_change_products_sitemap', 99 );

/**
 * Create products sitemap
 */
function create_product_sitemap() {

  global $wpseo_sitemaps;

  $products_query = new WP_Term_Query([
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
  ]);
  if ( empty( $products_query->terms ) ) return;
  $sitemap = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

  foreach ( $products_query->terms as $term ) {

    if ( get_field( 'hide_on_archive', 'term_' . $term->term_id ) ) 
      continue;

    $url = get_term_link( $term );
    $lastmod = get_term_meta( $term->term_id, 'last_modified_date', true ) ?? time();
    $lastmod = date( 'Y-m-d H:i', $lastmod ) . ' +00:00';

    $sitemap .= '
      <url>
        <loc>' . $url . '</loc>
        <lastmod></lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
      </url>';
  }
  $sitemap .= '</urlset>';
  $wpseo_sitemaps->set_sitemap( $sitemap );
}

/**
 * Create external sitemap
 */
function gb_enable_custom_sitemap() {
  global $wpseo_sitemaps;
  if ( isset( $wpseo_sitemaps ) && ! empty ( $wpseo_sitemaps ) ) {
    $wpseo_sitemaps->register_sitemap( 'external', 'create_external_sitemap' );
  }
}
add_action( 'init', 'gb_enable_custom_sitemap' );

/**
 * Create products sitemap
 */
function gb_add_sitemap_custom_items( $sitemap_custom_items ) {
   $sitemap_custom_items .= '
      <sitemap>
        <loc>' . site_url( 'products-sitemap.xml' ) . '</loc>
        <lastmod></lastmod>
    </sitemap>
   ';
   return $sitemap_custom_items;
}
add_filter( 'wpseo_sitemap_index', 'gb_add_sitemap_custom_items' );
