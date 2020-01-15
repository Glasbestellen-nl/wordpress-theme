<?php
// Template name: Checkout
get_header();
$cart = gb_get_cart(); ?>

   <main class="main-section main-section--space-around main-section--grey">

      <div class="container">

         <ol class="step-indicator step-indicator--done-2">
            <li class="step-indicator__step step-indicator__step--done">
               <div class="step-indicator__step-number">1</div>
               <span class="step-indicator__step-text"><?php _e( 'Winkelwagen', 'glasbestellen' ); ?></span>
            </li>
            <li class="step-indicator__step step-indicator__step--done">
               <div class="step-indicator__step-number">2</div>
               <span class="step-indicator__step-text"><?php _e( 'Gegevens', 'glasbestellen' ); ?></span>
            </li>
            <li class="step-indicator__step">
               <div class="step-indicator__step-number">3</div>
               <span class="step-indicator__step-text"><?php _e( 'Betalen', 'glasbestellen' ); ?></span>
            </li>
            <li class="step-indicator__step">
               <div class="step-indicator__step-number">4</div>
               <span class="step-indicator__step-text"><?php _e( 'Afronden', 'glasbestellen' ); ?></span>
            </li>
         </ol>

         <div class="row">

            <div class="col-12 col-lg-7">

               <div class="layout layout--outstanding space-below">

                  <div class="layout__column">

                     <?php if ( $cart->have_items() ) { ?>

                        <form method="post" class="form checkout-form js-form-validation">

                           <fieldset class="form-section">

                              <h2 class="h3 h-underlined"><?php _e( 'Klantgegevens', 'glasbestellen' ); ?></h2>

                              <div class="form-group">
                                 <label class="form-check form-check--inline">
                                    <input type="radio" name="billing[order_type]" class="form-check__input js-hide-target-trigger" value="private" data-hide-target="#business_fields" checked>
                                    <span class="form-check__label"><?php _e( 'Particulier', 'glasbestellen' ); ?></span>
                                 </label>
                                 <label class="form-check form-check--inline">
                                    <input type="radio" name="billing[order_type]" class="form-check__input js-show-target-trigger" value="business" data-show-target="#business_fields">
                                    <span class="form-check__label"><?php _e( 'Zakelijk', 'glasbestellen' ); ?></span>
                                 </label>
                              </div>

                              <div class="d-none" id="business_fields">

                                 <div class="row additional-fields">

                                    <div class="form-group col-12 col-md-6">
                                       <label class="form-label"><?php _e( 'Bedrijfsnaam', 'glasbestellen' ); ?>:</label>
                                       <input type="text" name="billing[company]" class="form-control js-form-validate">
                                    </div>

                                    <div class="form-group col-12 col-md-6">
                                       <label class="form-label"><?php _e( 'Referentie', 'glasbestellen' ); ?>:</label>
                                       <input type="text" name="billing[reference]" class="form-control js-form-validate">
                                    </div>

                                 </div>

                              </div>

                              <div class="row">

                                 <div class="form-group js-form-group col-12 col-md-6">
                                    <label class="form-label"><?php _e( 'Voornaam', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                                    <input type="text" name="billing[first_name]" class="form-control js-form-validate" data-required="required">
                                    <div class="invalid-feedback js-invalid-feedback"></div>
                                 </div>

                                 <div class="form-group js-form-group col-12 col-md-6">
                                    <label class="form-label"><?php _e( 'Achternaam', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                                    <input type="text" name="billing[last_name]" class="form-control js-form-validate" data-required="required">
                                    <div class="invalid-feedback js-invalid-feedback"></div>
                                 </div>

                                 <div class="form-group js-form-group col-12 col-md-6">
                                    <label class="form-label"><?php _e( 'E-mail', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                                    <input type="email" name="billing[email]" class="form-control js-form-validate" data-required="required">
                                    <div class="invalid-feedback js-invalid-feedback"></div>
                                 </div>

                                 <div class="form-group js-form-group col-12 col-md-6">
                                    <label class="form-label"><?php _e( 'Telefoonnummer', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                                    <input type="tel" name="billing[phone]" class="form-control js-form-validate" data-required="required">
                                    <div class="invalid-feedback js-invalid-feedback"></div>
                                 </div>

                                 <div class="form-group col-12 col-md-6">
                                    <label class="form-label"><?php _e( 'Land', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                                    <select name="billing[country]" class="dropdown">
                                       <option><?php _e( 'Nederland', 'glasbestellen' ); ?></option>
                                       <option><?php _e( 'Belgi&euml;', 'glasbestellen' ); ?></option>
                                    </select>
                                 </div>

                                 <div class="form-group js-form-group col-12 col-md-6">
                                    <label class="form-label"><?php _e( 'Straat', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                                    <input type="text" name="billing[street]" class="form-control js-form-validate" data-required="required">
                                    <div class="invalid-feedback js-invalid-feedback"></div>
                                 </div>

                                 <div class="form-group js-form-group col-12 col-md-3">
                                    <label class="form-label"><?php _e( 'Huisnummer', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                                    <input type="number" name="billing[number]" class="form-control js-form-validate" data-required="required">
                                    <div class="invalid-feedback js-invalid-feedback"></div>
                                 </div>

                                 <div class="form-group col-12 col-md-3">
                                    <label class="form-label"><?php _e( 'Toevoeging', 'glasbestellen' ); ?>:</label>
                                    <input type="text" name="billing[addition]" class="form-control js-form-validate">
                                 </div>

                                 <div class="form-group js-form-group col-12 col-md-6">
                                    <label class="form-label"><?php _e( 'Postcode', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                                    <input type="text" name="billing[zipcode]" class="form-control js-form-validate" data-required="required">
                                 </div>

                                 <div class="form-group js-form-group col-12 col-md-6">
                                    <label class="form-label"><?php _e( 'Woonplaats', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                                    <input type="text" name="billing[city]" class="form-control js-form-validate" data-required="required">
                                 </div>

                                 <div class="form-group col-12">
                                    <label class="form-check">
                                       <input type="checkbox" class="form-check__input js-toggle-target-trigger" data-toggle-target="#delivery_address_fields">
                                       <span class="form-check__label"><?php _e( 'Wijzig het afleveradres', 'glasbestellen' ); ?></span>
                                    </label>
                                 </div>

                              </div>

                           </fieldset>

                           <div class="d-none" id="delivery_address_fields">

                              <fieldset class="form-section">

                                 <h2 class="h3 h-underlined"><?php _e( 'Afleveradres', 'glasbestellen' ); ?></h2>

                                 <div class="row">

                                    <div class="form-group col-12 col-md-6">
                                       <label class="form-label"><?php _e( 'Land', 'glasbestellen' ); ?>:</label>
                                       <select name="delivery_address[country]" class="dropdown">
                                          <option><?php _e( 'Nederland', 'glasbestellen' ); ?></option>
                                          <option><?php _e( 'Belgi&euml;', 'glasbestellen' ); ?></option>
                                       </select>
                                    </div>

                                    <div class="form-group col-12 col-md-6">
                                       <label class="form-label"><?php _e( 'Straat', 'glasbestellen' ); ?>:</label>
                                       <input name="delivery_address[street]" type="text" class="form-control js-form-validate">
                                    </div>

                                    <div class="form-group col-12 col-md-3">
                                       <label class="form-label"><?php _e( 'Huisnummer', 'glasbestellen' ); ?>:</label>
                                       <input name="delivery_address[number]" type="number" class="form-control js-form-validate">
                                    </div>

                                    <div class="form-group col-12 col-md-3">
                                       <label class="form-label"><?php _e( 'Toevoeging', 'glasbestellen' ); ?>:</label>
                                       <input name="delivery_address[addition]" type="text" class="form-control js-form-validate">
                                    </div>

                                    <div class="form-group col-12 col-md-6">
                                       <label class="form-label"><?php _e( 'Postcode', 'glasbestellen' ); ?>:</label>
                                       <input name="delivery_address[zipcode]" type="text" class="form-control js-form-validate">
                                    </div>

                                    <div class="form-group col-12 col-md-6">
                                       <label class="form-label"><?php _e( 'Woonplaats', 'glasbestellen' ); ?>:</label>
                                       <input name="delivery_address[city]" type="text" class="form-control js-form-validate">
                                    </div>

                                 </div>

                              </fieldset>

                           </div>

                           <fieldset class="form-section">

                              <h2 class="h3 h-underlined"><?php _e( 'Bestelling bevestigen', 'glasbestellen' ); ?></h2>

                              <div class="checkout-form__submit">
                                 <span class="checkout-form__submit-subline space-below"><?php _e( 'U zult worden doorgestuurd naar het betaalscherm van onze betaaldienst.', 'glasbestellen' ); ?></span>
                                 <button type="submit" name="submit_checkout_form" class="btn btn--primary btn--next checkout-form__submit-btn"><?php _e( 'Naar betaalscherm', 'glasbestellen' ); ?></button>
                              </div>

                           </fieldset>

                           <input type="hidden" name="client[remote_address]" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                           <input type="hidden" name="client[gclid]" class="gclid_field">
                           <input type="hidden" name="action" class="js-form-action" value="handle_checkout_form">

                        </form>

                     <?php } else { ?>

                        <div class="text">
                           <p><?php _e( 'Er is niets om af te rekenen.', 'glasbestellen' ); ?></p>
                        </div>

                     <?php } ?>

                  </div>

               </div>

            </div>

            <div class="col-12 col-lg-5">

               <?php if ( $cart->have_items() ) { ?>

                  <div class="layout space-below">

                     <div class="layout__column">

                        <h2 class="h3 h-underlined"><?php _e( 'Bestelling', 'glasbestellen' ); ?></h2>

                        <table class="order-table" width="100%">

                           <?php
                           while ( $cart->have_items() ) {
                              $cart->the_item(); ?>

                              <tbody class="order-table__body">
                                 <tr class="order-table__row">
                                    <td class="order-table__col order-table__col--quantity"><?php echo $cart->get_item_quantity() . 'x'; ?></td>
                                    <td class="order-table__col order-table__col--name"><?php echo $cart->get_item_title(); ?></td>
                                    <td class="order-table__col order-table__col--price"><?php echo Money::display( $cart->get_item_price() ); ?></td>
                                 </tr>
                              </tbody>

                           <?php } ?>

                        </table>

                        <table class="price-table" width="100%">

                           <tbody class="price-table__body">

                              <tr class="price-table__row price-table__row--subtotal">
                                 <td width="20%"></td>
                                 <td class="price-table__col price-table__col--title"><?php _e( 'Subtotaal', 'glasbestellen' ); ?></td>
                                 <td class="price-table__col"><?php echo Money::display( $cart->get_total_price() ); ?></td>
                              </tr>

                              <tr class="price-table__row price-table__row--shipping">
                                 <td width="20%"></td>
                                 <td class="price-table__col price-table__col--title"><?php _e( 'Verzendkosten', 'glasbestellen' ); ?>:</td>
                                 <td class="price-table__col"><?php _e( 'Gratis', 'glasbestellen' ); ?></td>
                              </tr>

                              <tr class="price-table__row price-table__row--total">
                                 <td width="20%"></td>
                                 <td class="price-table__col price-table__col--title"><?php _e( 'Totaal', 'glasbestellen' ); ?>:</td>
                                 <td class="price-table__col"><?php echo Money::display( $cart->get_total_price() ); ?></td>
                              </tr>

                           </tbody>

                        </table>

                     </div>

                  </div>

               <?php } ?>

               <div class="layout space-below">
                  <div class="layout__column">
                     <h2 class="h3 h-underlined"><?php _e( 'Betaal bij ons met', 'glasbestellen' ); ?></h2>
                     <div class="payment-icons">
                        <img src="<?php echo get_template_directory_uri() . '/assets/images/payment-icons.png'; ?>">
                     </div>
                  </div>
               </div>

               <div class="layout">
                  <div class="layout__column text-center">
                     <h2 class="h3"><?php _e( 'Klanttevredenheid is wat ons drijft!', 'glasbestellen' ); ?></h2>
                     <span class="subline space-below"><?php _e( 'Onze klanten beoordelen ons gemiddeld met', 'glasbestellen' ); ?>:</span>

                     <div class="rating rating--checkout">
                        <div class="stars stars--large rating__stars">
                           <?php
                           for ( $i = 1; $i <= 5; $i ++ ) {
                              $checked_class = ( $i <= gb_get_review_average() ) ? 'star--checked' : '';
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

   </main>

   <?php get_footer(); ?>
