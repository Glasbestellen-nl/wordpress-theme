<?php
// Template name: Configurator layout 1
// Template post type: configurator
get_header();

   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post(); ?>

         <main class="main-section main-section--space-around main-section--grey">

            <div class="container">

               <div class="layout">

                  <div class="layout__column box-shadow">

                     <?php
                     if ( function_exists( 'yoast_breadcrumb' ) ) {
                        yoast_breadcrumb( '<div class="breadcrumbs small-space-below">', '</div>' );
                     }
                     ?>

                     <section class="text">
                        <h1><?php the_title(); ?></h1>
                     </section>

                     <div class="row">

                        <div class="col-12 col-md-6">



                        </div>

                        <div class="col-12 col-md-6">
                        </div>

                     </div>

                  </div>

               </div>

            </div>

         </main>

      <?php } ?>

   <?php } ?>

<?php get_footer(); ?>
