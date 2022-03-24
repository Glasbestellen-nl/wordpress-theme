<?php
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

add_filter( 'rewrite_rules_array', function( $rules ) {
    $new_rules = [
        'producten/([^/]*?)/?$' => 'index.php?product_cat=$matches[1]',
        'producten/([^/]*?)/([^/]*?)?$' => 'index.php?product_cat=$matches[1]&product=$matches[2]',
        'producten/([^/]*?)/page/([0-9]{1,})/?$' => 'index.php?product_cat=$matches[1]&paged=$matches[2]',
    ];
    return $new_rules + $rules;
});


function gb_test_wc() {

    // $order = wc_create_order();
    $product_id = 2367;
    // $product = wc_get_product( $product_id );
    $quantity = 1;

    // $order->add_product( $product, $quantity, [
    //     'subtotal'  => 525.34,
    //     'total'     => 525.34, 
    // ]);
    // $total = $order->calculate_totals();
    // $order->set_total($total);
    // $order->save();

    global $woocommerce;
    $cart_item_data = ['custom_price' => 117.22];
    $woocommerce->cart->add_to_cart( $product_id, $quantity, null, null, $cart_item_data );
    $woocommerce->cart->calculate_totals();
    $woocommerce->cart->set_session();
    $woocommerce->cart->maybe_set_cart_cookies();

    // die;

}
// add_action( 'init', 'gb_test_wc' );

function woocommerce_custom_price_to_cart_item( $cart_object ) {  
    if( !WC()->session->__isset( "reload_checkout" )) {
        foreach ( $cart_object->cart_contents as $key => $value ) {
            if( isset( $value["custom_price"] ) ) {
                //for woocommerce version lower than 3
                //$value['data']->price = $value["custom_price"];
                //for woocommerce version +3
                $value['data']->set_price($value["custom_price"]);
            }
        }  
    }  
}
add_action( 'woocommerce_before_calculate_totals', 'woocommerce_custom_price_to_cart_item', 1000 );