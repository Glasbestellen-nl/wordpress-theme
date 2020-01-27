<?php get_header(); ?>

   <?php
   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post(); ?>

         <main class="main-section">

            <div class="container">

               <?php
               if ( function_exists( 'yoast_breadcrumb' ) ) {
                  yoast_breadcrumb( '<div class="breadcrumbs large-space-below">', '</div>' );
               }
               ?>

               <?php get_template_part( 'template-parts/single-pin' ); ?>

            </div>

         </main>

      <?php } ?>

   <?php } ?>

<?php get_footer(); ?>
