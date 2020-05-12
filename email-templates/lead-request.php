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
               $html = __( 'Bedankt voor uw bericht.', 'glasbestellen' );
               $html .= '<br/><br/>';
               $html .= __( 'We gaan er graag mee aan de slag en komen zo snel mogelijk bij u terug met een antwoord en/of offerte!', 'glasbestellen' );
               echo $html;
               ?>
            </td>
         </tr>

      </table>

   </td>
</tr>

<?php if ( $message ) { ?>
   <tr>
   	<td style="padding: 30px 40px 30px 40px; background-color: #f0f0f0;">

         <table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 12px;" border="0" cellpadding="0" cellspacing="0" width="100%">

            <tr>
               <td style="font-family: Arial, sans-serif; font-size: 16px; color: #0c5994;">
                  <b><?php echo __( 'Uw bericht', 'glasbestellen' ) . ':'; ?></b>
               </td>
            </tr>

            <tr>
               <td style="padding-top: 15px; font-family: Arial, sans-serif; font-size: 14px; line-height: 22px;">
                  <?php echo '<i>' . $message . '</i>'; ?>
               </td>
            </tr>

         </table>

      </td>
   </tr>
<?php } ?>

<?php require_once( TEMPLATEPATH . '/email-templates/email-footer.php' ); ?>
