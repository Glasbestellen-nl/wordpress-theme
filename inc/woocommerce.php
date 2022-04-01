<?php
/**
 * Adds a custom woocommerce product tab
 */
function gb_product_data_tabs( $tabs) {

	$tabs['configurable'] = array(
		'label'		=> __( 'Configurable', 'woocommerce' ),
		'target'	=> 'configurable_options',
		'class'		=> array( 'show_if_configurable', 'show_if_configurable'  ),
	);
	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'gb_product_data_tabs' );

/**
 * Add a custom woocommerce panel html
 */
function gb_product_data_panels() { 
    
    echo '<div id="configurable_options" class="panel woocommerce_options_panel" style="display: none">';

    $configurators = get_posts( 'post_type=configurator&posts_per_page=-1' );
    if ( ! $configurators ) return;

    $options = [];
    foreach ( $configurators as $configurator ) {
        $options[$configurator->ID] = $configurator->post_title;    
    }

    woocommerce_wp_select([
		'id'            => 'configurator',
		'value'         => get_post_meta( get_the_id(), 'configurator', true ),
		'label'         => __( 'Configurator', 'glasbestellen' ),
        'wrapper_class' => 'show_if_configurable',
		'options'       => $options
    ]);

    echo '</div>';
}
add_action( 'woocommerce_product_data_panels', 'gb_product_data_panels' );

/**
 * Saves custom woocommerce panel fields
 */
function gb_process_product_meta( $post_id ){

	if ( ! empty( $_POST['configurator'] ) ) {
		update_post_meta( $post_id, 'configurator', $_POST['configurator'] );
	} else {
	    delete_post_meta( $post_id, 'configurator' );
	}
}
add_action( 'woocommerce_process_product_meta', 'gb_process_product_meta', 10 );


/**
 * Single product wrapper class
 */
function gb_single_product_wrapper_class() {
    global $product;
    $classes = [];
    if ( 'configurable' == $product->get_type() ) {
        $classes[] = 'configurator';
        $classes[] = 'js-configurator';
    }
    $classes = apply_filters( 'gb_single_product_wrapper_class', $classes, $product );
    return implode( ' ', $classes );
}

/**
 * Adds configurable product type class
 */
function gb_register_configurable_product_type() {
    require_once( TEMPLATEPATH . '/class/WC_Configured_Product.php' );
}
add_action( 'init', 'gb_register_configurable_product_type' );

/**
 * Adds configurable product type class
 */
function gb_load_product_type_class( $classname, $product_type ) {
	if ( $product_type == 'configurable' ) {
	    $classname = 'WC_Product_Configurable';
	}
	return $classname;
}
add_filter( 'woocommerce_product_class', 'gb_load_product_type_class', 10, 2);

/**
 * Adds configurable product type to selector
 */
function gb_add_configurable_product_type_selector( $types ){
    $types['configurable'] = __( 'Configurable product' );
    return $types;
}
add_filter( 'product_type_selector', 'gb_add_configurable_product_type_selector' );

/**
 * Enables woocommerce customization
 */
function gb_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'gb_add_woocommerce_support' );

/**
 * Adds rewrite rules for product and product cat (shop) with same base
 */
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