<?php get_header(); ?>

   <main class="main-section main-section--space-around main-section--grey">

      <div class="container">

         <?php do_action( 'page_before_layout' ); ?>

         <div class="row">

            <div class="col">

               <div class="layout layout--outstanding">

                  <div class="layout__column">

                     <?php
                     if ( have_posts() ) {
                        while ( have_posts() ) {
                           the_post();
                           the_content();
                        }
                     }
                     ?>
               </div>
            </div>      
         </div>
      </div>

   </main>

<?php get_footer(); ?>
