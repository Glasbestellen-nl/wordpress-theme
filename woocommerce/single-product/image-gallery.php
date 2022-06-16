<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;
$gallery_image_ids = $product->get_gallery_image_ids();

if ( $gallery_image_ids ) { ?>

    <div class="image-slider large-space-below js-image-slider">
        <div class="image-slider__container image-slider__main">
            <?php if ( count( $gallery_image_ids ) > 1 ) { ?>
                <div class="image-slider__arrows">
                    <div class="image-slider__arrow image-slider__arrow--prev js-prev">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                    <div class="image-slider__arrow image-slider__arrow--next js-next">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            <?php } ?>
            <a href="<?php echo wp_get_attachment_image_src( $gallery_image_ids[0], 'full' )[0]; ?>" class="fancybox" title="<?php echo get_the_title( $gallery_image_ids[0] ); ?>">
                <img src="<?php echo wp_get_attachment_image_src( $gallery_image_ids[0], 'full' )[0]; ?>" class="image-slider__img image-slider__main-img js-main" alt="<?php echo get_post_meta( $gallery_image_ids[0], '_wp_attachment_image_alt', true ); ?>">
            </a>
        </div>	

        <div class="image-slider__thumbs">

            <?php
            $index = 0;
            foreach ( $gallery_image_ids as $image_id ) {
                $index ++; ?>
                <div class="image-slider__container image-slider__thumb js-thumb <?php echo ( $index == 1 ) ? 'current' : ''; ?>">
                    <img src="<?php echo wp_get_attachment_image_src( $image_id, 'medium' )[0]; ?>" class="image-slider__img image-slider__thumb-img" alt="<?php echo get_post_meta( $image_id, '_wp_attachment_image_alt', true ); ?>" title="<?php echo get_the_title( $image_id ); ?>" data-index="<?php echo $index; ?>" data-image="<?php echo wp_get_attachment_image_src( $image_id, 'full' )[0]; ?>">
                </div>

            <?php } ?>

        </div>
    </div>

<?php } ?>