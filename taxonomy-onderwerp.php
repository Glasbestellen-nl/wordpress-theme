<?php get_header(); ?>

   <main class="main-section main-section--grey">

      <div class="container">

         <?php
         if ( function_exists( 'yoast_breadcrumb' ) ) {
            yoast_breadcrumb( '<div class="breadcrumbs space-below">', '</div>' );
         }
         ?>

         <div class="row">

            <div class="col-12 col-lg-3">
               <?php get_template_part( 'template-parts/subjects-side-nav' ); ?>
            </div>

            <div class="col-12 col-lg-9">

               <div class="layout">

                  <div class="text layout__column">

                     <?php
                     echo '<h1 class="h1">' . single_term_title( '', false ) . '</h1>';
                     echo term_description();
                     ?>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </main>

<?php get_footer(); ?>
