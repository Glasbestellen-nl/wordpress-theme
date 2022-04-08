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

get_header( 'shop' );
?>

<div class="<?php echo gb_single_product_wrapper_class(); ?>">

	<main class="main-section main-section--space-around main-section--grey">

		<div class="container container--sm-without-space">

			<section class="layout layout--sm-full-width">

				<div class="layout__column box-shadow">

					<?php do_action( 'woocommerce_before_main_content' ); ?>

					<div class="row large-space-below">
						
						<div class="col-12 col-lg-6">
							
							<?php wc_get_template_part( 'single-product/image-gallery' ); ?>

						<div class="col-12 col-lg-6">
				
							<?php 
							if ( $product->get_type() == "configurable" ) {
								wc_get_template_part( 'content', 'configurable-product' );
							} else {
								wc_get_template_part( 'content', 'single-product' );
							}
							?>

						</div>	
					</div>	
					
					<?php do_action( 'woocommerce_after_main_content' ); ?>

				</div>
			</section>
		</div>
	</main>
	
	<?php wc_get_template_part( 'single-product/sticky-bar' ); ?>

</div>	

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
