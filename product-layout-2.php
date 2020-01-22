<?php
// Template name: Product layout 2
// Template post type: product
get_header();

   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post();
         ?>

         <div class="hero">

            <div class="hero__inner">

               <div class="container">

                  <div class="row">

                     <div class="col-12 col-lg-6">

                        <div class="hero__body hero__body--fade full-height">

                           <section class="text hero__text space-lg-right">
                              <?php
                              the_title( '<h1 class="h1">', '</h1>' );
                              the_content();
                              ?>
                           </section>

                        </div>

                     </div>

                     <div class="col-12 col-lg-6 d-none d-lg-block">

                        <div class="hero__overlay space-lg-left full-height">

                           <header class="text-center space-below">
                              <span class="h2 h-dark-bg h-shadow"><?php _e( 'Ontvang vrijblijvend een offerte', 'glasbestellen' ); ?></span>
                           </header>

                           <div class="form form--dark-bg form--no-label" enctype="multipart/form-data">
                              <?php get_template_part( 'template-parts/lead-form' ); ?>
                           </div>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

            <?php if ( $background_image = get_field( 'background_image' ) ) { ?>
               <img data-src="<?php echo $background_image['url']; ?>" class="lazyload hero__background">
            <?php } ?>

         </div>

         <main class="main-section">

            <?php
            $count = 0;
            if ( have_rows( 'featured_items' ) ) {
               while ( have_rows( 'featured_items' ) ) {
                  the_row();
                  $count ++;
                  $area_class = ( $count % 2 ) ? 'area' : 'area area--grey'; ?>

                  <div class="<?php echo $area_class; ?>">

                     <div class="container">

                        <div class="row align-items-lg-center<?php echo ( $count % 2 ) ? '' : ' flex-md-row-reverse'; ?>">

                           <div class="col-12 col-md-6 col-lg-4">
                              <?php if ( $image = get_sub_field( 'featured_item_image' ) ) { ?>
                                 <a href="<?php echo $image['url']; ?>" class="fancybox space-below">
                                    <img data-src="<?php echo $image['url']; ?>" class="lazyload rounded-corners box-shadow">
                                 </a>
                              <?php } ?>
                           </div>

                           <div class="col col-md-6 col-lg-8">

                              <div class="text text--small area__text space-below space-md-left">

                                 <h2 class="h2"><?php the_sub_field( 'featured_item_title' ); ?></h2>

                                 <?php the_sub_field( 'featured_item_content' ); ?>

                                 <span class="btn btn--primary btn--next space-above d-block d-md-inline-block js-popup-form" data-formtype="lead"><?php _e( 'Offerte aanvragen', 'glasbestellen' ); ?></span>

                              </div>

                           </div>

                        </div>

                     </div>

                  </div>

               <?php } ?>

            <?php } ?>

         </main>

      <?php } ?>

   <?php } ?>

<?php get_footer(); ?>
