<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header( 'shop' );
?>

<main class="<?php echo gb_single_product_wrapper_class(); ?>">

	<div class="main-section main-section--space-around main-section--grey">

		<div class="container container--sm-without-space">

			<section class="layout layout--sm-full-width">

				<div class="layout__column box-shadow">

					<?php
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<div class="breadcrumbs small-space-below">', '</div>' );
					}
					?>

					<div class="d-block d-md-flex align-items-center space-below">

						<section class="text space-right">
							<h1 class="h-default tiny-space-sm-below"><?php the_title(); ?></h1>
						</section>

						<?php wc_get_template_part( 'single-product/review-summary' ); ?>

					</div>

					<div class="row large-space-below">
						
						<div class="col-12 col-lg-6">
							
							<?php 
							wc_get_template_part( 'single-product/image-gallery' ); 
							wc_get_template_part( 'single-product/links-list' ); 
							wc_get_template_part( 'single-product/videos' );
							?>

						</div>

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

					<article class="text space-below">

						<?php the_content(); ?>

						<h2 class="space-below"><?php _e( 'Technische informatie', 'glasbestellen' ); ?></h2>

						<?php wc_get_template_part( 'single-product/technical-details' ); ?>

					</article>

					<?php wc_get_template_part( 'single-product/reviews' ); ?>

					<?php wc_get_template_part( 'single-product/related-products' ); ?>
					
				</div>
			</section>
		</div>
	</div>
	
</main>	

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
