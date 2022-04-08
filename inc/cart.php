<?php
function gb_handle_get_cart_quantity() {
   global $woocommerce;
   echo $woocommerce->cart->cart_contents_count;
   wp_die();
}
add_action( 'wp_ajax_get_cart_quantity', 'gb_handle_get_cart_quantity' );
add_action( 'wp_ajax_nopriv_get_cart_quantity', 'gb_handle_get_cart_quantity' );