<?php get_header(); ?>

   <main class="main-section main-section--space-around main-section--grey">

      <div class="container">

         <?php if ( have_posts() ) { ?>

            <?php
            if ( function_exists( 'yoast_breadcrumb' ) ) {
               yoast_breadcrumb( '<div class="breadcrumbs space-below">', '</div>' );
            }
            ?>

            <div class="row">

               <?php
               while ( have_posts() ) {
                  the_post(); ?>

                  <div class="col-12 col-md-6">

                     <article class="card post" id="post_<?php the_id(); ?>" data-mh="post">
                        <div class="card__body">
                           <div class="post__date"><?php the_date(); ?></div>
                           <h2 class="h4 post__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                           <div class="text post__text">
                              <?php the_excerpt(); ?>
                           </div>
                        </div>
                     </article>

                  </div>

               <?php } ?>

            </div>

         <?php } ?>

         <div class="pagination">
            <?php echo paginate_links(); ?>
         </div>

      </div>

   </main>


<?php get_footer(); ?>
