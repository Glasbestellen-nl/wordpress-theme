<?php
/**
 * Show cart contents / total Ajax
 */
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start(); ?>

   <a href="<?php echo wc_get_cart_url(); ?>" class="cart-button btn--aside cart-customlocation">
      <i class="fas fa-shopping-cart"></i>
      <span class="cart-button__quantity"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
   </a>

   <?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function gb_handle_edit_cart_item() {

   $response = [];

   if ( empty( $_POST['cart_item_key'] ) ) wp_die();

   $cart_item = WC()->cart->get_cart_item( $_POST['cart_item_key'] );
   if ( ! $cart_item ) wp_die();

   $product = $cart_item['data'];
   $configuration = $cart_item['configuration'];

   if ( empty( $product ) || empty( $configuration ) || $product->get_type() != 'configurable' ) wp_die();

   $configurator = $product->get_configurator();
   $configurator_id = $configurator->get_id();
   $configurator->update( $configuration );

   $_SESSION['configuration'][$configurator_id] = $configurator->get_configuration();
   $response['redirect_url'] = get_permalink( $product->get_id() );
   WC()->cart->remove_cart_item( $_POST['cart_item_key'] );

   wp_send_json( $response );
   wp_die();

}
add_action( 'wp_ajax_edit_cart_item', 'gb_handle_edit_cart_item' );
add_action( 'wp_ajax_nopriv_edit_cart_item', 'gb_handle_edit_cart_item' );