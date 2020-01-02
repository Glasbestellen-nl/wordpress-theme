<?php
// Constants
define( 'GB_NONCE', '8dnnjndds_dn38ndjns009wsP' );

/**
 * Starts a PHP session
 */
function gb_start_session() {
	if ( ! session_id() )
	   session_start();
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
