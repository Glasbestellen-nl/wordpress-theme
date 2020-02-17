<?php
// Template name: Configurator layout 1
// Template post type: configurator
get_header();

   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post();
         if ( $configurator = gb_get_configurator( get_the_id() ) ) { ?>

            <main class="main-section main-section--space-around main-section--grey">

               <div class="container">

                  <div class="layout">

                     <div class="layout__column box-shadow">

                        <?php
                        if ( function_exists( 'yoast_breadcrumb' ) ) {
                           yoast_breadcrumb( '<div class="breadcrumbs small-space-below">', '</div>' );
                        }
                        ?>

                        <section class="text">
                           <h1><?php the_title(); ?></h1>
                        </section>

                        <div class="row">

                           <div class="col-12 col-lg-6">

                              <?php if ( $gallery_images = get_field( 'gallery_images' ) ) { ?>

                                 <div class="image-slider space-below js-image-slider">
                                    <div class="image-slider__container image-slider__main">
                                       <div class="image-slider__arrows">
                                          <div class="image-slider__arrow image-slider__arrow--prev js-prev">
                                             <i class="fas fa-chevron-left"></i>
                                          </div>
                                          <div class="image-slider__arrow image-slider__arrow--next js-next">
                                             <i class="fas fa-chevron-right"></i>
                                          </div>
                                       </div>
                                       <img data-src="<?php echo $gallery_images[0]['url']; ?>" class="lazyload image-slider__img image-slider__main-img js-main" alt="<?php echo $gallery_images[0]['alt']; ?>">
                                    </div>

                                    <div class="image-slider__thumbs">

                                       <?php
                                       $index = 0;
                                       foreach ( $gallery_images as $image ) {
                                          $index ++; ?>

                                          <div class="image-slider__container image-slider__thumb js-thumb <?php echo ( $index == 1 ) ? 'current' : ''; ?>">
                                             <img data-src="<?php echo $image['url']; ?>" class="lazyload image-slider__img image-slider__thumb-img" alt="<?php echo $image['alt']; ?>" data-index="<?php echo $index; ?>" data-image="<?php echo $image['url']; ?>">
                                          </div>

                                       <?php } ?>

                                    </div>
                                 </div>

                              <?php } ?>

                           </div>

                           <div class="col-12 col-lg-6">

                              <div class="configurator js-configurator">

                                 <div class="configurator__header large-space-below">

                                    <div class="row">

                                       <div class="col-12">
                                          <span class="h4 configurator__heading"><?php _e( 'Onze aanbieding voor u', 'glasbestellen' ); ?></span>
                                       </div>

                                       <div class="col-4">
                                          <div class="configurator__energy-label">
                                             <img data-src="<?php echo get_template_directory_uri() . '/assets/images/energy-label-a++.png'; ?>" class="lazyload">
                                          </div>
                                       </div>

                                       <div class="col-8">
                                          <div class="configurator__details">
                                             <span class="configurator__detail--price"><?php echo Money::display( $configurator->get_total_price() ); ?></span>
                                             <span class="configurator__detail--tax"><?php _e( 'Prijs incl. BTW.', 'glasbestellen' ); ?></span>
                                             <span class="configurator__detail--delivery">Levertijd 7-14 werkdagen</span>
                                             <span class="configurator__detail--shipping"><i class="fas fa-shipping-fast"></i> <?php _e( 'Gratis verzending', 'glasbestellen' ); ?></span>
                                          </div>
                                       </div>

                                    </div>

                                 </div>

                                 <?php if ( $configurator->have_steps() ) { ?>

                                    <div class="configurator__body">

                                       <div class="space-below">
                                          <span class="h4 configurator__heading"><?php _e( 'Spiegel configureren', 'glasbestellen' ); ?></span>
                                          <p>Verdere informatie klik op het <i class="fas fa-info-circle configurator__info-icon"></i> symbool.</p>
                                       </div>

                                       <div class="configurator__form space-below">

                                          <?php
                                          while ( $configurator->have_steps() ) {
                                             $configurator->the_step(); ?>

                                             <div class="configurator__form-row">
                                                <div class="configurator__form-col configurator__form-info">
                                                   <?php if ( $explanation_id = $configurator->get_step_explanation_id() ) { ?>
                                                      <i class="fas fa-info-circle configurator__info-icon js-popup-explanation" data-explanation-id="<?php echo $explanation_id; ?>"></i>
                                                   <?php } ?>
                                                </div>
                                                <div class="configurator__form-col configurator__form-label">
                                                   <label><?php echo $configurator->get_step_title(); ?></label>
                                                </div>

                                                <?php if ( $configurator->get_step_options() ) { ?>
                                                   <div class="configurator__form-col configurator__form-input">
                                                      <select class="dropdown configurator__form-control">
                                                         <?php if ( $configurator->is_step_required() ) { ?>
                                                            <option value="">---</option>
                                                         <?php }
                                                         foreach ( $configurator->get_step_options() as $option ) {
                                                            echo '<option value="">' . $option['title'] . '</option>';
                                                         }
                                                         ?>
                                                      </select>
                                                   </div>
                                                <?php } else { ?>
                                                   <div class="configurator__form-col configurator__form-input js-form-group">
                                                      <input type="number" class="form-control configurator__form-control js-form-validate" placeholder="mm" data-validation-rules='<?php echo $configurator->get_validation_rules(); ?>' />
                                                      <div class="invalid-feedback js-invalid-feedback"></div>
                                                   </div>
                                                <?php } ?>
                                             </div>

                                          <?php } ?>

                                          <!-- <?php foreach ( ['Spiegel glassoort', 'Lichtkleur', 'LED band', 'Sensor', 'Zijkanten', 'Glazen plankje', 'Klok', 'Spiegelverwarming', 'Stopcontact', 'Bluetooth speaker', 'Make-up spiegel' ] as $label ) { ?>

                                             <div class="configurator__form-row">
                                                <div class="configurator__form-col configurator__form-info">
                                                   <i class="fas fa-info-circle configurator__info-icon"></i>
                                                </div>
                                                <div class="configurator__form-col configurator__form-label">
                                                   <label><?php echo $label ?></label>
                                                </div>
                                                <div class="configurator__form-col configurator__form-input">
                                                   <select class="dropdown configurator__form-control">
                                                      <option>---</option>
                                                   </select>
                                                </div>
                                             </div>

                                          <?php } ?> -->

                                          <div class="configurator__form-row space-below">
                                             <div class="configurator__form-col configurator__form-label">
                                                <label><?php _e( 'Aantal', 'glasbestellen' ) ?></label>
                                             </div>
                                             <div class="configurator__form-col configurator__form-input">
                                                <select class="dropdown configurator__form-control">
                                                   <option>1</option>
                                                </select>
                                             </div>
                                          </div>

                                          <div class="configurator__form-button space-below">
                                             <button class="btn btn--primary btn--block btn--next"><?php _e( 'In winkelwagen', 'glasbestellen' ); ?></button>
                                          </div>

                                          <ul class="configurator__checks">
                                             <li class="configurator__checks-item"><?php echo '<strong>' . __( 'Bestel check', 'glasbestellen' ) . ':</strong> ' . __( 'Elke bestelling wordt gecontroleerd op volledigheid.', 'glasbestellen' ); ?></li>
                                          </ul>

                                       </div>

                                    </div>

                                 <?php } ?>

                              </div>

                           </div>

                        </div>

                     </div>

                  </div>

               </div>

            </main>

         <?php } ?>

      <?php } ?>

   <?php } ?>

<?php get_footer(); ?>
