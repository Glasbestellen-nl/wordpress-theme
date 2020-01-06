<?php
// Template name: Cart
get_header();
$cart = gb_get_cart(); ?>

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

                     <?php if ( $cart->have_items() ) { ?>

                        <div class="cart-table">

                           <div class="cart-table__body">

                              <?php
                              while ( $cart->have_items() ) {
                                 $cart->the_item(); ?>

                                 <div class="cart-table__row js-cart-item" data-item-id="<?php echo $cart->get_item_id(); ?>">

                                    <?php if ( $cart->get_item_thumbnail() ) { ?>
                                       <div class="cart-table__col cart-table__col--image">
                                          <img src="<?php echo $cart->get_item_thumbnail(); ?>" class="rounded-corners">
                                       </div>
                                    <?php } ?>

                                    <div class="cart-table__col cart-table__col--info">

                                       <h3 class="h4 cart-table__product-title"><?php echo $cart->get_item_title(); ?></h3>

                                       <?php if ( $cart->get_item_summary() ) { ?>

                                          <table class="cart-table__summary" width="100%">

                                             <?php foreach ( $cart->get_item_summary() as $row ) { ?>

                                                <tr class="cart-table__summary-row">
                                                   <td class="cart-table__summary-col cart-table__summary-col--title"><?php echo $row['label']; ?>:</td>
                                                   <td class="cart-table__summary-col"><?php echo $row['value']; ?></td>
                                                </tr>

                                             <?php } ?>

                                          </table>

                                       <?php } ?>

                                    </div>

                                    <div class="cart-table__col cart-table__col--amount">

                                       <select class="cart-table__dropdown cart-table__dropdown--amount dropdown js-quantity-dropdown">
                                          <?php
                                          for ( $i = 1; $i <= 20; $i ++ ) {
                                             echo '<option ' . selected( $i, $cart->get_item_quantity(), false ) . ' value="' . $i . '">' . $i . '</option>';
                                          }
                                          ?>
                                       </select>

                                       <div class="cart-table__delete-trigger"><?php _e( 'Verwijder', 'glasbestellen' ); ?></div>

                                    </div>

                                    <div class="cart-table__col cart-table__col--price"><?php echo Money::display( $cart->get_item_price() ); ?></div>

                                 </div>

                              <?php } ?>

                           </div>

                        </div>

                        <div class="row no-gutters">

                           <div class="col-12 col-lg-4 offset-lg-8">

                              <table class="cart-table-totals" width="100%">

                                 <tbody class="cart-table-totals__body">

                                    <tr class="cart-table-totals__row">
                                       <td class="cart-table-totals__col cart-table-totals__col--title"><?php _e( 'Subtotaal', 'glasbestellen' ); ?></td>
                                       <td class="cart-table-totals__col cart-table-totals__col--value"><?php echo Money::display( $cart->get_total_price(), false ); ?></td>
                                    </tr>

                                    <tr class="cart-table-totals__row--shipping">
                                       <td class="cart-table-totals__col cart-table-totals__col--title"><?php _e( 'Verzendkosten', 'glasbestellen' ); ?></td>
                                       <td class="cart-table-totals__col cart-table-totals__col--value"><?php _e( 'Gratis', 'glasbestellen' ); ?></td>
                                    </tr>

                                    <tr class="cart-table-totals__row--total">
                                       <td class="cart-table-totals__col cart-table-totals__col--title"><?php _e( 'Totaal', 'glasbestellen' ); ?></td>
                                       <td class="cart-table-totals__col cart-table-totals__col--value"><?php echo Money::display( $cart->get_total_price() ); ?></td>
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

                     <?php } ?>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </main>

<?php get_footer(); ?>
