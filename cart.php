<?php
// Template name: Cart
get_header(); ?>

   <main class="main-section main-section--space-around main-section--grey">

      <div class="container">

         <ol class="step-indicator step-indicator--done-1">
            <li class="step-indicator__step step-indicator__step--done">
               <div class="step-indicator__step-number">1</div>
               <span class="step-indicator__step-text"><?php _e( 'Winkelwagen', 'glasbestellen' ); ?></span>
            </li>
            <li class="step-indicator__step">
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

            <div class="col">

               <div class="layout layout--outstanding">

                  <div class="layout__column">

                     <h1 class="h1"><?php _e( 'Winkelwagen', 'glasbestellen' ); ?></h1>

                     <div class="cart-table">

                        <div class="cart-table__body">

                           <div class="cart-table__row">

                              <div class="cart-table__col cart-table__col--image">
                                 <img src="https://www.glasbestellen.nl/wp-content/uploads/2019/06/startopstelling-enkele-douchedeur.jpg" class="rounded-corners">
                              </div>

                              <div class="cart-table__col cart-table__col--info">

                                 <h3 class="h4 cart-table__product-title">Dubbele douchedeur</h3>

                                 <table class="cart-table__summary" width="100%">
                                    <tr class="cart-table__summary-row">
                                       <td class="cart-table__summary-col cart-table__summary-col--title">Draairichting:</td>
                                       <td class="cart-table__summary-col">Linksdraaiend</td>
                                    </tr>
                                    <tr class="cart-table__summary-row">
                                       <td class="cart-table__summary-col cart-table__summary-col--title">Afmetingen opening:</td>
                                       <td class="cart-table__summary-col">800mm x 1800mm</td>
                                    </tr>
                                    <tr class="cart-table__summary-row">
                                       <td class="cart-table__summary-col cart-table__summary-col--title">Glasmaten:</td>
                                       <td class="cart-table__summary-col">794mm x 1795mm</td>
                                    </tr>
                                    <tr class="cart-table__summary-row">
                                       <td class="cart-table__summary-col cart-table__summary-col--title">Glassoort:</td>
                                       <td class="cart-table__summary-col">8mm Helder glas</td>
                                    </tr>
                                    <tr class="cart-table__summary-row">
                                       <td class="cart-table__summary-col cart-table__summary-col--title">Scharnieren:</td>
                                       <td class="cart-table__summary-col">Scharnier Basic Chroom</td>
                                    </tr>
                                    <tr class="cart-table__summary-row">
                                       <td class="cart-table__summary-col cart-table__summary-col--title">Deuropener:</td>
                                       <td class="cart-table__summary-col">Knop Basic Chroom</td>
                                    </tr>
                                 </table>

                              </div>

                              <div class="cart-table__col cart-table__col--amount">

                                 <select class="cart-table__dropdown cart-table__dropdown--amount dropdown">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                 </select>

                                 <div class="cart-table__delete-trigger"><?php _e( 'Verwijder', 'glasbestellen' ); ?></div>

                              </div>

                              <div class="cart-table__col cart-table__col--price">€337,00</div>

                           </div>

                        </div>

                     </div>

                     <div class="row no-gutters">

                        <div class="col-12 col-lg-4 offset-lg-8">

                           <table class="cart-table-totals" width="100%">

                              <tbody class="cart-table-totals__body">

                                 <tr class="cart-table-totals__row">
                                    <td class="cart-table-totals__col cart-table-totals__col--title"><?php _e( 'Subtotaal', 'glasbestellen' ); ?></td>
                                    <td class="cart-table-totals__col cart-table-totals__col--value">00,00</td>
                                 </tr>

                                 <tr class="cart-table-totals__row--shipping">
                                    <td class="cart-table-totals__col cart-table-totals__col--title"><?php _e( 'Verzendkosten', 'glasbestellen' ); ?></td>
                                    <td class="cart-table-totals__col cart-table-totals__col--value">Gratis</td>
                                 </tr>

                                 <tr class="cart-table-totals__row--total">
                                    <td class="cart-table-totals__col cart-table-totals__col--title"><?php _e( 'Totaal', 'glasbestellen' ); ?></td>
                                    <td class="cart-table-totals__col cart-table-totals__col--value">00,00</td>
                                 </tr>

                                 <tr class="cart-table-totals__row">
                                    <td class="cart-table-totals__col" colspan="2">
                                       <a href="<?php echo get_permalink( get_page_id_by_template( 'checkout.php' ) ); ?>" class="btn btn--primary btn--block btn--next">Verder naar bestellen</a>
                                    </td>
                                 </tr>

                              </tbody>

                           </table>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </main>

<?php get_footer(); ?>
