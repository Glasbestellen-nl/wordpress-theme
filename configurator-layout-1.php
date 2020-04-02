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

                        <div class="row large-space-below">

                           <div class="col-12 col-lg-6">

                              <?php if ( $gallery_images = get_field( 'gallery_images' ) ) { ?>

                                 <div class="image-slider large-space-below js-image-slider">
                                    <div class="image-slider__container image-slider__main">
                                       <?php if ( count( $gallery_images ) > 1 ) { ?>
                                          <div class="image-slider__arrows">
                                             <div class="image-slider__arrow image-slider__arrow--prev js-prev">
                                                <i class="fas fa-chevron-left"></i>
                                             </div>
                                             <div class="image-slider__arrow image-slider__arrow--next js-next">
                                                <i class="fas fa-chevron-right"></i>
                                             </div>
                                          </div>
                                       <?php } ?>
                                       <a href="<?php echo $gallery_images[0]['url']; ?>" class="fancybox" title="<?php echo $gallery_images[0]['title']; ?>">
                                          <img data-src="<?php echo $gallery_images[0]['url']; ?>" class="lazyload image-slider__img image-slider__main-img js-main" alt="<?php echo $gallery_images[0]['alt']; ?>">
                                       </a>
                                    </div>

                                    <div class="image-slider__thumbs">

                                       <?php
                                       $index = 0;
                                       foreach ( $gallery_images as $image ) {
                                          $index ++; ?>
                                          <div class="image-slider__container image-slider__thumb js-thumb <?php echo ( $index == 1 ) ? 'current' : ''; ?>">
                                             <img data-src="<?php echo $image['sizes']['medium']; ?>" class="lazyload image-slider__img image-slider__thumb-img" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>" data-index="<?php echo $index; ?>" data-image="<?php echo $image['url']; ?>">
                                          </div>

                                       <?php } ?>

                                    </div>
                                 </div>

                              <?php } ?>

                              <ul class="links-list large-space-below">

                                 <?php if ( $assembly_file_url = get_field( 'assembly_instruction' ) ) { ?>
                                    <li class="links-list__item"><i class="fas fa-wrench links-list__icon"></i> <a href="<?php echo $assembly_file_url; ?>" class="links-list__link" rel="nofollow" target="_blank"><?php _e( 'Montageinstructie', 'glasbestellen' ); ?></a></li>
                                 <?php } ?>
                                 <?php if ( $assembly_video_url = get_field( 'assembly_video' ) ) { ?>
                                    <li class="links-list__item"><i class="fab fa-youtube links-list__icon"></i> <a href="<?php echo $assembly_video_url; ?>" class="links-list__link fancybox-various fancybox.iframe"><?php _e( 'Montagevideo', 'glasbestellen' ); ?></a></li>
                                 <?php } ?>
                                 <?php if ( $fittings_file_url = get_field( 'fittings_info' ) ) { ?>
                                    <li class="links-list__item"><i class="fas fa-info-circle links-list__icon"></i> <a href="<?php echo $fittings_file_url; ?>" class="links-list__link" rel="nofollow" target="_blank"><?php _e( 'Beslag informatie', 'glasbestellen' ); ?></a></li>
                                 <?php } ?>
                              </ul>

                           </div>

                           <div class="col-12 col-lg-6">

                              <div class="configurator js-configurator">

                                 <div class="configurator__header large-space-below">

                                    <div class="row">

                                       <div class="col-12 col-md-6">
                                          <span class="h4 configurator__heading"><?php _e( 'Onze aanbieding voor u', 'glasbestellen' ); ?></span>

                                          <!-- <div class="configurator__energy-label">
                                             <img data-src="<?php echo get_template_directory_uri() . '/assets/images/energy-label-a++.png'; ?>" class="lazyload">
                                          </div> -->

                                       </div>

                                       <div class="col-12 col-md-6">
                                          <div class="configurator__details">
                                             <span class="configurator__detail--price js-config-total-price"><?php echo Money::display( $configurator->get_total_price() ); ?></span>
                                             <span class="configurator__detail--tax"><?php _e( 'Prijs incl. BTW.', 'glasbestellen' ); ?></span>
                                             <?php if ( $delivery_time = $configurator->get_setting( 'delivery_time' ) ) { ?>
                                                <span class="configurator__detail--delivery"><?php echo sprintf( __( 'Levertijd %s', 'glasbestellen' ), $delivery_time ); ?></span>
                                             <?php } ?>
                                             <span class="configurator__detail--shipping"><i class="fas fa-shipping-fast"></i> <?php _e( 'Gratis verzending', 'glasbestellen' ); ?></span>
                                          </div>
                                       </div>

                                    </div>

                                 </div>

                                 <?php if ( $configurator->have_steps() ) { ?>

                                    <div class="configurator__body">

                                       <div class="space-below">
                                          <span class="h4 configurator__heading"><?php _e( 'Product configureren', 'glasbestellen' ); ?></span>
                                          <p><?php echo sprintf( __( 'Klik voor meer informatie op het %s symbool.', 'glasbestellen' ), '<i class="fas fa-question-circle configurator__info-icon"></i>' ); ?></p>
                                       </div>

                                       <form method="post" class="configurator__form js-configurator-blur-update">

                                          <?php
                                          while ( $configurator->have_steps() ) {
                                             $configurator->the_step();
                                             $configured_value = $configurator->get_step_configuration();
                                             $step_id = $configurator->get_step_id();
                                             $step_class = 'js-step-' . $step_id;
                                             if ( $step_parent = $configurator->get_step_parent() ) {
                                                $step_class .= ' js-step-parent-' . $step_parent;
                                                if ( ! $configured_value ) {
                                                   $step_class .= ' d-none';
                                                }
                                             }
                                             if ( $configurator->get_step_explanation_id() ) {
                                                $explanation_id = $configurator->get_step_explanation_id();
                                                $label_class = 'configurator__form-label--link js-popup-explanation';
                                             } else {
                                                $explanation_id = false;
                                                $label_class = '';
                                             }
                                             ?>

                                             <div class="configurator__form-row <?php echo $step_class; ?>" data-step-id="<?php echo $step_id; ?>">
                                                <div class="configurator__form-col configurator__form-info <?php echo ( ! $explanation_id ) ? 'd-none d-md-block' : ''; ?>">
                                                   <?php if ( $explanation_id ) { ?>
                                                      <i class="fas fa-question-circle configurator__info-icon js-popup-explanation" data-explanation-id="<?php echo $explanation_id; ?>"></i>
                                                   <?php } ?>
                                                </div>
                                                <div class="configurator__form-col">
                                                   <label class="configurator__form-label <?php echo $label_class; ?>" data-explanation-id="<?php echo $explanation_id; ?>"><?php echo $configurator->get_step_title(); ?></label>
                                                </div>

                                                <?php
                                                if ( $options = $configurator->get_step_options() ) {
                                                   if ( count( $options ) > 1 ) { ?>
                                                      <div class="configurator__form-col configurator__form-input js-form-group">
                                                         <select name="configuration[<?php echo $step_id; ?>]" class="dropdown configurator__form-control js-form-validate js-step-input-<?php echo $step_id; ?>" data-step-title="<?php echo $configurator->get_step_title(); ?>" data-step-id="<?php echo $step_id; ?>">
                                                            <?php
                                                            foreach ( $options as $option ) {
                                                               $selected     = selected( $configured_value, $option->get_id(), false );
                                                               $rules        = ( $option->get_validation_rules() ) ? 'data-validation-rules=\'' . $option->get_validation_rules() . '\'' : '';
                                                               $child_step   = ( $option->get_child_step() ) ? 'data-child-step="' . $option->get_child_step() . '"' : '';
                                                               $plus_price   = ( ! $option->is_default() ) ? apply_filters( 'gb_step_part_price_difference', Money::display( $option->get_plus_price() ), $step_id ) : '';
                                                               echo '<option value="' . $option->get_id() . '" data-option-id="' . $option->get_id() . '" ' . $rules . ' ' . $child_step . ' ' . $selected . '>' . $option->get_title() . ' ' . $plus_price . '</option>';
                                                            }
                                                            ?>
                                                         </select>
                                                         <div class="invalid-feedback js-invalid-feedback"></div>
                                                      </div>

                                                   <?php } else { ?>
                                                      <div class="configurator__form-col configurator__form-input configurator__form-input--default">
                                                         <span><?php echo $options[0]->get_title(); ?></span>
                                                         <input type="hidden" name="configuration[<?php echo $step_id; ?>]" value="<?php echo $options[0]->get_id(); ?>">
                                                      </div>
                                                   <?php } ?>

                                                <?php } else { ?>
                                                   <div class="configurator__form-col configurator__form-input js-form-group">
                                                      <input type="number" name="configuration[<?php echo $step_id; ?>]" class="form-control configurator__form-control js-form-validate" placeholder="mm" <?php echo ( $configurator->is_step_required() ) ? 'data-required="true"' : ''; ?> data-validation-rules='<?php echo $configurator->get_validation_rules(); ?>' value="<?php echo $configured_value; ?>" />
                                                      <div class="invalid-feedback js-invalid-feedback"></div>
                                                   </div>
                                                <?php } ?>
                                             </div>

                                          <?php } ?>

                                          <div class="configurator__form-row">

                                             <div class="configurator__form-col configurator__form-label">
                                                <label><?php _e( 'Opmerking', 'glasbestellen' ) ?></label>
                                             </div>

                                             <div class="configurator__form-col configurator__form-input">
                                                <textarea class="form-control js-configurator-message" placeholder="<?php echo sprintf( __( 'Maximaal %d karakters', 'glasbestellen' ), 235 ); ?>" maxlength="235"></textarea>
                                             </div>

                                          </div>

                                          <div class="configurator__form-row space-below">
                                             <div class="configurator__form-col configurator__form-label">
                                                <label><?php _e( 'Aantal', 'glasbestellen' ) ?></label>
                                             </div>
                                             <div class="configurator__form-col configurator__form-input">
                                                <select class="dropdown configurator__form-control js-configurator-quantity">
                                                   <?php for ( $i = 1; $i <= 10; $i ++ ) { ?>
                                                      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                   <?php } ?>
                                                </select>
                                             </div>
                                          </div>

                                          <div class="configurator__form-button space-below">
                                             <button class="btn btn--primary btn--block btn--next js-configurator-cart-button"><?php _e( 'In winkelwagen', 'glasbestellen' ); ?></button>
                                          </div>

                                          <ul class="configurator__checks">
                                             <li class="configurator__checks-item"><?php echo '<strong>' . __( 'Bestel check', 'glasbestellen' ) . ':</strong> ' . __( 'Uw bestelling wordt op juistheid en volledigheid gecontroleerd.', 'glasbestellen' ); ?></li>
                                             <li class="configurator__checks-item"><?php echo '<strong>' . __( 'Klanttevredenheid', 'glasbestellen' ) . ':</strong> ' . sprintf( __( 'Klanten beoordelen ons gemiddeld met een %s.', 'glasbestellen' ), '<a href="' . get_post_type_archive_link( 'review' ) . '" target="_blank" rel="nofollow">' . gb_get_review_average( true ) . '</a>' ); ?></li>
                                          </ul>

                                       </form>

                                    </div>

                                 <?php } ?>

                              </div>

                           </div>

                        </div>

                        <article class="text space-below">

                           <?php the_content(); ?>

                           <?php if ( have_rows( 'technical_details' ) ) { ?>

                              <h4><?php _e( 'Technische informatie', 'glasbestellen' ); ?></h4>

                              <table class="details-table">
                                 <tbody>

                                    <?php
                                    $rows_count = 0;
                                    while ( have_rows( 'technical_details' ) ) {
                                       the_row();
                                       $rows_count ++;
                                       $class = ( $rows_count % 2 ) ? 'details-table__row' : 'details-table__row details-table__row--even'; ?>

                                       <tr class="<?php echo $class; ?>">
                                          <td class="details-table__col"><?php the_sub_field( 'label' ); ?></td>
                                          <td class="details-table__col"><?php the_sub_field( 'description' ); ?></td>
                                       </tr>

                                    <?php } ?>

                                 </tbody>
                              </table>

                           <?php } ?>

                        </article>

                        <?php if ( get_field( 'related_configurators' ) ) { ?>

                           <div class="related-configurators large-space-above">

                              <h4 class="h2 space-below"><?php _e( 'Andere bekeken ook:', 'glasbestellen' ); ?></h4>

                              <div class="row">

                                 <?php
                                 while ( have_rows( 'related_configurators' ) ) {
                                    the_row();
                                    if ( $post = get_sub_field( 'configurator' ) ) {
                                       setup_postdata( $post );
                                       $configurator = gb_get_configurator( get_the_id() ); ?>

                                       <div class="col-md-6 col-lg-3">
                                          <?php require( get_template_directory() . '/template-parts/product-listing.php' ); ?>
                                       </div>

                                       <?php
                                       wp_reset_postdata();
                                    }
                                 }
                                 ?>

                              </div>

                           </div>

                        <?php } ?>

                     </div>

                  </div>

               </div>

            </main>

         <?php } ?>

      <?php } ?>

   <?php } ?>

<?php get_footer(); ?>
