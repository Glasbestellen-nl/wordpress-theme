<?php get_header(); ?>

<main class="main-section main-section--space-around main-section--grey">

   <div class="container">

      <section class="layout">

         <?php
         if ( have_posts() ) {
            while ( have_posts() ) {
               the_post(); 
               the_content();
            }
         } 
         ?>
      </section>
   </div>
</main>

<?php get_footer(); ?>
