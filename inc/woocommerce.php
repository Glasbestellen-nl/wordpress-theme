<?php
/**
 * Loads step indicators on cart page
 */
function gb_cart_page_before_layout() {
    if ( is_cart() ) 
        wc_get_template_part( 'cart/step-indicators' );
}
add_action( 'page_before_layout', 'gb_cart_page_before_layout' );

/**
 * Loads step indicators on checkout page
 */
function gb_checkout_page_before_layout() {
    if ( is_checkout() ) 
        wc_get_template_part( 'checkout/step-indicators' );
}
add_action( 'page_before_layout', 'gb_checkout_page_before_layout' );

/**
 * Change total configured product price based on configurator total
 */
function gb_configured_product_price( $price, $product ) {
    if ( $product->get_type() == "configurable" ) {
        $configurator = $product->get_configurator();
        if ( is_cart() || is_checkout() ) return $price;
        if ( is_singular( 'product' ) || defined( 'DOING_AJAX' ) ) {
            $price = $configurator->get_total_price();
        } else {
            $price = $configurator->get_total_price( true, true );
        }
    }
    return $price;
}
add_filter( 'woocommerce_product_get_price', 'gb_configured_product_price', 10, 2 );

/**
 * Use custom price from configuring product as cart item price
 */
function woocommerce_add_custom_price( $cart ) {

    // This is necessary for WC 3.0+
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // Avoiding hook repetition (when using price calculations for example)
    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

    // Loop through cart items
    foreach ( $cart->get_cart() as $item ) {
        if ( ! empty( $item['custom_price'] ) ) {
            $item['data']->set_price( $item['custom_price'] );
        }
    }
}
add_action( 'woocommerce_before_calculate_totals', 'woocommerce_add_custom_price', 20, 1);

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
    require_once( TEMPLATEPATH . '/class/WC_Product_Extended.php' );
    require_once( TEMPLATEPATH . '/class/WC_Product_Configurable.php' );
}
add_action( 'init', 'gb_register_configurable_product_type' );

/**
 * Adds configurable product type class
 */
function gb_load_product_type_class( $classname, $product_type ) {
	if ( $product_type == 'configurable' ) {
	    $classname = 'WC_Product_Configurable';
	} else {
        $classname = 'WC_Product_Extended';
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