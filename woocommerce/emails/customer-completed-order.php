<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
<p><?php printf( esc_html__( 'Beste %s,', 'glasbestellen' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
<p><?php printf( esc_html__( 'Bedankt voor uw bestelling! Uw factuur met ordernummer #%d vindt u in de bijlage. Mocht u vragen hebben neem dan gerust contact met ons op.', 'glasbestellen' ), $order->get_id() ); ?></p>
<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

?>

<table style="border-collapse: collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td style="padding: 0; padding-bottom: 20px;">

			<table style="border-collapse: collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">

				<tr>
					<td style="padding: 0; color: #0c5994;">
						<h2><?php echo __( 'Verder verloop van uw bestelling', 'glasbestellen' ); ?></h2>
					</td>
				</tr>

				<tr>
					<td style="padding-top: 20px;">

						<table style="border-collapse: collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<th style="padding: 0 15px 0 0; font-size: 18px; text-align: left; vertical-align: middle; color: #399c19;">1.</th>
								<td style="padding: 15px; border: 1px solid #339015; background: #399c19; color: #fff;">
									<strong><?php _e( 'Bestelling', 'glasbestellen' ); ?></strong>
									<p style="margin: 0; line-height: 12px;"><?php _e( 'Bedankt voor uw bestelling!', 'glasbestellen' ); ?></p>
								</td>
							</tr>

							<tr>
								<th style="padding: 0 15px 0 0; font-size: 18px; vertical-align: middle; text-align: left;">2.</th>
								<td style="padding: 15px; border: 1px solid #dbdad7; background: #fcfcfd;">
									<strong><?php _e( 'Productie', 'glasbestellen' ); ?></strong>
									<p style="margin: 0; line-height: 20px;">
										<?php _e( 'Uw bestelling wordt op maat voor u geproduceerd.', 'glasbestellen' ); ?>
									</p>
								</td>
							</tr>

							<tr>
								<th style="padding: 0 15px 0 0; font-size: 18px; vertical-align: middle; text-align: left;">3.</th>
								<td style="padding: 15px; border: 1px solid #dbdad7; background: #fcfcfd;">
									<strong><?php _e( 'Levering', 'glasbestellen' ); ?></strong>
									<p style="margin: 0; line-height: 20px;"><?php _e( 'Uw bestelling wordt geleverd. Transport neemt voorafgaand aan de levering contact met u op om een afspraak te maken.', 'glasbestellen' ); ?></p>
								</td>
							</tr>
						</table>

					</td>
				</tr>

			</table>
		</td>
	</tr>
</table>

<?php

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
