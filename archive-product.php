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
                              <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>" class="teaser__image-img">
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

               <?php $page_content = get_option( 'product_post_type_content' ); ?>

               <section class="text">
                  <h1 class="h1"><?php echo ! empty( $page_content['title'] ) ? $page_content['title'] : post_type_archive_title( '', false ); ?></h1>
                  <?php echo ! empty( $page_content['content'] ) ? wpautop( $page_content['content'] ) : ''; ?>
               </section>

            </div>

         </div>

      </div>

   </main>

<?php get_footer(); ?>
