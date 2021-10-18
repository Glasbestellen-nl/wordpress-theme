<?php
$product_count = ! empty( $product_count ) ? $product_count : 0;
$static_price = get_field( 'static_price' );
?>

<div class="product-listing <?php echo ( $product_count == 1 ) ? 'product-listing--first' : ''; ?>">
   <a href="<?php the_permalink(); ?>" class="product-listing__image">
      <img data-src="<?php echo get_the_post_thumbnail_url( get_the_id(), 'large' ); ?>" class="lazyload product-listing__image-img" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>">
   </a>
   <div class="product-listing__body">
      <h2 class="h5"><a href="<?php the_permalink(); ?>" class="product-listing__title" data-mh="product-listing-title"><?php the_title(); ?></a></h2>
      <div class="product-listing__info">
         <span class="product-listing__price"><?php echo ( ( ! $static_price ) ? __( 'v.a.', 'glasbestellen' ) : '' ) . ' ' . Money::display( $configurator->get_total_price( true, true ) ); ?></span>
         <span class="product-listing__tax"><?php _e( 'Prijs incl. BTW.', 'glasbestellen' ); ?></span>
         <span class="product-listing__shipping"><i class="fas fa-shipping-fast"></i> <?php _e( 'Gratis verzending', 'glasbestellen' ); ?></span>
      </div>
   </div>
   <a href="<?php the_permalink(); ?>" class="product-listing__link-cover"></a>
</div>
