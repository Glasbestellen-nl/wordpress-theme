<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

    <?php if ( $checkout->get_checkout_fields() ) : ?>

        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

        <div class="row" id="customer_details">
            <div class="col-lg-6">
                <div class="space-md-around">
                    <div class="space-below">
                        <?php do_action( 'woocommerce_checkout_billing' ); ?>
                        <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                    </div> 
                    <?php do_action( 'woocommerce_checkout_after_shipping' ); ?>
                </div>
            </div>

            <div class="col-lg-6">

                <div class="space-md-around">

                    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
        
                    <h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
                    
                    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>

                    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

                    <div class="layout space-below">
                        <div class="layout__column">
                            <h2 class="h3 h-underlined"><?php _e( 'Betaal bij ons met', 'glasbestellen' ); ?></h2>
                            <div class="payment-icons">
                                <img src="<?php echo get_template_directory_uri() . '/assets/images/payment-icons.png'; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="layout space-below">
                        <div class="layout__column text-center">
                            <h2 class="h3"><?php _e( 'Klanttevredenheid is wat ons drijft!', 'glasbestellen' ); ?></h2>
                            <span class="subline space-below"><?php _e( 'Onze klanten beoordelen ons gemiddeld met', 'glasbestellen' ); ?>:</span>

                            <div class="rating rating--checkout">
                                <div class="stars stars--large rating__stars">
                                    <?php
                                    for ( $i = 1; $i <= 5; $i ++ ) {
                                        $checked_class = ( $i <= gb_get_review_average( false, null, 0 ) ) ? 'star--checked' : '';
                                        echo '<div class="fas fa-star star ' . $checked_class . '"></div> ';
                                    }
                                    ?>
                                </div>
                                <span class="rating__number rating__number--light-bg"><?php echo gb_get_review_average( true ); ?></span>
                            </div>
                        </div>  
                    </div> 

               </div>

            </div>
        </div>

        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

    <?php endif; ?>                            

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

