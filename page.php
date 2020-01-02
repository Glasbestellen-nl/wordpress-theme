<?php get_header(); ?>

   <main class="main-section">

      <div class="container">

         <section class="text">
            <?php
            if ( have_posts() ) {
               while ( have_posts() ) {
                  the_post();
                  the_title( '<h1>', '</h1>' );
                  the_content();
                }
             }
             ?>
         </section>

      </div>

   </main>

<?php get_footer(); ?>
