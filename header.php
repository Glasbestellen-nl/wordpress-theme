<?php get_template_part( 'template-parts/head' ); ?>

   <header class="main-header">

      <div class="header-top">

         <div class="container">

            <div class="header-top__inner">

               <div class="header-top__inline d-md-none">
                  <a href="tel:<?php echo get_option( 'company_phone_number' ); ?>" class="header-top__inline-item header-top__inline-item--first">
                     <div class="header-top__inline-item-icon"><i class="fas fa-phone-alt"></i></div> <?php echo get_option( 'company_phone_number' ); ?>
                  </a>
                  <a href="mailto:<?php echo get_option( 'company_email' ); ?>" class="header-top__inline-item">
                     <div class="header-top__inline-item-icon"><i class="fas fa-envelope"></i></div> <?php echo get_option( 'company_email' ); ?>
                  </a>
               </div>

               <a href="<?php echo gb_get_cart_url(); ?>" class="header-top__cart">
                  <i class="fas fa-shopping-cart header-top__cart-icon"></i>
                  <span class="header-top__cart-number js-total-cart-quantity">0</span>
               </a>

            </div>

         </div>

      </div>

      <div class="header-inner">

         <div class="container">

            <div class="row">

               <div class="col-md-4 col-lg-6">

                  <a href="<?php echo home_url(); ?>" class="site-logo header-inner__logo">
                     <img data-src="<?php echo get_template_directory_uri() . '/assets/images/logo.png'; ?>" class="lazyload site-logo__image" alt="Logo">
                     <span class="site-logo__slogan"><?php bloginfo( 'description' ); ?></span>
                  </a>

               </div>

               <div class="col-md-8 col-lg-6 d-none d-md-block">

                  <div class="header-inner__contact-options">

                     <a href="mailto:<?php echo get_option( 'company_email' ); ?>" class="contact-option contact-option--email" target="_blank">
                        <div class="contact-option__icon"></div>
                        <div class="contact-option__text">
                           <span class="contact-option__headline"><?php _e( 'Stuur ons een email', 'glasbestellen' ); ?></span>
                           <span class="contact-option__subline"><?php echo get_option( 'company_email' ); ?></span>
                        </div>
                     </a>

                     <a href="tel:<?php echo str_replace( ' ', '', get_option( 'company_phone_number' ) ); ?>" class="contact-option contact-option--phone" target="_blank">
                        <div class="contact-option__icon"></div>
                        <div class="contact-option__text">
                           <span class="contact-option__headline"><?php _e( 'Bel ons gerust', 'glasbestellen' ); ?></span>
                           <span class="contact-option__subline"><?php echo get_option( 'company_phone_number' ); ?></span>
                        </div>
                     </a>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </header>

   <?php if ( $show_nav = apply_filters( 'gb_show_main_nav', true ) ) {  ?>

      <nav class="main-nav">

         <div class="container">

            <div class="main-nav__toggler main-nav__toggler js-nav-toggler">
               <span class="main-nav__toggler-button"><?php _e( 'Menu', 'glasbestellen' ); ?></span>
            </div>

            <?php gb_render_main_nav(); ?>

         </div>

      </nav>

   <?php } ?>
