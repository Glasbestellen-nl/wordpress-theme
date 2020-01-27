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

/**
 * Handles AJAX request to get single pin html
 */
function gb_get_single_popup_html() {

   if ( empty( $_GET['post_id'] ) ) wp_die();

   $query = new WP_Query( 'post_type=inspiratie&p=' . $_GET['post_id'] );

   if ( $query->have_posts() ) {
      while ( $query->have_posts() ) {
         $query->the_post();
         echo '<div class="large-space-around">';
            get_template_part( 'template-parts/single-pin' );
         echo '</div>';
      }
   }
   wp_die();
}
add_action( 'wp_ajax_get_single_popup_html', 'gb_get_single_popup_html' );
add_action( 'wp_ajax_nopriv_get_single_popup_html', 'gb_get_single_popup_html' );
