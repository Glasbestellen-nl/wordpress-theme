<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$term_id = get_queried_object_id();

if ( $gallery_images = get_field( 'gallery_images', 'term_' . $term_id ) ) { ?>

    <div class="row gallery js-bricks">

        <?php foreach ( $gallery_images as $image ) { ?>

            <div class="col-6 col-md-4 col-lg-3 js-brick">

                <a href="<?php echo $image['url']; ?>" class="gallery__item fancybox" data-fancybox rel="product-images" title="<?php echo $image['caption']; ?>">
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>" class="gallery__image" />
                </a>

            </div>

        <?php } ?>

    </div>

<?php } ?>