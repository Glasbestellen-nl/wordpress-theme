<?php
function gb_handle_get_cart_quantity() {
   echo gb_get_cart_quantity();
   wp_die();
}
add_action( 'wp_ajax_get_cart_quantity', 'gb_handle_get_cart_quantity' );
add_action( 'wp_ajax_nopriv_get_cart_quantity', 'gb_handle_get_cart_quantity' );

/**
 * Adds cart body classes
 */
function gb_cart_body_class( $class ) {
   if ( gb_is_cart_page() ) {
      $class[] = 'js-cart';
   }
   return $class;
}
add_action( 'body_class', 'gb_cart_body_class' );

/**
 * Handles cart item quantity requests
 */
function gb_handle_cart_item_quantity() {

   if ( empty( $_POST['id'] ) || empty( $_POST['quantity'] ) ) wp_die();

   $cart = gb_get_cart();
   $cart->update_item_quantity( $_POST['id'], $_POST['quantity'] );
   gb_update_cart_session_items( $cart->get_items() );

   // Return cart url
   echo gb_get_cart_url();

   wp_die();
}
add_action( 'wp_ajax_handle_cart_item_quantity', 'gb_handle_cart_item_quantity' );
add_action( 'wp_ajax_nopriv_handle_cart_item_quantity', 'gb_handle_cart_item_quantity' );

/**
 * Handles cart item delete requests
 */
function gb_handle_cart_item_delete() {

   if ( empty( $_POST['id'] ) ) wp_die();

   $cart = gb_get_cart();
   $cart->delete_item( $_POST['id'] );
   gb_update_cart_session_items( $cart->get_items() );

   // Return cart url
   echo gb_get_cart_url();

   wp_die();
}
add_action( 'wp_ajax_handle_cart_item_delete', 'gb_handle_cart_item_delete' );
add_action( 'wp_ajax_nopriv_handle_cart_item_delete', 'gb_handle_cart_item_delete' );

/**
 * Handles cart item edit requests
 */
function gb_handle_cart_item_edit() {

   if ( empty( $_POST['id'] ) ) wp_die();

   // Get cart object
   $cart = gb_get_cart();

   // Get cart item
   $item = $cart->get_item( $_POST['id'] );

   // Check whether required input exist
   if ( empty( $item['configuration'] ) || empty( $item['post_id'] ) ) wp_die();

   // Get cart item configuration
   $configuration = $item['configuration'];

   // Get cart item configurator id
   $configurator_id = $item['post_id'];

   // Load cart item configuration in configurator
   $_SESSION['configuration'][$configurator_id] = $configuration;

   // Delete current cart item
   $cart->delete_item( $_POST['id'] );

   // Update cart session
   gb_update_cart_session_items( $cart->get_items() );

   // Return configurator url
   echo get_permalink( $configurator_id );

   wp_die();
}
add_action( 'wp_ajax_handle_cart_item_edit', 'gb_handle_cart_item_edit' );
add_action( 'wp_ajax_nopriv_handle_cart_item_edit', 'gb_handle_cart_item_edit' );

/**
 * Handles cart item redo requests
 */
function gb_handle_cart_item_redo() {

   if ( empty( $_POST['id'] ) ) wp_die();

   // Get cart object
   $cart = gb_get_cart();

   // Get cart item
   $item = $cart->get_item( $_POST['id'] );

   // Check whether required input exist
   if ( empty( $item['post_id'] ) ) wp_die();

   // Get cart item configurator id
   $configurator_id = $item['post_id'];

   // Return configurator url
   echo get_permalink( $configurator_id );

   wp_die();

}
add_action( 'wp_ajax_handle_cart_item_redo', 'gb_handle_cart_item_redo' );
add_action( 'wp_ajax_nopriv_handle_cart_item_redo', 'gb_handle_cart_item_redo' );

/**
 * Updates cart items in session
 */
function gb_update_cart_session_items( array $items = [] ) {
   $_SESSION['cart_items'] = $items;
   return true;
}

/**
 * Initializes cart object with session if isset
 */
function gb_get_cart() {

   if ( ! empty( $_SESSION['cart_items'] ) ) {
      $cart = new Cart( $_SESSION['cart_items'] );
   } else {
      $cart = new Cart;
   }
   return $cart;
}

/**
 * Check if is cart page based on template
 */
function gb_is_cart_page() {
   return is_page_template( 'cart.php' );
}

/**
 * Returns cart url
 */
function gb_get_cart_url() {
   if ( $page_id = get_page_id_by_template( 'cart.php' ) )
   return get_permalink( $page_id );
}

/**
 * Returns total cart quantity
 */
function gb_get_cart_quantity() {
   $cart = gb_get_cart();
   return $cart->get_total_quantity();
}
