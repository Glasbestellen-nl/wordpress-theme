<?php
// Template name: Product layout 1
// Template post type: product
get_header();

   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post(); ?>

         <main class="main-section main-section--space-around">

            <div class="container">

               <?php
               if ( function_exists( 'yoast_breadcrumb' ) ) {
                  yoast_breadcrumb( '<div class="breadcrumbs space-below">', '</div>' );
               }
               ?>

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
                              <img src="<?php echo $gallery_images[0]['url']; ?>" class="image-slider__img image-slider__main-img js-main" alt="<?php echo $gallery_images[0]['alt']; ?>">
                           </div>

                           <div class="image-slider__thumbs">

                              <?php
                              $index = 0;
                              foreach ( $gallery_images as $image ) {
                                 $index ++; ?>

                                 <div class="image-slider__container image-slider__thumb js-thumb <?php echo ( $index == 1 ) ? 'current' : ''; ?>">
                                    <img src="<?php echo $image['url']; ?>" class="image-slider__img image-slider__thumb-img" alt="<?php echo $image['alt']; ?>" data-index="<?php echo $index; ?>" data-image="<?php echo $image['url']; ?>">
                                 </div>

                              <?php } ?>

                           </div>
                        </div>

                     <?php } ?>

                     <section class="text space-below">
                        <?php
                        the_title( '<h1 class="h1">', '</h1>' );
                        the_content();
                        ?>
                     </section>

                  </div>

                  <div class="col-12 col-lg-6">

                     <div class="layout layout--grey full-height">

                        <div class="layout__column full-height">

                           <?php if ( get_field( 'extra_title' ) ) { ?>

                              <header class="text large-space-below">
                                 <h2><?php echo get_field( 'extra_title' ); ?></h2>
                                 <?php echo get_field( 'extra_content' ); ?>
                              </header>

                           <?php } ?>

                           <div class="form form--lead sticky" id="lead_form">
                              <?php get_template_part( 'template-parts/lead-form' ); ?>
                           </div>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

         </main>

      <?php } ?>

   <?php } ?>

   <div class="fixed-bottom-wrapper fixed-bottom-wrapper--mobile js-hide-when" data-hide-when="#lead_form">
      <div class="container">
         <span class="btn btn--primary btn--next btn--block js-scroll-to" data-scroll-to="#lead_form"><?php _e( 'Ontvang offerte', 'glasbestellen' ); ?></span>
      </div>
   </div>

<?php get_footer(); ?>
