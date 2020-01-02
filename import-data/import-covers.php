<?php
$parse_uri = explode( 'wp-content', $_SERVER['PWD'] );
require_once( $parse_uri[0] . 'wp-load.php');
require_once( $parse_uri[0] . 'wp-admin/includes/admin.php' );

$json = file_get_contents( get_template_directory() . '/import-data/banners.json' );
$covers = json_decode( $json, true );

foreach ( $covers as $cover ) {

   $filename = basename( $cover['attachment_url'] );

   $upload_dir = wp_upload_dir( $cover['time'] );
   $destination = $upload_dir['path'] . '/' . $filename;

   if ( ! file_exists( $destination ) ) {

      echo 'New!' . PHP_EOL;

      copy( $cover['attachment_url'], $destination );

      $args = [
         'post_title' => $cover['title'],
         'post_mime_type' => mime_content_type( $destination ),
         'post_content' => isset( $cover['description'] ) ? $cover['description'] : '',
         'post_date' => date( "Y-m-d H:i:s", strtotime( str_replace( '/', '-', $cover['time'] ) ) )
      ];
      $attachment_id = wp_insert_attachment( $args, $destination );
      $attach_data = wp_generate_attachment_metadata( $attachment_id, $destination );
      wp_update_attachment_metadata( $attachment_id, $attach_data );

   } else {
      echo 'Exist!' . PHP_EOL;
      $attachment_id = attachment_url_to_postid( str_replace( '/Users/robbertvermeulen/Sites/glasbestellen4/wp-content/uploads/', '', $destination ) );
   }

   $products = get_posts( 'post_type=product&posts_per_page=-1' );

   foreach ( $products as $product ) {
      if ( $cover['post_name'] == $product->post_name ) {
         update_field( 'cover_image', $attachment_id, $product->ID );
      }
   }

   echo $destination . PHP_EOL;

}
