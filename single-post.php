<?php get_header(); ?>

<main class="main-section main-section--space-around main-section--grey">
   <div class="container">
      <section class="layout">
         <div class="row">
            <div class="col-12">
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
      </section>
   </div>
</main>

<?php get_footer(); ?>