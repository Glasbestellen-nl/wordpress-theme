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

                  <form method="post" enctype="multipart/form-data" class="layout__column js-form-validation" novalidate>

                     <p class="js-error-alert alert alert--danger" style="display: none;"></p>

                     <div class="form-group js-form-group">
                        <label class="form-label"><?php _e( 'Beschrijf uw wensen en uw situatie', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                        <textarea name="lead[content]" class="form-control js-form-validate" data-required="required" rows="6" placeholder="Beschrijf uw wensen en uw situatie"></textarea>
                        <div class="invalid-feedback js-invalid-feedback"></div>
                     </div>

                     <div class="form-group js-form-group">
                        <div class="file-input">
                           <label for="lead_files_field" class="file-input__trigger js-file-input-trigger">
                              <span class="fas fa-upload file-input__icon"></span>
                              <span class="file-input__text js-file-input-trigger-text"><?php _e( 'Upload een foto of tekening', 'glasbestellen' ); ?></span>
                           </label>
                           <input type="file" class="file-input__field js-file-input-field" id="lead_files_field" multiple>
                        </div>
                     </div>

                     <div class="row">

                        <div class="form-group js-form-group col-12 col-md-6">
                           <label class="form-label"><?php _e( 'Naam', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                           <input type="text" name="lead[name]" class="form-control js-form-validate" data-required="required" placeholder="<?php _e( 'Naam', 'glasbestellen' ); ?>" />
                           <div class="invalid-feedback js-invalid-feedback"></div>
                        </div>

                        <div class="form-group js-form-group col-12 col-md-6">
                           <label class="form-label"><?php _e( 'E-mail', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                           <input type="email" name="lead[email]" class="form-control js-form-validate" data-required="required" placeholder="<?php _e( 'E-mail', 'glasbestellen' ); ?>" />
                           <div class="invalid-feedback js-invalid-feedback"></div>
                        </div>

                        <div class="form-group js-form-group col-12 col-md-6">
                           <label class="form-label"><?php _e( 'Woonplaats', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                           <input type="text" name="lead[residence]" class="form-control js-form-validate" data-required="required" placeholder="<?php _e( 'Woonplaats', 'glasbestellen' ); ?>" />
                           <div class="invalid-feedback js-invalid-feedback"></div>
                        </div>

                        <div class="form-group js-form-group col-12 col-md-6">
                           <label class="form-label"><?php _e( 'Telefoonnummer', 'glasbestellen' ); ?>:</label>
                           <input type="phone" name="lead[phone]" class="form-control js-form-validate" placeholder="<?php _e( 'Telefoonnummer', 'glasbestellen' ); ?>" />
                        </div>

                        <div class="col-12">
                           <button class="btn btn--primary btn--next float-right" type="submit"><?php _e( 'Verstuur', 'glasbestellen' ); ?></button>
                        </div>

                        <?php get_template_part( 'template-parts/form-hidden-fields' ); ?>

                     </div>

                  </form>

               </div>

               <div class="col-12 col-lg-4">

                  <section class="layout__column layout__column--right layout__column--bg">

                     <div class="row">

                        <div class="col-12 col-md-6 col-lg-12">
                           <div class="space-below">
                              <img data-src="<?php echo get_template_directory_uri() . '/assets/images/glasbestellen-kantoor.jpeg'; ?>" class="lazyload rounded-corners box-shadow--dark">
                           </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-12">
                           <strong class="h3 h-orange"><?php bloginfo( 'name' ); ?></strong>
                           <ul class="contact-details--dark-bg space-below">
                              <li class="contact-details__item"><?php echo get_option( 'company_street' ) . ' ' . get_option( 'company_number' ); ?></li>
                              <li class="contact-details__item"><?php echo get_option( 'company_zipcode' ) . ', ' . get_option( 'company_city' ); ?></li>
                              <li class="contact-details__item"><i class="fas fa-phone-alt contact-detail__icon"></i> <?php echo get_option( 'company_phone_number' ); ?></li>
                              <li class="contact-details__item"><i class="fas fa-envelope contact-detail__icon"></i> <?php echo get_option( 'company_email' ); ?></li>
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
