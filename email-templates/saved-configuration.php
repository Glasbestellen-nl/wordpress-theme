<?php require_once( TEMPLATEPATH . '/email-templates/email-header.php' ); ?>

<tr>
   <td style="padding: 30px 40px 20px 40px;">

      <table style="border-collapse: collapse;" border="0" cellpadding="0" cellspacing="0" width="100%">

         <tr>
            <td style="font-family: Arial, sans-serif; font-size: 18px; color: #0c5994;">
               <b><?php echo __( 'Beste', 'glasbestellen' ) . ' ' . $relation_name . ','; ?></b>
            </td>
         </tr>

         <tr>
            <td style="padding-top: 15px; font-family: Arial, sans-serif; font-size: 14px; line-height: 22px;">
               <?php
               $html = sprintf( __( 'U heeft een offerte aangevraagd voor een <strong>%s</strong>. Hieronder vindt u uw samenstelling en prijs.', 'glasbestellen' ), $configurator_name );
               echo $html;
               ?>
            </td>
         </tr>


      </table>

   </td>
</tr>

<tr>
	<td style="padding: 10px 40px 20px 40px;">

      <table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;" border="0" cellpadding="0" cellspacing="0" width="100%">

         <tr>
            <td style="font-family: Arial, sans-serif; font-size: 16px; color: #0c5994;">
               <b><?php echo __( 'Uw aanvraag', 'glasbestellen' ) . ':'; ?></b>
            </td>
         </tr>

         <?php if ( $message ) { ?>
            <tr>
               <td style="padding-top: 15px; font-family: Arial, sans-serif; font-size: 14px; line-height: 22px;">
                  <?php echo $message; ?>
               </td>
            </tr>
         <?php } ?>

      </table>

   </td>
</tr>

<tr>

	<td style="padding: 10px 0 20px 0;">

		<table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; line-height: 18px;" border="0" cellpadding="0" cellspacing="0" width="100%">

			<thead>
				<tr style="border-bottom: 1px dotted #dbdad7; color: #0c5994;">
					<th align="left" width="60%" style="padding: 0 0 10px 40px;"><?php _e( 'Product', 'glasbestellen' ); ?></th>
					<th align="right" style="padding: 0 40px 10px 0;"><?php _e( 'Totaal incl. BTW.', 'glasbestellen' ); ?></th>
				</tr>
			</thead>

			<tbody>

				<tr style="border-bottom: 1px dotted #dbdad7; background: #fcfcfd;">
					<td style="padding: 15px 0 15px 40px;">
						<?php
						echo '<span style="display: block; color: #0c5994; margin-bottom: 10px; text-decoration: underline;">' . $configurator_name . '</span>';

						if ( ! empty( $summary ) ) {

							$html = '<table style="font-family: Arial, sans-serif; font-size: 14px;" border="0" cellpadding="0" cellspacing="0" width="100%">';

							foreach ( $summary as $row ) {

								$html .= '<tr>';
									$html .= '<th align="left" style="padding-bottom: 8px;">' . $row['label'] . ':</th>';
									$html .= '<td align="right" style="padding-bottom: 8px;">' . $row['value'] . '</td>';
								$html .= '</tr>';

							}
							$html .= '</table>';
							echo $html;

						}

						?>
					</td>
					<td align="right" style="padding: 10px 40px 10px 0;"><?php echo Money::display( $configuration_price ); ?></td>
				</tr>

            <tr>
               <td style="padding: 30px 40px 10px 40px; font-family: Arial, sans-serif; font-size: 14px; line-height: 22px;">
                  <?php
                  $html = __( 'Om uw samenstelling online te bekijken en doorgaan met bestellen door op de groene knop te klikken.', 'glasbestellen' );
                  echo $html;
                  ?>
               </td>
            </tr>

            <tr>
            	<td style="padding: 10px 0 20px 0;">

                  <table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;" border="0" cellpadding="0" cellspacing="0" width="100%">
                     <tr>
                        <td style="padding: 0 40px;">
                           <a href="<?php echo $configuration_url; ?>" style="padding: 0.875em 1.25em; display: block; text-align: center; border: 1px solid #368e19; font-weight: 600; text-decoration: none; font-size: 18px; line-height: 18px; border-radius: 4px; background: #399c1a; color: #fff;">Naar mijn samenstelling &raquo;</a>
                        </td>
                     </tr>
                  </table>

               </td>
            </tr>

			</tbody>

		</table>

	</td>

</tr>

<?php require_once( TEMPLATEPATH . '/email-templates/email-footer.php' ); ?>
