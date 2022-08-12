<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
$configurator = $product->get_configurator();

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div class="configurator__body">

	<div class="configurator__header large-space-below">

		<div class="row">

			<div class="col-12 col-md-6">
				<span class="h4 configurator__heading"><?php _e( 'Onze aanbieding voor u', 'glasbestellen' ); ?></span>
				<?php if ( get_field( 'show_energy_label' ) ) { ?>
					<div class="configurator__energy-label">
						<img src="<?php echo get_template_directory_uri() . '/assets/images/energy-label-a++.png'; ?>" title="<?php _e( 'Energielabel', 'glasbestellen' ); ?>">
					</div>
				<?php } ?>
			</div>

			<div class="col-12 col-md-6">
				<div class="configurator__details js-configurator-details">
				<span class="configurator__detail--price js-config-total-price"><?php echo wc_price( wc_get_price_including_tax( $product ) ); ?></span>
				<span class="configurator__detail--tax"><?php _e( 'Prijs incl. BTW.', 'glasbestellen' ); ?></span>
				<?php if ( $delivery_time = $configurator->get_setting( 'delivery_time' ) ) { ?>
					<span class="configurator__detail--delivery"><?php echo sprintf( __( 'Levertijd %s', 'glasbestellen' ), $delivery_time ); ?></span>
				<?php } ?>
				<span class="configurator__detail--shipping"><i class="fas fa-shipping-fast"></i> <?php _e( 'Gratis verzending', 'glasbestellen' ); ?></span>
				</div>
			</div>

		</div>

	</div>

	<div class="space-below">
		<span class="h4 configurator__heading">
		<?php echo sprintf( __( '%s samenstellen', 'glasbestellen' ), get_the_title() ); ?>
		<span class="configurator__heading-addition">(* <?php _e( 'Verplicht', 'glasbestellen' ); ?>)</span>
		</span>
		<p><?php echo sprintf( __( 'Klik voor meer informatie op het %s symbool.', 'glasbestellen' ), '<i class="fas fa-info-circle configurator__info-icon"></i>' ); ?></p>
	</div>

	<div></div>

	<form method="post" class="configurator__form js-configurator-blur-update js-configurator-form">

		<div id="react_configurator"></div>

		<div class="configurator__form-row">

			<div class="configurator__form-col configurator__form-label">
				<label><?php _e( 'Opmerking', 'glasbestellen' ) ?></label>
			</div>

			<div class="configurator__form-col configurator__form-input">
				<textarea class="form-control js-configurator-message" placeholder="<?php echo sprintf( __( 'Maximaal %d karakters', 'glasbestellen' ), 235 ); ?>" maxlength="235"></textarea>
			</div>

		</div>

		<div class="configurator__form-row space-below">
			<div class="configurator__form-col configurator__form-label">
				<label><?php _e( 'Aantal', 'glasbestellen' ) ?></label>
			</div>
			<div class="configurator__form-col configurator__form-input">
				<select class="dropdown configurator__form-control js-configurator-quantity">
					<?php for ( $i = 1; $i <= 10; $i ++ ) { ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="configurator__form-button small-space-below">
			<button class="btn btn--primary btn--block btn--next js-configurator-cart-button"><?php _e( 'In winkelwagen', 'glasbestellen' ); ?></button>
		</div>

		<?php if ( ! get_field( 'disable_quote_button' ) ) { ?>
			<div class="configurator__form-button space-below">
				<span class="btn btn--block btn--aside js-configurator-save-button" data-popup-title="<?php _e( 'Samenstelling als offerte ontvangen', 'glasbestellen' ); ?>" data-formtype="save-configuration" data-meta="<?php echo $product->get_configurator_id(); ?>"><i class="fas fa-file-import"></i> &nbsp;&nbsp;<?php _e( 'Mail mij een offerte', 'glasbestellen' ); ?></span>
			</div>
		<?php } ?>

		<ul class="configurator__checks space-below">
			<?php
			if ( get_field( 'checks' ) ) {
				while ( have_rows( 'checks' ) ) {
					the_row();
					echo '<li class="configurator__checks-item">' . get_sub_field( 'check_title' ) . '</li>';
				}
			}
			?>
			<li class="configurator__checks-item"><?php echo '<strong>' . __( 'Bestel check', 'glasbestellen' ) . ':</strong> ' . __( 'Uw bestelling wordt op juistheid en volledigheid gecontroleerd.', 'glasbestellen' ); ?></li>
			<li class="configurator__checks-item"><?php echo '<strong>' . __( 'Klantbeoordeling', 'glasbestellen' ) . ':</strong> ' . '<a href="' . get_post_type_archive_link( 'review' ) . '" target="_blank" rel="nofollow">' . gb_get_review_average( true ) . '/10</a>'; ?></li>
		</ul>
	</form>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
