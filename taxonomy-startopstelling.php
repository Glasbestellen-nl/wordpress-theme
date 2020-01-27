<?php get_header(); ?>

   <main class="main-section main-section--no-space">

      <div class="container">

         <div class="layout layout--outstanding layout--borderless space-below">

            <div class="layout__column">

               <header class="text-center space-below">
                  <h1><?php _e( 'Kies een startopstelling', 'glasbestellen' ); ?></h1>
               </header>

               <?php if ( have_posts() ) { ?>

                  <div class="space-around">

                     <div class="row">

                        <?php
                        while ( have_posts() ) {
                           the_post(); ?>

                           <div class="col-md-6 col-lg-4">

                              <a href="<?php the_permalink(); ?>" class="teaser space-below">

                                 <div class="teaser__image">
                                    <img src="<?php echo get_the_post_thumbnail_url( get_the_id(), 'large' ); ?>" class="teaser__image-img" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>">
                                 </div>

                                 <div class="teaser__body teaser__body--below">
                                    <div class="teaser__headline"><?php the_title(); ?></div>
                                 </div>
                              </a>

                           </div>

                        <?php } ?>

                     </div>

                  </div>

               <?php } ?>

            </div>

         </div>

      </div>

   </main>

<?php get_template_part( 'template-parts/foot' ); ?>
