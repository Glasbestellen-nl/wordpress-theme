<?php
$parse_uri = explode( 'wp-content', $_SERVER['PWD'] );
require_once( $parse_uri[0] . 'wp-load.php');

$json = file_get_contents( get_template_directory() . '/import-data/inspiration.json' );
$posts = json_decode( $json, true );

if ( ! empty( $posts ) ) {

   // Get all attachments
   $attachments = get_posts([
      'post_type' => 'attachment',
      'posts_per_page' => -1,
      'meta_query' => [
         [
            'key' => 'old_id'
         ]
      ]
   ]);

   // foreach ( $attachments as $attachment ) {
   //    echo get_post_meta( $attachment->ID, 'old_id', true ) . PHP_EOL;
   // }

   foreach ( $posts as $post ) {

      $post_args = [
         'post_title' => $post['post_title'],
         'post_content' => $post['post_content'],
         'post_status' => 'publish',
         'post_date' => $post['post_date'],
         'post_type' => 'inspiratie'
      ];
      $post_id = wp_insert_post( $post_args );

      if ( ! empty( $post['post_meta']['_thumbnail_id'] ) ) {
         $old_thumb_id = $post['post_meta']['_thumbnail_id'];

         if ( ! empty( $attachments ) ) {
            foreach ( $attachments as $attachment ) {
               if ( get_post_meta( $attachment->ID, 'old_id', true ) == $old_thumb_id ) {
                  update_post_meta( $post_id, '_thumbnail_id', $attachment->ID );
                  delete_post_meta( $attachment->ID, 'old_id' );
               }
            }
         }
      }

      if ( ! empty( $post['post_terms'] ) ) {
         foreach ( $post['post_terms'] as $term ) {
            wp_set_object_terms( $post_id, $term['name'], 'inspiratie-categorie', true );
         }
      }

   }

}
