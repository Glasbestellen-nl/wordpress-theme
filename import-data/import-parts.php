<?php
$parse_uri = explode( 'wp-content', $_SERVER['PWD'] );
require_once( $parse_uri[0] . 'wp-load.php');

$json = file_get_contents( get_template_directory() . '/import-data/parts.json' );
$posts = json_decode( $json, true );

if ( ! empty( $posts ) ) {

   foreach ( $posts as $post ) {

      $onderdeel = get_page_by_title( $post['post_title'], OBJECT, 'onderdeel' );

      $postarr = [
         'ID' => $onderdeel->ID,
         'post_excerpt' => $post['post_excerpt']
      ];
      wp_update_post( $postarr );

   }

}
