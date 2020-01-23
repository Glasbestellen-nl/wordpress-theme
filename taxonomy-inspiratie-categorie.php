<?php get_header(); ?>

   <main class="main-section main-section--space-around">

      <div class="container">

         <header class="page-header page-header--headline-dropdown">

            <h1 class="h1 page-header__headline"><?php single_term_title(); ?></h1>

            <div class="page-header__dropdown">
               <?php get_template_part( 'template-parts/inspiration-category-dropdown' ); ?>
            </div>

         </header>

         <?php if ( have_posts() ) { ?>

            <div class="row js-bricks">

               <?php
               while ( have_posts() ) {
                  the_post(); ?>

                  <div class="col-12 col-md-6 col-lg-4 js-brick">

                     <div class="pin">

                        <img data-src="<?php echo get_the_post_thumbnail_url(); ?>" class="lazyload pin__image" />

                        <div class="pin__body">
                           <h2 class="h5 h-default pin__title"><?php the_title(); ?></h2>
                        </div>

                     </div>

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
