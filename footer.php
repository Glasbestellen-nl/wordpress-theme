
   <footer class="main-footer">

      <div class="footer-top">

         <div class="container">

            <div class="footer-rating">
               <div class="footer-rating__text"><?php _e( 'Onze klanten beoordelen ons gemiddeld met', 'glasbestellen' ); ?>:</div>
               <div class="rating rating--footer">
                  <div class="stars rating__stars">
                     <?php
                     for ( $i = 1; $i <= 5; $i ++ ) {
                        $checked_class = ( $i <= gb_get_review_average( false, null, 0 ) ) ? 'star--checked' : '';
                        echo '<div class="fas fa-star star ' . $checked_class . '"></div> ';
                     }
                     ?>
                  </div>
                  <div class="rating__number"><?php echo gb_get_review_average( true ); ?></div>
               </div>
            </div>

         </div>

      </div>

      <div class="footer-inner">

         <div class="container">

            <div class="row">

               <div class="col-xs-12 col-lg">

                  <div class="footer-inner__column">
                     <span class="h3 footer-heading"><?php _e( 'Contact', 'glasbestellen' ); ?></span>
                     <ul class="footer-list">
                        <li class="footer-list__item"><?php echo get_option( 'company_street' ) . ' ' . get_option( 'company_number' ); ?></li>
                        <li class="footer-list__item"><?php echo get_option( 'company_zipcode' ) . ', ' . get_option( 'company_city' ); ?></li>
                        <li class="footer-list__item">T: <?php echo get_option( 'company_phone_number' ); ?></li>
                        <li class="footer-list__item">E: <?php echo get_option( 'company_email' ); ?></li>
                     </ul>

                     <div class="social-icons social-icons--footer">
                        <?php
                        foreach ( ['facebook', 'twitter', 'pinterest', 'instagram'] as $social_network ) {
                           if ( $url = get_option( 'company_' . $social_network . '_url' ) ) {
                              echo '<a href="' . $url . '" class="social-icon fab fa-' . $social_network . '" target="_blank"></a>';
                           }
                        }
                        ?>
                     </div>

                  </div>

               </div>

               <div class="col-xs-12 col-lg">

                  <div class="footer-inner__column">
                     <span class="h3 footer-heading"><?php _e( 'Klantenservice', 'glasbestellen' ); ?></span>
                     <?php if ( $footer_menu_1 = get_nav_menu_items_by_location( 'footer_menu_1' ) ) { ?>
                        <ul class="footer-list">
                           <?php foreach ( $footer_menu_1 as $menu_item ) { ?>
                              <li class="footer-list__item">
                                 <a href="<?php echo $menu_item->url; ?>" class="footer-list__link"><?php echo $menu_item->title; ?></a>
                              </li>
                           <?php } ?>
                        </ul>
                     <?php } ?>

                  </div>

               </div>

               <div class="col-xs-12 col-lg">

                  <div class="footer-inner__column">
                     <span class="h3 footer-heading"><?php _e( 'Deuren', 'glasbestellen' ); ?></span>

                     <?php if ( $footer_menu_2 = get_nav_menu_items_by_location( 'footer_menu_2' ) ) { ?>
                        <ul class="footer-list">
                           <?php foreach ( $footer_menu_2 as $menu_item ) { ?>
                              <li class="footer-list__item">
                                 <a href="<?php echo $menu_item->url; ?>" class="footer-list__link"><?php echo $menu_item->title; ?></a>
                              </li>
                           <?php } ?>
                        </ul>
                     <?php } ?>

                  </div>

               </div>

               <div class="col-xs-12 col-lg">

                  <div class="footer-inner__column">
                     <span class="h3 footer-heading"><?php _e( 'Wanden', 'glasbestellen' ); ?></span>

                     <?php if ( $footer_menu_3 = get_nav_menu_items_by_location( 'footer_menu_3' ) ) { ?>
                        <ul class="footer-list">
                           <?php foreach ( $footer_menu_3 as $menu_item ) { ?>
                              <li class="footer-list__item">
                                 <a href="<?php echo $menu_item->url; ?>" class="footer-list__link"><?php echo $menu_item->title; ?></a>
                              </li>
                           <?php } ?>
                        </ul>
                     <?php } ?>

                  </div>

               </div>

               <div class="col-xs-12 col-lg">

                  <div class="footer-inner__column">
                     <span class="h3 footer-heading"><?php _e( 'Speciaal glas', 'glasbestellen' ); ?></span>

                     <?php if ( $footer_menu_4 = get_nav_menu_items_by_location( 'footer_menu_4' ) ) { ?>
                        <ul class="footer-list">
                           <?php foreach ( $footer_menu_4 as $menu_item ) { ?>
                              <li class="footer-list__item">
                                 <a href="<?php echo $menu_item->url; ?>" class="footer-list__link"><?php echo $menu_item->title; ?></a>
                              </li>
                           <?php } ?>
                        </ul>
                     <?php } ?>

                  </div>

               </div>

            </div>

         </div>

      </div>

      <div class="footer-bottom">

         <div class="container">

            <div class="footer-bottom__inner">

               <div class="payment-icons payment-icons--footer">
                  <img src="<?php echo get_template_directory_uri() . '/assets/images/payment-icons.png'; ?>" alt="<?php _e( 'Betaal logo\'s', 'glasbestellen' ); ?>">
               </div>

                  <ul class="footer-bottom__inline">

                     <li class="footer-bottom__inline-item"><?php echo __( 'Copyright', 'glasbestellen' ) . ' &copy; ' . date( 'Y' ) . ' ' .  get_bloginfo( 'name' ); ?></li>

                     <?php
                     if ( $footer_menu_5 = get_nav_menu_items_by_location( 'footer_menu_5' ) ) {
                        foreach ( $footer_menu_5 as $menu_item ) { ?>

                           <li class="footer-bottom__inline-item">
                              &middot;
                              <a href="<?php echo $menu_item->url; ?>" class="footer-bottom__inline-link"><?php echo $menu_item->title; ?></a>
                           </li>

                        <?php } ?>

                     <?php } ?>

                  </ul>

            </div>

         </div>
      </div>

   </footer>

<?php get_template_part( 'template-parts/foot' ); ?>
