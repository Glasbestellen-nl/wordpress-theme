      <tr>
         <td style="border-collapse: collapse; padding: 30px 40px; border-top: 1px dotted #dbdad7;">

            <table style="border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;" border="0" cellpadding="0" cellspacing="0" width="100%">
               <tr>
                  <td style="padding-bottom: 5px;"><?php _e( 'Vriendelijke groet', 'glasbestellen' ); ?>,</td>
               </tr>
               <tr>
                  <td  style="padding-bottom: 5px;"><?php bloginfo( 'name' ); ?></td>
               </tr>
               <?php
               if ( get_option( 'company_street' ) && get_option( 'company_number' ) ) {
                  echo '<tr><td style="padding-bottom: 5px;">' . get_option( 'company_street' ) . ' ' . get_option( 'company_number' ) . '</td></tr>';
               }
               if ( get_option( 'company_zipcode' ) && get_option( 'company_city' ) ) {
                  echo '<tr><td style="padding-bottom: 5px;">' . get_option( 'company_zipcode' ) . ', ' . get_option( 'company_city' ) . '</td></tr>';
               }
               ?>
            </table>

         </td>

      </tr>

      <tr>
         <td style="padding: 10px 0; background: #105081;  text-align: center; color: #fff; font-family: Arial, sans-serif; font-size: 12px;"">
            NL78 ABNA 0581084446 &middot; BTW NL 854123143B01 &middot; KvK 60931809
         </td>
      </tr>

      </table>

   </body>

</html>
