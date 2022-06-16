<?php get_template_part( 'template-parts/head' ); ?>

   <?php if ( $message = get_option( 'site_message' ) ) { ?>
      <div class="top-bar">
         <div class="container">
            <span class="top-bar__message"><?php echo $message; ?></span>
         </div>
      </div>
   <?php } ?>

   <header class="main-header">

      <div class="header-inner">

         <div class="container">

            <div class="row">

               <div class="col-8 col-md-4 col-lg-3">

                  <a href="<?php echo home_url(); ?>" class="site-logo header-inner__logo">
                     <img src="<?php echo get_template_directory_uri() . '/assets/images/logo.png'; ?>" class="site-logo__image" alt="Logo">
                     <span class="site-logo__slogan"><?php bloginfo( 'description' ); ?></span>
                  </a>

               </div>

               <div class="col-12 col-lg-5 offset-lg-3 d-none d-lg-block">

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

               <div class="col-4 col-lg-1 offset-md-4 offset-lg-0 d-flex">
                  <div class="header-inner__cart">
                     <a href="<?php echo wc_get_cart_url(); ?>" class="cart-button btn--aside cart-customlocation">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-button__quantity"><?php echo WC()->cart->cart_contents_count; ?></span>
                     </a>
                  </div>
               </div>

            </div>

         </div>

      </div>

   </header>

   <?php if ( $show_nav = apply_filters( 'gb_show_main_nav', true ) ) {  ?>

      <nav class="main-nav">

         <div class="container main-nav__container">

            <div class="main-nav__toggler main-nav__toggler js-nav-toggler">
               <span class="main-nav__toggler-button"><?php _e( 'Menu', 'glasbestellen' ); ?></span>
            </div>

            <?php gb_render_main_nav(); ?>

            <a href="tel:<?php echo str_replace( ' ', '', get_option( 'company_phone_number' ) ); ?>" class="main-nav__phone d-lg-none">
               <i class="fas fa-phone-alt main-nav__cart-icon"></i>
               <?php echo get_option( 'company_phone_number' ); ?>
            </a>

         </div>

      </nav>

   <?php } ?>
