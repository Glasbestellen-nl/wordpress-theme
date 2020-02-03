<?php
// Template name: Product layout 4
// Template post type: product
get_header();
?>

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
                  <h1>Badkamer spiegel met LED verlichting</h1>
                  <p>Exclusieve badkamerspiegel voor uw badkamer, individueel gemaakt volgens uw wensen. Koop gratis hoogwaardige badkamerspiegels rechtstreeks bij de fabrikant, op maat gemaakt en af fabriek. <a href="#">Meer &raquo;</a></p>
               </section>

               <form class="filter-bar large-space-below">

                  <div class="row">

                     <div class="col-md-4 col-lg-3 filter-bar__col">
                        <select class="dropdown filter-bar__dropdown">
                           <option>Filter op type</option>
                        </select>
                     </div>
                     <div class="col-md-4 col-lg-3">
                        <select class="dropdown filter-bar__dropdown">
                           <option>Filter op verlichting</option>
                        </select>
                     </div>

                  </div>

               </form>

               <section class="row product-listings">

                  <?php for ( $i = 1; $i <= 10; $i ++ ) { ?>

                     <div class="col-12 col-md-4 col-lg-3">

                        <div class="product-listing">
                           <a href="#" class="product-listing__image">
                              <img data-src="https://www.spiegel21.de/images/product_images/popup_images/2822_0.jpg" class="lazyload product-listing__image-img">
                           </a>
                           <div class="product-listing__body">
                              <h2 class="h5"><a href="#" class="product-listing__title">Badkamer spiegel met LED - New York</a></h2>
                              <div class="product-listing__info">
                                 <span class="product-listing__price">&euro;96,98</span>
                                 <span class="product-listing__tax">Prijs incl. BTW.</span>
                                 <span class="product-listing__shipping"><i class="fas fa-shipping-fast"></i> Gratis verzending</span>
                              </div>
                           </div>
                        </div>

                     </div>

                  <?php } ?>

               </section>

            </div>

         </div>

      </div>

   </main>

<?php get_footer(); ?>
