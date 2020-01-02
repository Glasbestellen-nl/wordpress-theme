<?php
$parse_uri = explode( 'wp-content', $_SERVER['PWD'] );
require_once( $parse_uri[0] . 'wp-load.php');
require_once( $parse_uri[0] . 'wp-admin/includes/admin.php' );

$json = file_get_contents( get_template_directory() . '/import-data/images.json' );
$images = json_decode( $json, true );

if ( ! empty( $images ) ) {

   foreach ( $images as $image ) {

      $url = $image['src'];

      // Retrieve date directory path from url
      $components = explode( '/', $url );
      $time = implode( '/', array_slice( $components, -3, 2 ) );

      // Get file name
      $filename = basename( $url );

      // Create destination path
      $upload_dir = wp_upload_dir( $time );
      $destination = $upload_dir['path'] . '/' . $filename;

      // Check whether file already exists
      if ( ! file_exists( $destination ) ) {

         // Copy file from external url to destination on server
         copy( $url, $destination );

         // Insert attachment
         $args = [
            'post_title' => $image['title'],
            'post_mime_type' => mime_content_type( $destination ),
            'post_date' => date( "Y-m-d H:i:s", strtotime( str_replace( '/', '-', $time ) ) )
         ];
         $attachment_id = wp_insert_attachment( $args, $destination );

         // Add attachment metadata
         $attach_data = wp_generate_attachment_metadata( $attachment_id, $destination );
         wp_update_attachment_metadata( $attachment_id, $attach_data );

         if ( ! empty( $image['alt'] ) ) {
            update_post_meta( $attachment_id, '_wp_attachment_image_alt', $image['alt'] );
         }
         echo $destination . PHP_EOL;
      }
   }
}
