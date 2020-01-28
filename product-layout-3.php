<?php
// Template name: Product layout 3
// Template post type: product
get_header();
?>

   <?php
   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post(); ?>

         <div class="hero hero--shadow">

            <div class="hero__inner">

               <div class="container">

                  <div class="row">

                     <div class="col-12 col-lg-6">

                        <div class="hero__body full-height" style="padding-bottom: 0;">

                           <?php if ( $term_id = get_field( 'configurator' ) ) { ?>

                              <div class="hero__frame large-space-above">
                                 <h1 class="hero__frame-headline"><?php echo ( get_field( 'second_title' ) ) ? get_field( 'second_title' ) : get_the_title(); ?></h1>
                                 <p class="hero__frame-subline"><?php _e( 'Direct online bestellen', 'glasbestellen' ); ?></p>
                              </div>

                              <div class="hero__frame" style="margin-bottom: 0;">
                                 <a href="<?php echo get_term_link( $term_id, 'startopstelling' ); ?>" class="btn btn--quaternary btn--block btn--large"><?php _e( 'Op maat samenstellen', 'glasbestellen' ); ?></a>
                              </div>

                           <?php } ?>

                        </div>

                     </div>

                     <div class="col-12 col-lg-5 offset-lg-1">

                        <form method="post" enctype="multipart/form-data" class="js-form-validation form--no-label form-yellow large-space-above" novalidate>

                           <header class="form-yellow__header text-center space-below">
                              <h2 class="form-yellow__headline h-default"><?php _e( 'Wilt u een offerte?', 'glasbestellen' ); ?></h2>
                              <span class="form-yellow__subline"><?php _e( 'Wij helpen u graag!', 'glasbestellen' ); ?></span>
                           </header>

                           <p class="js-error-alert alert alert--danger" style="display: none;"></p>

                           <div class="form-group js-form-group">
                              <label class="form-label"><?php _e( 'Beschrijf uw wensen en uw situatie', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                              <textarea name="lead[content]" class="form-control js-form-validate" data-required="required" rows="6" placeholder="Beschrijf uw wensen en uw situatie"></textarea>
                              <div class="invalid-feedback js-invalid-feedback"></div>
                           </div>

                           <div class="row">

                              <div class="form-group js-form-group col-12">
                                 <label class="form-label"><?php _e( 'Naam', 'glasbestellen' ); ?>: <span class="req">*</span></label>
                                 <input type="text" name="lead[name]" class="form-control js-form-validate" data-required="required" placeholder="<?php _e( 'Naam', 'glasbestellen' ); ?>" />
                                 <div class="invalid-feedback js-invalid-feedback"></div>
                              </div>

                              <div class="form-group js-form-group col-12">
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

                           </div>

                           <div class="form-group">
                              <div class="file-input">
                                 <label for="lead_files_field" class="file-input__trigger js-file-input-trigger">
                                    <span class="fas fa-upload file-input__icon"></span>
                                    <span class="file-input__text js-file-input-trigger-text"><?php _e( 'Upload een foto of tekening', 'glasbestellen' ); ?></span>
                                 </label>
                                 <input type="file" class="file-input__field js-file-input-field" id="lead_files_field" multiple>
                              </div>
                           </div>

                           <div class="form-group">
                              <button class="btn btn--primary btn--block btn--next" type="submit"><?php _e( 'Offerte aanvragen', 'glasbestellen' ); ?></button>
                           </div>

                           <?php get_template_part( 'template-parts/form-hidden-fields' ); ?>

                        </form>

                     </div>

                  </div>

               </div>

            </div>

            <img data-src="<?php echo gb_get_cover_image_url( get_the_id() ); ?>" class="lazyload hero__background" alt="<?php echo get_post_meta( get_post_thumbnail_id( get_the_id() ), '_wp_attachment_image_alt', true ); ?>">

         </div>

         <main class="main-section main-section--space-around">

            <div class="container">

               <div class="row">

                  <div class="col-12 col-md-12 col-lg-<?php echo ( get_field( 'review_category' ) ) ? '7' : '12'; ?>">

                     <section class="section text space-lg-right">

                        <?php
                        if ( function_exists( 'yoast_breadcrumb' ) ) {
                           yoast_breadcrumb( '<div class="breadcrumbs space-below">', '</div>' );
                        }
                        echo '<h2 class="h1">' . sprintf( __( '%s op maat', 'glasbestellen' ), get_the_title() ) . '</h2>';
                        the_content();
                        ?>

                        <?php if ( $youtube_url = get_post_meta( get_the_id(), 'youtube_video', 'true' ) ) { ?>
                           <div class="iconic-link">
                              <i class="iconic-link__icon fab fa-youtube"></i>
                              <a href="<?php echo $youtube_url; ?>" class="iconic-link__text fancybox-various fancybox.iframe">
                                 <?php echo sprintf( __( 'Bekijk onze <strong>%s</strong> informatie video.', 'glasbestellen' ), strtolower( get_the_title() ) ); ?>
                              </a>
                           </div>
                        <?php } ?>

                     </section>

                  </div>

                  <?php
                  if ( $review_category = get_field( 'review_category' ) ) {

                     if ( $reviews = gb_get_reviews( $number = 14, $review_category ) ) { ?>

                        <div class="col-12 col-md-12 col-lg-5">

                           <section class="section">

                              <strong class="h3"><?php _e( 'Wat onze klanten zeggen..', 'glasbestellen' ); ?></strong>

                              <div class="card rotator js-rotator">

                                 <?php foreach ( $reviews as $review ) { ?>

                                    <div class="rotator__item js-rotator-item">

                                       <article class="review">

                                          <div class="review__header">

                                             <div class="review__title">
                                                <strong class="h5 h-default"><?php echo $review->post_title; ?></strong>
                                             </div>

                                             <?php if ( $rating = get_field( 'rating', $review->ID ) ) { ?>

                                                <div class="review__rating rating">
                                                   <div class="stars rating__stars">
                                                      <?php
                                                      for ( $i = 1; $i <= 5; $i ++ ) {
                                                         $class = 'star';
                                                         if ( $i <= $rating ) {
                                                            $class .= ' star--checked';
                                                         }
                                                         echo '<div class="fas fa-star ' . $class . '"></div> ';
                                                      }
                                                      ?>
                                                   </div>
                                                </div>

                                             <?php } ?>

                                          </div>

                                          <div class="review__body">
                                             <div class="text text--small review__text">
                                                <?php echo wpautop( get_the_excerpt( $review->ID ) ); ?>
                                             </div>
                                          </div>

                                       </article>

                                    </div>

                                 <?php } ?>

                              </div>

                           </section>

                        </div>

                     <?php } ?>

                  <?php } ?>

               </div>

            </div>

            <?php if ( $gallery_images = get_field( 'gallery_images' ) ) { ?>

               <div class="area area--grey">

                  <div class="container">

                     <section class="row gallery js-bricks">

                        <?php foreach ( $gallery_images as $image ) { ?>

                           <div class="col-6 col-md-4 col-lg-3 js-brick">

                              <a href="<?php echo $image['url']; ?>" class="gallery__item fancybox" rel="product-images" title="<?php echo $image['caption']; ?>">
                                 <img data-src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>" class="lazyload gallery__image" />
                              </a>

                           </div>

                        <?php } ?>

                     </section>

                  </div>

               </div>

            <?php } ?>

            <div class="area">

               <div class="container">

                  <?php if ( have_rows( 'usps' ) ) { ?>

                     <header class="divider divider--line-behind divider--centered">
                        <strong class="divider__content h2"><?php _e( 'Redenen om voor ons te kiezen', 'glasbestellen' ); ?></strong>
                     </header>

                     <section class="section">

                        <div class="row">

                           <?php
                           while ( have_rows( 'usps' ) ) {
                              the_row(); ?>

                              <div class="col-12 col-md-6 col-lg-6">

                                 <article class="card">

                                    <div class="card__body" data-mh="usp-card-body">

                                       <strong class="h4 card__title"><?php the_sub_field( 'title' ); ?></strong>
                                       <div class="text card__text">
                                          <?php echo wpautop( get_sub_field( 'description' ) ); ?>
                                       </div>

                                    </div>

                                 </article>

                              </div>

                           <?php } ?>

                        </div>

                     </section>

                  <?php } ?>

                  <?php if ( have_rows( 'faq' ) ) { ?>

                     <header class="divider divider--line-behind divider--centered">
                        <strong class="divider__content h2"><?php _e( 'Veelgestelde vragen', 'glasbestellen' ); ?></strong>
                     </header>

                     <section class="section">

                        <div class="row">

                           <?php
                           while ( have_rows( 'faq' ) ) {
                              the_row(); ?>

                              <div class="col-12">

                                 <article class="collapse-box js-collapse-box">

                                    <header class="collapse-box__header">
                                       <strong class="collapse-box__title"><?php the_sub_field( 'question' ); ?></strong>
                                    </header>
                                    <div class="collapse-box__body text">
                                       <?php echo wpautop( get_sub_field( 'answer' ) ); ?>
                                    </div>

                                 </article>

                              </div>

                           <?php } ?>

                        </div>

                     </section>

                  <?php } ?>

                  <div class="divider divider--line-behind divider--centered divider--end">
                     <div class="divider__content">
                        <span class="btn btn--primary btn--large btn--next js-popup-form" data-formtype="lead"><?php _e( 'Ontvang offerte', 'glasbestellen' ); ?></span>
                     </div>
                  </div>

               </div>

            </div>

            <?php if ( $seo_content = get_post_meta( get_the_id(), 'seo_content', true ) ) { ?>

               <div class="area">
                  <div class="container">
                     <arcticle class="text">
                        <h2><?php echo sprintf( __( 'Algemene informatie %s', 'glasbestellen' ), get_the_title() ); ?></h2>
                        <?php echo wpautop( $seo_content ); ?>
                     </article>
                  </div>
               </div>

            <?php } ?>

         </main>

      <?php } ?>

   <?php } ?>

<?php get_footer(); ?>
