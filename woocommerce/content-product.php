<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$product_count = ! empty( $product_count ) ? $product_count : 0;
$static_price = get_field( 'static_price' );
?>

<div class="product-listing">
   <a href="<?php the_permalink(); ?>" class="product-listing__image">
      <img src="<?php echo get_the_post_thumbnail_url( get_the_id(), 'large' ); ?>" class="product-listing__image-img" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>">
   </a>
   <div class="product-listing__body">
		<h3 class="h5"><a href="<?php the_permalink(); ?>" class="product-listing__title" data-mh="product-listing-title"><?php the_title(); ?></a></h3>
      <div class="product-listing__info">
         <span class="product-listing__price"><?php echo ( ( ! $static_price ) ? __( 'v.a.', 'glasbestellen' ) : '' ) . ' ' . wc_price( wc_get_price_including_tax( $product ) ); ?></span>
         <span class="product-listing__tax"><?php _e( 'Prijs incl. BTW.', 'glasbestellen' ); ?></span>
         <span class="product-listing__shipping"><i class="fas fa-shipping-fast"></i> <?php _e( 'Gratis verzending', 'glasbestellen' ); ?></span>
      </div>
   </div>
   <a href="<?php the_permalink(); ?>" class="product-listing__link-cover"></a>
</div>

