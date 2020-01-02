<?php
$parse_uri = explode( 'wp-content', $_SERVER['PWD'] );
require_once( $parse_uri[0] . 'wp-load.php');

$json = file_get_contents( get_template_directory() . '/import-data/articles.json' );
$posts = json_decode( $json, true );

if ( ! empty( $posts ) ) {

   foreach ( $posts as $post ) {

      $post_args = [
         'post_title' => $post['post_title'],
         'post_content' => $post['post_content'],
         'post_status' => 'publish',
         'post_date' => $post['post_date'],
         'post_name' => $post['post_name'],
         'post_excerpt' => $post['post_excerpt'],
         'post_type' => 'artikel'
      ];
      $post_id = wp_insert_post( $post_args );

      if ( ! empty( $post['post_terms'] ) ) {
         foreach ( $post['post_terms'] as $term ) {
            wp_set_object_terms( $post_id, $term['name'], 'onderwerp', true );
         }
      }

   }

}
