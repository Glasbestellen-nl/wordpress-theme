<?php
// Template name: Product layout 1
// Template post type: product
get_header(); ?>

   <main class="main-section main-section--space-around">

      <div class="container">

         <div class="row">

            <div class="col-12 col-lg-6">

               <div class="image-slider space-below">
                  <div class="image-slider__container image-slider__main">
                     <div class="image-slider__arrows">
                        <div class="image-slider__arrow image-slider__arrow--prev">
                           <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="image-slider__arrow image-slider__arrow--next">
                           <i class="fas fa-chevron-right"></i>
                        </div>
                     </div>
                     <img data-src="https://www.glasbestellen.nl/wp-content/uploads/2019/07/Schuifdeursysteem-SlideTec-wand.jpg" class="lazyload image-slider__img image-slider__main-img">
                  </div>
                  <div class="image-slider__thumbs">
                     <div class="image-slider__container image-slider__thumb image-slider__thumb--current">
                        <img data-src="https://www.glasbestellen.nl/wp-content/uploads/2019/07/Schuifdeursysteem-SlideTec-wand.jpg" class="lazyload image-slider__img image-slider__thumb-img">
                     </div>
                     <div class="image-slider__container image-slider__thumb">
                        <img data-src="https://www.glasbestellen.nl/wp-content/uploads/2019/07/glazen-schuifdeur-kantoren.png" class="lazyload image-slider__img image-slider__thumb-img">
                     </div>
                     <div class="image-slider__container image-slider__thumb">
                        <img data-src="https://www.glasbestellen.nl/wp-content/uploads/2019/07/glazen-schuifdeur-kantoren.png" class="lazyload image-slider__img image-slider__thumb-img">
                     </div>
                     <div class="image-slider__container image-slider__thumb">
                        <img data-src="https://www.glasbestellen.nl/wp-content/uploads/2019/07/glazen-schuifdeur-kantoren.png" class="lazyload image-slider__img image-slider__thumb-img">
                     </div>
                     <div class="image-slider__container image-slider__thumb">
                        <img data-src="https://www.glasbestellen.nl/wp-content/uploads/2019/07/glazen-schuifdeur-kantoren.png" class="lazyload image-slider__img image-slider__thumb-img">
                     </div>
                  </div>
               </div>

               <section class="text space-below">
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

            <div class="col-12 col-lg-6">

               <div class="layout layout--grey full-height">

                  <div class="layout__column full-height">

                     <header class="text large-space-below">
                        <h2>Glazen schuifdeur offerte</h2>
                        <p>Laat ons met u meedenken over de perfecte glazen schuifdeur voor uw situatie. We werken graag een vrijblijvende offerte voor u uit ​–​ eventueel inclusief inmeten en monteren.</p>
                        <p>Heeft u andere vragen of gewoon benieuwd naar de mogelijkheden? Ook dan helpt ons team van experts u graag verder!</p>
                     </header>

                     <div class="form form--lead sticky">
                        <?php get_template_part( 'template-parts/lead-form' ); ?>
                     </div>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </main>

   <?php get_footer(); ?>
