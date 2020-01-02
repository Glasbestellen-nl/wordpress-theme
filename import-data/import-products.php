<?php
$parse_uri = explode( 'wp-content', $_SERVER['PWD'] );
require_once( $parse_uri[0] . 'wp-load.php');

$json = file_get_contents( get_template_directory() . '/import-data/products.json' );
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

   foreach ( $posts as $post ) {

      $post_args = [
         'post_title' => $post['post_title'],
         'post_content' => $post['post_content'],
         'post_status' => $post['post_status'],
         'post_date' => $post['post_date'],
         'post_name' => $post['post_name'],
         'post_excerpt' => $post['post_excerpt'],
         'menu_order' => $post['menu_order'],
         'post_type' => 'product'
      ];
      $post_id = wp_insert_post( $post_args );

      foreach ( $post['post_meta'] as $key => $value ) {

         switch ( $key ) {

            case '_thumbnail_id' :

               if ( ! empty( $attachments ) ) {
                  foreach ( $attachments as $attachment ) {
                     if ( get_post_meta( $attachment->ID, 'old_id', true ) == $value ) {
                        update_post_meta( $post_id, '_thumbnail_id', $attachment->ID );
                        //delete_post_meta( $attachment->ID, 'old_id' );
                     }
                  }
               }
               break;

            case 'faq' :

               if ( ! empty( $value ) ) {
                  foreach ( $value as $item ) {
                     $row = [
                        'question' => $item['question'],
                        'answer' => $item['answer']
                     ];
                     add_row( 'faq', $row, $post_id );
                  }
               }

               break;

            case 'usps' :
               if ( ! empty( $value ) ) {
                  foreach ( $value as $item ) {
                     $row = [
                        'title' => $item['title'],
                        'description' => $item['content']
                     ];
                     add_row( 'usps', $row, $post_id );
                  }
               }
               break;

            default :
               if ( ! empty( $value ) ) {
                  update_post_meta( $post_id, $key, $value );
               }
         }

      }

      if ( ! empty( $post['post_terms'] ) ) {
         foreach ( $post['post_terms'] as $term ) {
            wp_set_object_terms( $post_id, $term['name'], 'product-categorie', true );
            if ( $pc = get_term_by( 'name', $term['name'], 'product-categorie' ) ) {
               wp_update_term( $pc->term_id, 'product-categorie', ['description' => $term['description']] );
            }
         }
      }

   }

}
