<?php
// Template name: Legal
get_header();
?>

   <main class="main-section main-section--space-around main-section--grey">

      <div class="container">

         <section class="layout">

            <div class="layout__column box-shadow text">

               <?php
               if ( have_posts() ) {
                  while ( have_posts() ) {
                     the_post();
                     the_title( '<h1>', '</h1>' );
                     the_content();
                   }
                }
                ?>

            </div>

         </section>

      </div>

   </main>

<?php get_footer(); ?>
