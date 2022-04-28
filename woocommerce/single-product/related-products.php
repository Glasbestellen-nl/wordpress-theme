<?php
global $product; 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$related_products = new WP_Query([
    'post_type' => 'product',
    'post__in'  => $product->get_upsell_ids()
]);
?>

<?php  if ( $related_products->have_posts() ) { ?>

    <div class="related-configurators large-space-above">

        <h4 class="h2 space-below"><?php _e( 'Andere bekeken ook:', 'glasbestellen' ); ?></h4>

        <div class="row">

            <?php
            while ( $related_products->have_posts() ) { 
                $related_products->the_post(); ?>

                <div class="col-6 col-lg-3">
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                </div>

            <?php 
            } 
            wp_reset_postdata();
            ?>

        </div>

    </div>

<?php } ?>	