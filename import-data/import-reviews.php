<?php
$parse_uri = explode( 'wp-content', $_SERVER['PWD'] );
require_once( $parse_uri[0] . 'wp-load.php');

$json = file_get_contents( get_template_directory() . '/import-data/reviews.json' );
$reviews = json_decode( $json, true );

foreach ( $reviews as $review ) {

   $post_args = [
      'post_title' => $review['post_title'],
      'post_content' => $review['post_content'],
      'post_status' => 'publish',
      'post_date' => $review['post_date'],
      'post_type' => 'review'
   ];

   $post_id = wp_insert_post( $post_args );

   if ( ! empty( $review['post_meta'] ) ) {

      foreach ( $review['post_meta'] as $key => $value ) {
         update_post_meta( $post_id, $key, $value );
      }
   }

   if ( ! empty( $review['old_comments'] ) ) {
      update_post_meta( $post_id, 'old_comments', $review['old_comments'] );
   }

   if ( ! empty( $review['post_terms'] ) ) {
      foreach ( $review['post_terms'] as $term ) {
         wp_set_object_terms( $post_id, $term['name'], 'review-product', true );
      }
   }

}
