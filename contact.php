<?php
get_header();
// Template name: Contact
?>

   <main class="main-section main-section--space-around main-section--grey">

      <div class="container">

         <div class="row">

            <div class="col-12">

               <section class="text page-header">
                  <?php
                  if ( have_posts() ) {
                     while ( have_posts() ) {
                        the_title( '<h1 class="h1">', '</h1>' );
                        the_post();
                        the_content();
                     }
                  }
                  ?>
               </section>

            </div>

         </div>

         <div class="layout layout--outstanding">

            <div class="row">

               <div class="col-12 col-lg-8">

                  <div id="react_lead_form"></div>

                  <?php get_template_part( 'template-parts/form-hidden-fields' ); ?>

               </div>

               <div class="col-12 col-lg-4">

                  <section class="layout__column layout__column--right layout__column--bg">

                     <div class="row">

                        <div class="col-12 col-md-6 col-lg-12">
                           <div class="space-below">
                              <img src="<?php echo get_template_directory_uri() . '/assets/images/glasbestellen-kantoor.jpg'; ?>" class="rounded-corners box-shadow--dark">
                           </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-12">
                           <strong class="h3 h-orange"><?php bloginfo( 'name' ); ?></strong>
                           <ul class="contact-details--dark-bg space-below">
                              <li class="contact-details__item"><?php echo get_option( 'company_street' ) . ' ' . get_option( 'company_number' ); ?></li>
                              <li class="contact-details__item"><?php echo get_option( 'company_zipcode' ) . ', ' . get_option( 'company_city' ); ?></li>
                              <li class="contact-details__item"><i class="fas fa-phone-alt contact-detail__icon"></i> <a href="tel:<?php echo get_option( 'company_phone_number' ); ?>"><?php echo get_option( 'company_phone_number' ); ?></a></li>
                              <li class="contact-details__item"><i class="fas fa-envelope contact-detail__icon"></i> <a href="mailto:<?php echo get_option( 'company_email' ); ?>"><?php echo get_option( 'company_email' ); ?></a></li>
                              <li class="contact-details__item"><?php echo get_option( 'company_coc_number' ); ?></li>
                              <li class="contact-details__item"><?php echo get_option( 'company_vat_number' ); ?></li>
                           </ul>
                           <strong class="h3 h-orange"><?php _e( 'Openingstijden', 'glasbestellen' ); ?></strong>
                           <ul class="contact-details--dark-bg">
                              <li class="contact-details__item"><?php echo __( 'Maandag', 'glasbestellen' ) . ' - ' . __( 'Donderdag', 'glasbestellen' ) . ': 09:00 - 17:00'; ?></li>
                              <li class="contact-details__item"><?php echo __( 'Vrijdag', 'glasbestellen' ) . ': 09:00 - 16:00'; ?></li>
                           </ul>
                        </div>

                     </div>

                  </section>

               </div>

            </div>

         </div>

      </div>

   </main>


<?php get_footer(); ?>
