<?php
/**
 * Show configuration summary data in cart item
 */
function gb_display_configuration_summary_in_cart( $item_data, $cart_item ) {

	if ( empty( $cart_item['configuration_summary'] ) ) 
        return $item_data;
	
    foreach ( $cart_item['configuration_summary'] as $line ) {
        $item_data[] = [
            'key'     => $line['label'],
            'value'   => $line['value'],
            'display' => '',
        ];
    }
	return $item_data;
}
add_filter( 'woocommerce_get_item_data', 'gb_display_configuration_summary_in_cart', 10, 2 );

/**
 * Adds product reference metadata at the end of the admin order item metadata
 */
function gb_reference_after_order_itemmeta( $item_id, $item, $product ) {
    if ( ! is_a( $product, 'WC_Product_Extended' ) ) return;
    $product_reference = $product->get_reference();
    if ( ! $product_reference ) return;
    echo '<strong>' . __( 'Referentie', 'glasbestellen' ) . ':</strong> ' . $product_reference;
}
add_action( 'woocommerce_after_order_itemmeta', 'gb_reference_after_order_itemmeta', 10, 3 );

/**
 * Add configuration summary to order items metadata
 */
function gb_configuration_summary_to_order_items( $item, $cart_item_key, $values, $order ) {

	if ( empty( $values['configuration_summary'] ) ) 
		return;
	
    foreach ( $values['configuration_summary'] as $line ) {
        $item->add_meta_data( $line['label'], $line['value'] );
    }
}
add_action( 'woocommerce_checkout_create_order_line_item', 'gb_configuration_summary_to_order_items', 10, 4 );

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
 * Filters product cat term url to rewrite structure
 */
function gb_product_cat_link_filter( $url, $term, $taxonomy ) {
    if ( 'product_cat' == $taxonomy ) {
        $url = site_url( "/producten/$term->slug/" );
    }
    return $url;
}
add_filter( 'term_link', 'gb_product_cat_link_filter', 10, 3 );

function gb_add_product_query_vars( $vars ) {
    $vars[] = 'is_product_cat_archive';
    return $vars;
}
add_filter( 'query_vars', 'gb_add_product_query_vars' );

function gb_product_cat_archive_template( $template ) {
    if ( get_query_var( 'is_product_cat_archive' ) ) {
        $archive_template = locate_template( ['product-cat-archive.php'] );
        if ( $archive_template ) return $archive_template;
    }
    return $template;
}
add_action( 'template_include', 'gb_product_cat_archive_template', 1 );

/**
 * Adds rewrite rules for product and product cat (shop) with same base
 */
add_filter( 'rewrite_rules_array', function( $rules ) {
    $new_rules = [
        'producten/?$' => 'index.php?is_product_cat_archive=1',
        'producten/([^/]*?)/?$' => 'index.php?product_cat=$matches[1]',
        'producten/([^/]*?)/([^/]*?)?$' => 'index.php?product_cat=$matches[1]&product=$matches[2]',
        'producten/([^/]*?)/page/([0-9]{1,})/?$' => 'index.php?product_cat=$matches[1]&paged=$matches[2]',
    ];
    return $new_rules + $rules;
});