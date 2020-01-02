<?php
$parse_uri = explode( 'wp-content', $_SERVER['PWD'] );
require_once( $parse_uri[0] . 'wp-load.php');
require_once( $parse_uri[0] . 'wp-admin/includes/admin.php' );

$json = file_get_contents( get_template_directory() . '/import-data/part-thumbnails.json' );
$attachments = json_decode( $json, true );

$site_url = 'http://glasbestellen.nl/wp-content/uploads/';

foreach ( $attachments as $attachment ) {

   // Download file
   $url = $site_url . $attachment['path'];

   $filename = basename( $url );

   $upload_dir = wp_upload_dir( $attachment['time'] );
   $destination = $upload_dir['path'] . '/' . $filename;
   copy( $url, $destination );

   $args = [
      'post_title' => $attachment['title'],
      'post_mime_type' => mime_content_type( $destination ),
      'post_content' => isset( $attachment['description'] ) ? $attachment['description'] : '',
      'post_date' => date( "Y-m-d H:i:s", strtotime( str_replace( '/', '-', $attachment['time'] ) ) )
   ];
   $attachment_id = wp_insert_attachment( $args, $destination );
   $attach_data = wp_generate_attachment_metadata( $attachment_id, $destination );
   wp_update_attachment_metadata( $attachment_id, $attach_data );

   update_post_meta( $attachment_id, 'old_id', $attachment['id'] );

   echo $destination . PHP_EOL;

}
