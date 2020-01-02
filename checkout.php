<?php
// Template name: Checkout
get_header(); ?>

   <main class="main-section main-section--grey">

      <div class="container">

         <ol class="step-indicator step-indicator--done-2">
            <li class="step-indicator__step step-indicator__step--done">
               <div class="step-indicator__step-number">1</div>
               <span class="step-indicator__step-text">Winkelwagen</span>
            </li>
            <li class="step-indicator__step step-indicator__step--done">
               <div class="step-indicator__step-number">2</div>
               <span class="step-indicator__step-text">Gegevens</span>
            </li>
            <li class="step-indicator__step">
               <div class="step-indicator__step-number">3</div>
               <span class="step-indicator__step-text">Betalen</span>
            </li>
            <li class="step-indicator__step">
               <div class="step-indicator__step-number">4</div>
               <span class="step-indicator__step-text">Afronden</span>
            </li>
         </ol>

         <div class="row">

            <div class="col-12 col-lg-7">

               <div class="layout layout--outstanding space-below">

                  <div class="layout__column">

                     <form class="form checkout-form">

                        <fieldset class="form-section">

                           <h2 class="h3 h-underlined">Klantgegevens</h2>

                           <div class="form-group">
                              <div class="form-check form-check--inline">
                                 <input type="radio" class="form-check__input">
                                 <label class="form-check__label">Particulier</label>
                              </div>
                              <div class="form-check form-check--inline">
                                 <input type="radio" class="form-check__input" checked>
                                 <label class="form-check__label">Zakelijk</label>
                              </div>
                           </div>

                           <div class="row additional-fields">

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Bedrijfsnaam:</label>
                                 <input type="text" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Referentie:</label>
                                 <input type="text" class="form-control">
                              </div>

                           </div>

                           <div class="row">

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Voornaam: <span class="req">*</span></label>
                                 <input type="text" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Achternaam: <span class="req">*</span></label>
                                 <input type="text" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">E-mail: <span class="req">*</span></label>
                                 <input type="email" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Telefoonnummer: <span class="req">*</span></label>
                                 <input type="tel" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Land: <span class="req">*</span></label>
                                 <select class="dropdown">
                                    <option>Nederland</option>
                                 </select>
                              </div>

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Straat: <span class="req">*</span></label>
                                 <input type="text" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-3">
                                 <label class="form-label">Huisnummer: <span class="req">*</span></label>
                                 <input type="number" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-3">
                                 <label class="form-label">Toevoeging:</label>
                                 <input type="text" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Postcode: <span class="req">*</span></label>
                                 <input type="text" class="form-control">
                              </div>

                              <div class="form-group col-12">
                                 <div class="form-check">
                                    <input type="checkbox" class="form-check__input">
                                    <label class="form-check__label">Wijzig het afleveradres</label>
                                 </div>
                              </div>

                           </div>

                        </fieldset>

                        <fieldset class="form-section">

                           <h2 class="h3 h-underlined">Afleveradres</h2>

                           <div class="row">

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Land: <span class="req">*</span></label>
                                 <select class="dropdown">
                                    <option>Nederland</option>
                                 </select>
                              </div>

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Straat: <span class="req">*</span></label>
                                 <input type="text" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-3">
                                 <label class="form-label">Huisnummer: <span class="req">*</span></label>
                                 <input type="number" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-3">
                                 <label class="form-label">Toevoeging:</label>
                                 <input type="text" class="form-control">
                              </div>

                              <div class="form-group col-12 col-md-6">
                                 <label class="form-label">Postcode: <span class="req">*</span></label>
                                 <input type="text" class="form-control">
                              </div>

                           </div>

                        </fieldset>

                        <fieldset class="form-section">

                           <h2 class="h3 h-underlined">Bestelling bevestigen</h2>

                           <div class="checkout-form__submit">
                              <span class="checkout-form__submit-subline space-below">U zult worden doorgestuurd naar het betaalscherm van onze betaaldienst.</span>
                              <button class="btn btn--primary btn--next checkout-form__submit-btn">Naar betaalscherm</button>
                           </div>

                        <fieldset>

                     </form>

                  </div>

               </div>

            </div>

            <div class="col-12 col-lg-5">

               <div class="layout space-below">

                  <div class="layout__column">

                     <h2 class="h3 h-underlined">Bestelling</h2>

                     <table class="order-table" width="100%">

                        <tbody class="order-table__body">
                           <tr class="order-table__row">
                              <td class="order-table__col order-table__col--quantity">1x</td>
                              <td class="order-table__col order-table__col--name">Douchedeur</td>
                              <td class="order-table__col order-table__col--price">&euro;00,00</td>
                           </tr>
                        </tbody>

                     </table>

                     <table class="price-table" width="100%">

                        <tbody class="price-table__body">

                           <tr class="price-table__row price-table__row--subtotal">
                              <td width="20%"></td>
                              <td class="price-table__col price-table__col--title">Subtotaal</td>
                              <td class="price-table__col">&euro;00,00</td>
                           </tr>

                           <tr class="price-table__row price-table__row--shipping">
                              <td width="20%"></td>
                              <td class="price-table__col price-table__col--title">Verzendkosten:</td>
                              <td class="price-table__col">&euro;00,00</td>
                           </tr>

                           <tr class="price-table__row price-table__row--total">
                              <td width="20%"></td>
                              <td class="price-table__col price-table__col--title">Totaal:</td>
                              <td class="price-table__col">&euro;00,00</td>
                           </tr>

                        </tbody>

                     </table>

                  </div>

               </div>

               <div class="layout space-below">
                  <div class="layout__column">
                     <h2 class="h3 h-underlined">Betaal bij ons met</h2>
                     <div class="payment-icons">
                        <img src="<?php echo get_template_directory_uri() . '/assets/images/payment-icons.png'; ?>">
                     </div>
                  </div>
               </div>

               <div class="layout">
                  <div class="layout__column text-center">
                     <h2 class="h3">Klanttevredenheid is wat ons drijft!</h2>
                     <span class="subline space-below">Onze klanten beoordelen ons gemiddeld met:</span>

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
