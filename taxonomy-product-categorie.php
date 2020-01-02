<?php get_header(); ?>

   <main class="main-section main-section--space-around">

      <div class="container">

         <div class="row">

            <div class="col">

               <section class="text large-space-below">
                  <h1 class="h1"><?php echo sprintf( __( '%s glas' ), single_term_title( '', false ) ); ?></h1>
                  <?php echo term_description(); ?>
               </section>

            </div>

         </div>

         <div class="row">

            <div class="col-12 col-md-6 col-lg-4">

               <article class="teaser teaser--short space-below">

                  <a href="#" class="teaser__image teaser__image--cover">
                     <img src="https://www.glasbestellen.nl/wp-content/uploads/2014/06/glazen-keuken-achterwand-thumb.jpg" alt="" class="teaser__image-img">
                  </a>

                  <a href="#" class="teaser__body teaser__body--full">
                     <h3 class="h-default teaser__headline">Keukenwanden</h3>
                  </a>

               </article>

            </div>

            <div class="col-12 col-md-6 col-lg-4">

               <article class="teaser teaser--short space-below">

                  <a href="#" class="teaser__image teaser__image--cover">
                     <img src="https://www.glasbestellen.nl/wp-content/uploads/2014/06/douchedeur-thumb.jpg" alt="" class="teaser__image-img">
                  </a>

                  <a href="#" class="teaser__body teaser__body--full">
                     <h3 class="h-default teaser__headline">Douchedeuren</h3>
                  </a>

               </article>

            </div>

            <div class="col-12 col-md-6 col-lg-4">

               <article class="teaser teaser--short space-below">

                  <a href="#" class="teaser__image teaser__image--cover">
                     <img src="https://www.glasbestellen.nl/wp-content/uploads/2014/06/douchewand-thumb.jpg" alt="" class="teaser__image-img">
                  </a>

                  <a href="#" class="teaser__body teaser__body--full">
                     <h3 class="h-default teaser__headline">Douchewanden</h3>
                  </a>

               </article>

            </div>
            
         </div>

      </div>

   </main>

<?php get_footer(); ?>
