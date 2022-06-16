<?php
/**
 * Changes "Place Order" Button text WooCommerce Checkout
 */
function bcc_woocommerce_button_text( $button_text ) {
	return __( 'Bestellen en betalen', 'glasbestellen' );
}
add_filter( 'woocommerce_order_button_text', 'bcc_woocommerce_button_text' );

/**
 * Moves payment below billing fields
 */
function bcc_theme_wc_setup() {
    remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
    add_action( 'woocommerce_checkout_after_shipping', 'woocommerce_checkout_payment', 20 );
}
add_action( 'after_setup_theme', 'bcc_theme_wc_setup' );

/**
 * Adds heading above payment on checkout
 */
add_action( 'woocommerce_review_order_before_payment', function() {
    echo '<h3>' . __( 'Kies betaalmethode', 'glasbestellen' ) . '</h3>';
});

/** 
 * Removes Order Notes Title - Additional Information & Notes Field
 */
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );

/** 
 * Remove Order Notes Field
 */
function remove_order_notes( $fields ) {
    unset ( $fields['order']['order_comments'] );
    return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'remove_order_notes' );