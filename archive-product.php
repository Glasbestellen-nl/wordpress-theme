<?php get_header(); ?>

   <main class="main-section main-section--space-around">

      <div class="container">

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

         <div class="row">

            <div class="col">

               <section class="text">
                  <h1 class="h1">Glas op maat</h1>
                  <p>Glas wordt steeds vaker gebruikt in en rondom het huis. Iedere situatie vraagt om maatwerk en hier helpen we u bij Glasbestellen.nl graag mee. Glas is een geweldig product en de toepassingen zijn voor velen nog onbekend.</p>
               </section>

            </div>

         </div>

      </div>

   </main>

<?php get_footer(); ?>
