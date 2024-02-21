<?php 
global $product; 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$quotation_disabled = get_field( 'quotation_disabled' );
?>

<div class="sticky-bar sticky-bar--desktop-top js-sticky-bar" data-trigger='[{"element": ".js-configurator-details", "screen": "desktop"}, {"element": ".js-configurator-details", "screen": "mobile"}]' style="display: none;">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-4 col-lg-2 offset-lg-6">
                <span class="js-config-total-price d-block text-size-medium text-color-blue text-weight-bold"><?php echo wc_price( wc_get_price_including_tax( $product ) ); ?></span>
                <span class="text-size-tiny text-color-grey"><?php _e( 'Prijs incl. BTW.', 'glasbestellen' ); ?></span>
            </div>
            <div class="col-7 offset-1 col-lg-4 offset-lg-0">
                <div class="d-flex">
                    <button class="btn btn--block btn--primary btn--tiny js-configurator-cart-button"><?php _e( 'In winkelwagen', 'glasbestellen' ); ?></button>
                    <?php if ( ! $quotation_disabled ) { ?>
                        <span class="d-none d-md-flex align-items-center justify-content-center btn btn--block btn--aside js-configurator-save-button small-space-left" data-popup-title="<?php _e( 'Samenstelling als offerte ontvangen', 'glasbestellen' ); ?>" data-formtype="save-configuration" data-meta="<?php the_id(); ?>"><i class="fas fa-file-import"></i> &nbsp;&nbsp;<?php _e( 'Offerte', 'glasbestellen' ); ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>    
    </div>
</div>
