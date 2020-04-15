<?php require_once( TEMPLATEPATH . '/email-templates/email-header.php' ); ?>

<tr>
	<td style="padding: 30px 40px;">

		<table style="border-collapse: collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">

			<tr>
				<td style="font-family: Arial, sans-serif; font-size: 16px; color: #0c5994;">
					<b><?php echo __( 'Beste', 'glasbestellen' ) . ' ' . $billing['first_name'] . ' ' . $billing['last_name'] . ','; ?></b>
				</td>
			</tr>

			<tr>
				<td style="padding-top: 15px; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
					<?php
					$html  = sprintf( __( 'Bedankt voor het bestellen bij %s. Mocht je vragen hebben neem dan gerust <a href="%s">contact op</a>.', 'glasbestellen' ), get_bloginfo( 'name' ), get_permalink( get_page_id_by_template( 'contact.php' ) ) );
					$html .= '&nbsp;';
					$html .= sprintf( __( 'Uw order nummer is #%d. Deze orderbevestiging is tevens uw factuur.', 'glasbestellen' ), $order_id );
					echo $html;
					?>
				</td>
			</tr>

		</table>

	</td>
</tr>

<tr>

	<td style="padding: 10px 0 20px 0;">

		<table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;" border="0" cellpadding="0" cellspacing="0" width="100%">

			<thead>
				<tr style="border-bottom: 1px dotted #dbdad7; color: #0c5994;">
					<th align="left" width="60%" style="padding: 0 0 10px 40px;"><?php _e( 'Product', 'glasbestellen' ); ?></th>
					<th align="center" style="padding-bottom: 10px;"><?php _e( 'Aantal', 'glasbestellen' ); ?></th>
					<th align="right" style="padding: 0 40px 10px 0;"><?php _e( 'Subtotaal', 'glasbestellen' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<?php
				if ( ! empty( $items ) ) {
					$count = 0;
					$cart = new Cart( $items );
					while ( $cart->have_items() ) {
						$cart->the_item();
						$count ++; ?>

						<tr style="border-bottom: 1px dotted #dbdad7;<?php if ( $count % 2 ) echo ' background: #fcfcfd'; ?>">
							<td style="padding: 15px 0 15px 40px;">
								<?php
								echo '<span style="display: block; color: #0c5994;' . ( ( $cart->get_item_summary() ) ? ' margin-bottom: 10px; text-decoration: underline;' : '' ) . '">' . $cart->get_item_title() . '</span>';

								if ( $cart->get_item_summary() ) {

									$html = '<table style="font-family: Arial, sans-serif; font-size: 12px;" border="0" cellpadding="0" cellspacing="0" width="100%">';

									foreach ( $cart->get_item_summary() as $row ) {

										$html .= '<tr>';
											$html .= '<th align="left" style="padding-bottom: 7px;">' . $row['label'] . ':</th>';
											$html .= '<td align="right" style="padding-bottom: 7px;">' . $row['value'] . '</td>';
										$html .= '</tr>';

									}
									$html .= '</table>';
									echo $html;

								}

								?>
							</td>
							<td align="center" style="padding: 10px 0;"><?php echo $cart->get_item_quantity(); ?></td>
							<td align="right" style="padding: 10px 40px 10px 0;"><?php echo Money::display( $cart->get_item_price() ); ?></td>
						</tr>

					<?php
					}

				}
				?>
			</tbody>

		</table>

	</td>

</tr>

<tr>
	<td style="padding: 10px 40px 20px 40px; border-bottom: 1px dotted #dbdad7">

		<table width="100%">

			<tr>

				<td width="50%">

					<table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;" border="0" cellpadding="0" cellspacing="0" width="100%">

						<tr>
							<td style="padding-bottom: 15px; font-family: Arial, sans-serif; font-size: 16px; color: #0c5994;">
								<b><?php echo __( 'Klantgegevens', 'glasbestellen' ); ?></b>
							</td>
						</tr>

						<?php if ( ! empty( $billing['company'] ) ) { ?>
							<tr>
								<td style="padding-bottom: 5px;" ><?php echo $billing['company']; ?></td>
							</tr>
						<?php } ?>

						<?php if ( ! empty( $billing['reference'] ) ) { ?>
							<tr>
								<td style="padding-bottom: 5px;" ><?php echo __( 'Referentie', 'glasbestellen' ) . ': ' . $billing['reference']; ?></td>
							</tr>
						<?php } ?>

						<tr>
							<td style="padding-bottom: 5px;" ><?php echo $billing['first_name'] . ' ' . $billing['last_name']; ?></td>
						</tr>

						<tr>
							<td style="padding-bottom: 5px;"><?php echo $billing['street'] . ' ' . $billing['number'] . ' ' . ( isset( $billing['addition'] ) ? $billing['addition'] : '' ); ?></td>
						</tr>
						<tr>
							<td style="padding-bottom: 5px;"><?php echo $billing['zipcode'] . ' ' . $billing['city'] . ', ' . $billing['country']; ?></td>
						</tr>
						<tr>
							<td style="padding-bottom: 5px;"><?php echo '<strong>E:</strong> ' . $billing['email']; ?></td>
						</tr>
						<tr>
							<td style="padding-bottom: 5px;"><?php echo '<strong>T:</strong> ' . $billing['phone']; ?></td>
						</tr>

						<?php if ( ! empty( $delivery_address['street'] ) ) { ?>

							<tr>
								<td style="padding-top: 15px; padding-bottom: 15px; font-family: Arial, sans-serif; font-size: 16px; color: #0c5994;">
									<b><?php echo __( 'Bezorgadres', 'glasbestellen' ); ?></b>
								</td>
							</tr>

							<tr>
								<td style="padding-bottom: 5px;"><?php echo $delivery_address['street'] . ' ' . $delivery_address['number'] . ' ' . ( isset( $delivery_address['addition'] ) ? $delivery_address['addition'] : '' ); ?></td>
							</tr>
							<tr>
								<td style="padding-bottom: 5px;"><?php echo $delivery_address['zipcode'] . ' ' . $delivery_address['city'] . ', ' . $delivery_address['country']; ?></td>
							</tr>

						<?php } ?>

					</table>

				</td>

				<td width="50%">

					<table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;" border="0" cellpadding="0" cellspacing="0" width="100%">

						<tr>
							<td width="10%" style="padding-bottom: 10px;"></td>
							<th align="right" style="padding-bottom: 10px;"><?php _e( 'Subtotaal', 'glasbestellen' ); ?>:</th>
							<td align="right" style="padding-bottom: 10px;"><?php echo Money::display( $total_price ); ?></td>
						</tr>

						<tr>
							<td width="10%" style="padding-bottom: 10px;"></td>
							<th align="right" style="padding-bottom: 10px;"><?php _e( 'Verzendkosten', 'glasbestellen' ); ?>:</th>
							<td align="right" style="padding-bottom: 10px;">
								<?php
								if ( empty( $shipping_price ) ) {
									_e( 'Gratis', 'glasbestellen' );
								} else {
									echo Money::display( $shipping_price );
								}
								?>
                     </td>
						</tr>

						<tr>
							<td width="10%" style="padding: 10px 0;"></td>
							<th align="right" style="padding: 10px 0; border-top: 3px double #dbdad7;"><?php _e( 'Totaal', 'glasbestellen' ); ?>:</th>
							<td align="right" style="padding: 10px 0; border-top: 3px double #dbdad7;"><?php echo Money::display( $total_price ); ?></td>
						</tr>

						<tr>
							<td width="10%" style="padding-bottom: 10px;"></td>
							<th align="right" style="padding-bottom: 10px;"></th>
							<td align="right" style="padding-bottom: 10px; font-style: italic; font-size: 11px;">(<?php echo __( 'Waarvan BTW', 'glasbestellen' ) . ' ' . Money::display( Money::vat( $total_price, false ), false ); ?>)</td>
						</tr>

						<tr>
							<td width="10%" style="padding: 10px 0;"></td>
							<th align="right" style="padding-bottom: 10px 0;"><?php _e( 'Reeds voldaan', 'glasbestellen' ); ?>:</th>
							<td align="right" style="padding-bottom: 10px 0;"><?php echo Money::display( $total_price ); ?></td>
						</tr>

						<tr>
							<td width="10%" style="padding: 15px 0;"></td>
							<th align="right"><?php _e( 'Te voldoen', 'glasbestellen' ); ?>:</th>
							<td align="right"><?php echo Money::display( 0 ); ?></td>
						</tr>

					</table>
				</td>

			</tr>

		</table>

	</td>
</tr>

<tr>
	<td>
		<table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td style="padding: 30px 40px 20px 40px;">

					<table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;" border="0" cellpadding="0" cellspacing="0" width="100%">

						<tr>
							<td style="font-family: Arial, sans-serif; font-size: 16px; color: #0c5994;">
								<b><?php echo __( 'Verder verloop van uw bestelling', 'glasbestellen' ); ?></b>
							</td>
						</tr>

						<tr>
							<td style="padding-top: 20px;">

								<table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;" border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<th style="padding: 0 15px 0 0; font-size: 18px; text-align: left; vertical-align: middle; color: #399c19;">1.</th>
										<td style="padding: 15px; border: 1px solid #339015; background: #399c19; color: #fff;">
											<strong><?php _e( 'Order geplaatst', 'glasbestellen' ); ?></strong>
											<p style="line-height: 12px;"><?php _e( 'De door u bestelde artikelen worden in productie gezet.', 'glasbestellen' ); ?></p>
										</td>
									</tr>

									<tr>
										<th style="padding: 0 15px 0 0; font-size: 18px; vertical-align: middle; text-align: left;">2.</th>
										<td style="padding: 15px; border: 1px solid #dbdad7; background: #fcfcfd;">
											<strong><?php if ( isset( $shipping ) ) _e( 'Afspraak levering', 'glasbestellen' ); else _e( 'Bericht datum afhalen van uw bestelling', 'glasbestellen' ); ?></strong>
											<p style="line-height: 20px;">
												<?php
												if ( isset( $shipping ) )
													_e( 'Transport neemt voorafgaand aan de levering contact met u op om een leverdatum en tijd met u af te spreken.', 'glasbestellen' );
												else
													_e( 'U ontvangt van ons bericht met de datum waarop uw bestelling afhaal gereed staat, zodra deze vanuit productie bekend is.', 'glasbestellen' );
												?>
											</p>
										</td>
									</tr>

									<?php if ( isset( $shipping ) ) { ?>
										<!-- <tr>
											<th style="padding: 0 15px 0 0; font-size: 18px; vertical-align: middle; text-align: left;">3.</th>
											<td style="padding: 15px; border: 1px solid #dbdad7; background: #fcfcfd;">
												<strong><?php _e( 'Bericht levertijd', 'glasbestellen' ); ?></strong>
												<p style="line-height: 20px;"><?php _e( 'U ontvangt van ons, daags voor levering, bericht met het tijdsvak waarbinnen we bij u komen leveren.', 'glasbestellen' ); ?></p>
											</td>
										</tr> -->
									<?php } ?>
								</table>

							</td>
						</tr>

					</table>

				</td>
			</tr>
		</table>
	</td>
</tr>

<?php require_once( TEMPLATEPATH . '/email-templates/email-footer.php' ); ?>
