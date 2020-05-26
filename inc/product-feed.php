<?php
use Vitalybaev\GoogleMerchant\Feed;
use Vitalybaev\GoogleMerchant\Product;
use Vitalybaev\GoogleMerchant\Product\Shipping;
use Vitalybaev\GoogleMerchant\Product\Availability\Availability;

/**
 * Adds product feed rewrite rules
 */
function gb_add_product_feed_rewrite_rules() {
   $product_slug = _x( 'producten', 'Product slug', 'glasbestellen' );
   add_rewrite_rule( '^' . $product_slug . '/([^/]*)/feed.xml/?$', 'index.php?post_type=configurator&feed_product=$matches[1]', 'top' );
}
add_action( 'init', 'gb_add_product_feed_rewrite_rules', 10, 0 );

/**
 * Adds product feed query vars
 */
function gb_add_product_feed_query_vars( $query_vars ) {
   $query_vars[] = 'feed_product';
   return $query_vars;
}
add_action( 'query_vars', 'gb_add_product_feed_query_vars' );

/**
 * Renders product xml feed
 */
function gb_product_feed_template_include( $template ) {

   if ( ! get_query_var( 'feed_product' ) )
      return $template;

   header( 'Content-Type: application/xml; charset=utf-8' );

   $product_slug = get_query_var( 'feed_product' );
   $product = get_page_by_path( $product_slug, OBJECT, 'product' );

   if ( ! $product ) return;
   $archive = new Configurator\Archive( $product->ID );

   $items = $archive->get_items_query_object();
   if ( $items->have_posts() ) {

      $company_name = get_bloginfo( 'title' );
      $feed = new Feed( $company_name, home_url(), get_bloginfo( 'description' ) );

      while ( $items->have_posts() ) {
         $items->the_post();
         $configurator = gb_get_configurator( get_the_id() );

         $item = new Product();
         $item->setId( get_the_id() );
         $item->setTitle( get_the_title() );
         $item->setDescription( get_the_excerpt() );
         $item->setLink( get_permalink() );
         $item->setImage( get_the_post_thumbnail_url() );
         $item->setAvailability( 'in stock' );
         $item->setPrice( Money::format( Money::including_vat( $configurator->get_total_price( true, true ) ) ) . ' EUR' );
         $item->setGoogleCategory( 'Hardware > Building Materials > Glass' );
         $item->setBrand( $company_name );

         $feed->addProduct( $item );
      }

      $feed_xml = $feed->build();
      echo $feed_xml;
   }

}
add_action( 'template_include', 'gb_product_feed_template_include' );
