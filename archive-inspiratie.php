<?php get_header(); ?>

   <main class="main-section main-section--space-around">

      <div class="container">

         <header class="page-header page-header--headline-dropdown">

            <h1 class="h1 page-header__headline"><?php _e( 'Geleverd werk', 'glasbestellen' ); ?></h1>

            <div class="page-header__dropdown">
               <select class="dropdown js-url-dropdown">
                  <option selected="true" disabled="disabled"><?php _e( 'Filter op product', 'glasbestellen' ); ?></option>
                  <?php
                  if ( $categories = get_terms( 'taxonomy=inspiratie-categorie&hide_empty=0' ) ) {
                     foreach ( $categories as $category ) {
                        echo '<option value="' . get_term_link( $category ) . '">' . $category->name . '</option>';
                     }
                  }
                  ?>
               </select>
            </div>

         </header>

         <?php if ( have_posts() ) { ?>

            <div class="row js-bricks">

               <?php
               while ( have_posts() ) {
                  the_post(); ?>

                  <div class="col-12 col-md-6 col-lg-4 js-brick">

                     <div class="pin">

                        <img data-src="<?php echo get_the_post_thumbnail_url(); ?>" class="lazyload pin__image" />

                        <div class="pin__body">
                           <h2 class="h5 h-default pin__title"><?php the_title(); ?></h2>
                        </div>

                     </div>

                  </div>

               <?php } ?>

            </div>

         <?php } ?>

         <?php paginate_links(); ?>

         <div class="pagination">
            <a href="#" class="pagination__item pagination__prev">Vorige</a>
            <a href="#" class="pagination__item pagination__number">1</a>
            <a href="#" class="pagination__item pagination__number pagination__current">2</a>
            <span class="pagination__item pagination__dots">...</span>
            <a href="#" class="pagination__item pagination__number">12</a>
            <a href="#" class="pagination__item pagination__next">Volgende</a>
         </div>

      </div>

   </main>

<?php get_footer(); ?>
