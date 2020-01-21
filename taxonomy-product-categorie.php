<?php get_header(); ?>

   <main class="main-section main-section--space-around">

      <div class="container">

         <div class="row">

            <div class="col">

               <section class="text large-space-below">
                  <h1 class="h1"><?php echo sprintf( __( '%s glas' ), single_term_title( '', false ) ); ?></h1>
                  <?php echo term_description(); ?>
               </section>

            </div>

         </div>

         <?php if ( have_posts() ) { ?>

            <div class="row">

               <?php
               while ( have_posts() ) {
                  the_post();

                  if ( ! get_post_meta( get_the_id(), 'hide_on_archive', true ) ) { ?>

                     <div class="col-12 col-md-6 col-lg-4">

                        <article class="teaser teaser--short space-below">

                           <a href="<?php the_permalink(); ?>" class="teaser__image teaser__image--cover">
                              <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="" class="teaser__image-img">
                           </a>

                           <a href="<?php the_permalink(); ?>" class="teaser__body teaser__body--full">
                              <h3 class="h-default teaser__headline"><?php the_title(); ?></h3>
                           </a>

                        </article>

                     </div>

                  <?php } ?>

               <?php } ?>

            </div>

         <?php } ?>

      </div>

   </main>

<?php get_footer(); ?>
