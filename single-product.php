<?php get_header(); ?>

   <?php
   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post();
         $configurator = get_field( 'configurator' ); ?>

         <div class="hero hero--shadow">

            <div class="hero__inner">

               <div class="container">

                  <div class="hero__body text-center">

                     <div class="hero__header">
                        <h1 class="h1 hero__title"><?php echo ( get_field( 'second_title' ) ) ? get_field( 'second_title' ) : get_the_title(); ?></h1>
                     </div>

                     <div class="hero__buttons">
                        <div class="hero__button">
                           <?php if ( $configurator ) { ?>
                              <a href="<?php echo get_term_link( $configurator, 'startopstelling' ); ?>" class="hero__button-btn btn btn--primary btn--large btn--next"><?php _e( 'Op maat samenstellen', 'glasbestellen' ); ?></a>
                           <?php } ?>
                        </div>
                        <div class="hero__button">
                           <span class="hero__button-btn btn btn--<?php echo ( $configurator ) ? 'secondary' : 'primary'; ?> btn--large btn--next js-popup-form" data-formtype="lead" data-popup-title="<?php _e( 'Offerte aanvragen', 'glasbestellen' ); ?>"><?php _e( 'Ontvang offerte', 'glasbestellen' ); ?></span>
                        </div>
                     </div>

                     <?php if ( ! $configurator ) { ?>
                        <span class="hero__button-cta space-above"><?php _e( 'Binnen 1 dag in je mail!', 'glasbestellen' ); ?></span>
                     <?php } ?>

                     <?php if ( get_field( 'show_sticker' ) ) { ?>
                        <div class="hero__sticker d-none d-lg-block">
                           <div class="sticker">
                              <div class="sticker__body">
                                 <span class="sticker__text"><?php _e( 'Laten plaatsen?', 'glasbestellen' ); ?></span>
                                 <span class="sticker__text sticker__text--highlighted"><?php _e( 'Geen probleem!', 'glasbestellen' ); ?></span>
                              </div>
                           </div>
                        </div>
                     <?php } ?>

                  </div>

               </div>

            </div>

            <img data-src="<?php echo gb_get_cover_image_url( get_the_id() ); ?>" class="lazyload hero__background">

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
                  if ( $reviews = gb_get_reviews( $number = 14, get_field( 'review_category' ) ) ) { ?>

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
                        <span class="btn btn--primary btn--large btn--next js-popup-form" data-formtype="lead" data-popup-title="<?php _e( 'Offerte aanvragen', 'glasbestellen' ); ?>"><?php _e( 'Ontvang offerte', 'glasbestellen' ); ?></span>
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
