<?php
/**
 * Pre get inspiration hook
 */
function gb_pre_get_inspiration( $query ) {

   if ( ! is_admin() && $query->is_main_query() && is_post_type_archive( 'inspiratie' ) ) {
      $query->set( 'posts_per_page', 20 );
   }
   return $query;
}
add_action( 'pre_get_posts', 'gb_pre_get_inspiration' );
