<div class="product-listing">
   <a href="<?php the_permalink(); ?>" class="product-listing__image">
      <img data-src="<?php echo get_the_post_thumbnail_url( get_the_id(), 'large' ); ?>" class="lazyload product-listing__image-img" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>">
   </a>
   <div class="product-listing__body">
      <h2 class="h5"><a href="<?php the_permalink(); ?>" class="product-listing__title" data-mh="product-listing-title"><?php the_title(); ?></a></h2>
      <div class="product-listing__info">
         <span class="product-listing__price"><?php echo sprintf( __( 'v.a. %s', 'glasbestellen' ), Money::display( $configurator->get_total_price( true, true ) ) ); ?></span>
         <span class="product-listing__tax"><?php _e( 'Prijs incl. BTW.', 'glasbestellen' ); ?></span>
         <span class="product-listing__shipping"><i class="fas fa-shipping-fast"></i> <?php _e( 'Gratis verzending', 'glasbestellen' ); ?></span>
      </div>
   </div>
</div>
