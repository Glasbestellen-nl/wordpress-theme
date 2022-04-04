<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<div class="<?php echo gb_single_product_wrapper_class(); ?>">

	<main class="main-section main-section--space-around main-section--grey">

		<div class="container container--sm-without-space">

			<section class="layout layout--sm-full-width">

				<div class="layout__column box-shadow">

					<?php do_action( 'woocommerce_before_main_content' ); ?>

					<div class="row large-space-below">
						
						<div class="col-12 col-lg-6">
						</div>

						<div class="col-12 col-lg-6">
				
							<?php 
							while ( have_posts() ) {
								the_post();
								if ( $product->get_type() == "configurable" ) {
									wc_get_template_part( 'content', 'configurable-product' );
								} else {
									wc_get_template_part( 'content', 'single-product' );
								}
							} 
							?>

						</div>	
					</div>	
					
					<?php do_action( 'woocommerce_after_main_content' ); ?>

				</div>
			</section>
		</div>
	</main>

	<div class="sticky-bar sticky-bar--desktop-top js-sticky-bar" data-trigger='[{"element": ".js-configurator-details", "screen": "desktop"}, {"element": ".js-configurator-details", "screen": "mobile"}]' style="display: none;">
		<div class="container">
			<div class="row d-flex align-items-center">
			<div class="col-4 col-lg-2 offset-lg-6">
				<span class="js-config-total-price d-block text-size-medium text-color-blue text-weight-bold"><?php echo wc_price( $product->get_price() ); ?></span>
				<span class="text-size-tiny text-color-grey"><?php _e( 'Prijs incl. BTW.', 'glasbestellen' ); ?></span>
			</div>
			<div class="col-7 offset-1 col-lg-4 offset-lg-0">
				<div class="d-flex">
					<button class="btn btn--block btn--primary btn--tiny js-configurator-cart-button"><?php _e( 'In winkelwagen', 'glasbestellen' ); ?></button>
					<?php if ( ! get_field( 'disable_quote_button' ) ) { ?>
						<span class="d-none d-md-flex align-items-center justify-content-center btn btn--block btn--aside js-configurator-save-button small-space-left" data-popup-title="<?php _e( 'Samenstelling als offerte ontvangen', 'glasbestellen' ); ?>" data-formtype="save-configuration" data-meta="<?php the_id(); ?>"><i class="fas fa-file-import"></i> &nbsp;&nbsp;<?php _e( 'Offerte', 'glasbestellen' ); ?></span>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>	

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
