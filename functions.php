<?php
// Constants
define( 'GB_NONCE', '8dnnjndds_dn38ndjns009wsP' );


// Composer autoloading
require __DIR__ . '/vendor/autoload.php';

/**
 * Starts a PHP session
 */
function gb_start_session() {   
   if ( ! headers_sent() && '' == session_id() ) session_start();
}
add_action( 'init', 'gb_start_session', 1 );

/**
* Autoloads classes
*/
spl_autoload_register( function( $class ) {

  $file = get_template_directory() . '/class/' . str_replace('\\', '/', $class ) . '.php';

  // Check if file exists, if true then require
  if ( file_exists( $file ) )
     require_once $file;
});

add_theme_support( 'post-thumbnails' );

/**
 * Loads all the files from the inc directory
 */
$files = glob( TEMPLATEPATH . '/inc/*.php' );
foreach ( $files as $file ) {
   require_once $file;
}

$offline_conversion_tracking = new Offline_Conversion_Tracking\Core;

function gb_test_offline_conversions() {
   if ( ! isset( $_GET['test_offline_conversions'] ) ) return;
   echo 'Started..' . PHP_EOL;
   $data_pusher = new Offline_Conversion_Tracking\Data_Pusher;
   $data_pusher->upload_offline_conversions();
}
add_action('init', 'gb_test_offline_conversions');

/**
 * Remove breadcrumbs from yoast schema
 */
function gb_remove_breadcrumbs_from_schema( $pieces, $context ) {
	return \array_filter( $pieces, function( $piece ) {
    	return ! $piece instanceof \Yoast\WP\SEO\Generators\Schema\Breadcrumb;
	});
}
add_filter( 'wpseo_schema_graph_pieces', 'gb_remove_breadcrumbs_from_schema', 11, 2 );


/**
 * Modify the schema markup for WebPage.
 */
function custom_wpseo_schema_webpage( $data ) {
   // Add @type to breadcrumb.
   $data['breadcrumb']['@type'] = 'BreadcrumbList';

   // Get the current URL path.
   $current_url = wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH );

   // Split the URL path into segments.
   $url_segments = explode( '/', trim( $current_url, '/' ) );

   // Initialize the breadcrumb items array.
   $breadcrumb_items = array();

   // Add Home as the first breadcrumb item.
   $breadcrumb_items[] = array(
       '@type' => 'ListItem',
       'position' => 1,
       'name' => 'Home',
       'item' => get_home_url(),
   );

   // Construct breadcrumb items dynamically based on URL segments.
   $url = get_home_url();
   $position = 1;
   foreach ( $url_segments as $segment ) {
       $url .= '/' . $segment;
       $position++;

       // Get the title for the current URL segment.
       $title = '';
       if ( $segment !== '' ) { // Exclude empty segments.
           $page = get_page_by_path( $segment );
           if ( $page ) {
               $title = $page->post_title;
           }
       }

       // Add the current URL segment as a breadcrumb item.
       $breadcrumb_items[] = array(
           '@type' => 'ListItem',
           'position' => $position,
           'name' => $title,
           'item' => $url,
       );
   }

   // Add breadcrumb list items to the schema.
   $data['breadcrumb']['itemListElement'] = $breadcrumb_items;

   return $data;
}
add_filter( 'wpseo_schema_webpage', 'custom_wpseo_schema_webpage' );
