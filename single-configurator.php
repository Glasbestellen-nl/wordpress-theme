<?php get_header(); ?>

   <?php
   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post();
         if ( $configurator = gb_get_configurator( get_the_id() ) ) {
         ?>

            <div class="container">

               <div class="layout layout--outstanding layout--borderless space-below">

                  <div class="row">

                     <div class="col-12 col-lg-7 col-xl-8">

                        <div class="layout__column">

                           <header class="space-below">
                              <h1 class="h2"><?php echo sprintf( __( 'Vul onderstaande stappen in om uw %s samen te stellen.', 'glasbestellen' ), strtolower( get_the_title() ) ); ?></h1>
                           </header>

                           <div class="v-steps js-v-steps">

                              <?php require_once( TEMPLATEPATH . '/template-parts/configurator/steps.php' ); ?>

                           </div>

                        </div>

                     </div>

                     <div class="col-12 col-lg-5 col-xl-4">

                        <div class="layout__column layout__column--right layout__column--bg">

                           <div class="config-details sticky">

                              <div class="row d-flex align-items-center">

                                 <div class="col-4 col-md-5 col-lg-12">

                                    <div class="config-details__image space-below">
                                       <a href="<?php echo get_the_post_thumbnail_url( get_the_id(), 'large' ); ?>">
                                          <img src="<?php echo get_the_post_thumbnail_url( get_the_id(), 'large' ); ?>">
                                       </a>
                                    </div>

                                 </div>

                                 <div class="col-8 col-md-6 offset-md-1 offset-lg-0 col-lg-12">

                                    <div class="config-details__about space-below">
                                       <span class="config-details__subline"><?php _e( 'Uw startopstelling', 'glasbestelle' ); ?>:</span>
                                       <h3 class="h3 config-details__headline"><?php the_title(); ?></h3>
                                    </div>

                                 </div>

                              </div>

                              <div class="config-details__totals space-below">
                                 <span class="config-details__totals-label"><?php _e( 'Totaal incl. BTW.', 'glasbestellen' ); ?></span>
                                 <span class="config-details__totals-price js-config-total-price"><?php echo Money::display( $configurator->get_total_price() ); ?></span>
                              </div>

                              <div class="config-details__submit-button space-below">
                                 <button class="btn btn--tertiary btn--block btn--next js-configurator-to-cart"><?php _e( 'In winkelwagen', 'glasbestellen' ); ?></button>
                              </div>

                              <ul class="config-details__checkmarks">
                                 <li class="config-details__checkmark">Nu gratis verzending</li>
                                 <li class="config-details__checkmark">Ongeveer 2 weken levertijd</li>
                                 <li class="config-details__checkmark">Laten plaatsen? Geen probleem!</li>
                              </ul>

                           </div>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

         <?php } ?>

      <?php } ?>

   <?php } ?>

<?php get_template_part( 'template-parts/foot' ); ?>
