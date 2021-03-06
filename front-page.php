<?php get_header(); ?>

   <main class="main-section">

      <div class="container">

         <div class="row">

            <div class="col col-12 col-md-6 col-lg-3">

               <a href="<?php echo get_post_type_archive_link( 'product' ); ?>" class="teaser space-below">

                  <div class="teaser__image teaser__image--cover">
                     <img src="<?php echo get_template_directory_uri() . '/assets/images/glass-home.png'; ?>" alt="Glas op maat" class="teaser__image-img">
                  </div>

                  <div class="teaser__body teaser__body--full">
                     <span class="teaser__subline"><?php _e( 'Klik hier voor al onze', 'glasbestellen' ); ?></span>
                     <h3 class="h-default teaser__headline teaser__headline--large"><?php _e( 'Producten', 'glasbestellen' ); ?></h3>
                  </div>

               </a>

            </div>

            <div class="col col-12 col-md-6 col-lg-3">

               <div class="teaser space-below">

                  <a href="<?php echo get_post_type_archive_link( 'product' ); ?>douchedeur/" class="teaser__image teaser__image--cover">
                     <img src="<?php echo get_template_directory_uri() . '/assets/images/douchedeur.png'; ?>" alt="Glazen douchedeur op maat" class="teaser__image-img">
                  </a>

                  <div class="teaser__body teaser__body--bottom">
                     <a href="<?php echo get_post_type_archive_link( 'product' ); ?>douchedeur/" class="teaser__headline">Douchedeuren</a>
                  </div>

               </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-3">

               <div class="teaser space-below">

                  <a href="<?php echo get_post_type_archive_link( 'product' ); ?>glazen-achterwand-keuken/" class="teaser__image teaser__image--cover">
                     <img src="<?php echo get_template_directory_uri() . '/assets/images/keuken-achterwand.png'; ?>" alt="Glazen keuken achterwand op maat" class="teaser__image-img">
                  </a>

                  <div class="teaser__body teaser__body--bottom">
                     <a href="<?php echo get_post_type_archive_link( 'product' ); ?>glazen-achterwand-keuken/" class="teaser__headline">Keuken achterwanden</a>
                  </div>

               </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-3">

               <div class="teaser space-below">

                  <a href="<?php echo get_post_type_archive_link( 'product' ); ?>douchewand/" class="teaser__image teaser__image--cover">
                     <img src="<?php echo get_template_directory_uri() . '/assets/images/douchewand.png'; ?>" alt="Douchewand op maat" class="teaser__image-img">
                  </a>

                  <div class="teaser__body teaser__body--bottom">
                     <a href="<?php echo get_post_type_archive_link( 'product' ); ?>douchewand/" class="teaser__headline">Douchewanden</a>
                  </div>

               </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-3">

               <div class="teaser space-below">

                  <a href="<?php echo get_post_type_archive_link( 'product' ); ?>glazen-balustrade/" class="teaser__image teaser__image--cover">
                     <img src="<?php echo get_template_directory_uri() . '/assets/images/glazen-balustrade.jpg'; ?>" alt="Glazen balustrade zonder handrailing" class="teaser__image-img">
                  </a>

                  <div class="teaser__body teaser__body--bottom">
                     <a href="<?php echo get_post_type_archive_link( 'product' ); ?>glazen-balustrade/" class="teaser__headline">Glazen balustrade</a>
                  </div>

               </div>

            </div>

            <div class="col col-12 col-md-6 col-lg-3">

               <div class="teaser space-below">

                  <a href="<?php echo get_post_type_archive_link( 'product' ); ?>douchecabine/" class="teaser__image teaser__image--cover">
                     <img src="https://www.glasbestellen.nl/wp-content/uploads/2016/05/Douchecabine-met-zijpaneel-op-muur.jpg" alt="Douchecabine op maat" class="teaser__image-img">
                  </a>

                  <div class="teaser__body teaser__body--bottom">
                     <a href="<?php echo get_post_type_archive_link( 'product' ); ?>douchecabine/" class="teaser__headline">Douchecabines</a>
                  </div>

               </div>

            </div>

            <div class="col col-12 col-md-12 col-lg-6">

               <a href="<?php echo get_post_type_archive_link( 'review' ); ?>" class="teaser space-below">

                  <div class="teaser__image teaser__image--cover">
                     <img src="<?php echo get_template_directory_uri() . '/assets/images/glasbestellen-kantoor.jpg'; ?>" alt="Glasbestellen kantoor" class="teaser__image-img">
                  </div>

                  <div class="teaser__body teaser__body--full">
                     <h3 class="h3 teaser__headline"><?php _e( 'Klanttevredenheid is wat ons drijft', 'glasbestellen' ); ?></h3>
                     <span class="teaser__subline"><?php _e( 'Onze klanten beoordelen ons gemiddeld met', 'glasbestelen' ); ?>:</span>
                     <div class="rating space-above">
                        <div class="stars rating__stars">
                           <?php
                           for ( $i = 1; $i <= 5; $i ++ ) {
                              $checked_class = ( $i <= gb_get_review_average( false, null, 0 ) ) ? 'star--checked' : '';
                              echo '<div class="fas fa-star star ' . $checked_class . '"></div> ';
                           }
                           ?>
                        </div>
                        <span class="rating__number"><?php echo gb_get_review_average( true ); ?></span>
                     </div>
                  </div>

               </a>

            </div>

            <div class="col-12 col-md-12 col-lg-6">

               <div class="row">

                  <div class="col col-12">

                     <div class="teaser teaser--tall space-below">

                        <a href="<?php echo get_post_type_archive_link( 'product' ); ?>spiegels-met-verlichting/" class="teaser__image teaser__image--cover">
                           <img src="<?php echo get_template_directory_uri() . '/assets/images/spiegels-met-verlichting.jpeg'; ?>" alt="Spiegels met verlichting" class="teaser__image-img">
                        </a>

                        <div class="teaser__body teaser__body--bottom">
                           <a href="<?php echo get_post_type_archive_link( 'product' ); ?>spiegels-met-verlichting/" class="teaser__headline">Spiegels met verlichting</a>
                        </div>

                     </div>

                  </div>

                  <div class="col-12 col-md-6 col-lg-6">

                     <div class="teaser space-below">

                        <a href="<?php echo get_post_type_archive_link( 'product' ); ?>beloopbaar-glas/" class="teaser__image teaser__image--cover">
                           <img src="<?php echo get_template_directory_uri() . '/assets/images/beloopbaar-glas-2.png'; ?>" alt="Beloopbaar glas" class="teaser__image-img">
                        </a>

                        <div class="teaser__body teaser__body--bottom">
                           <a href="<?php echo get_post_type_archive_link( 'product' ); ?>beloopbaar-glas/" class="teaser__headline">Beloopbaar glas</a>
                        </div>

                     </div>

                  </div>

                  <div class="col-12 col-md-6 col-lg-6">

                     <div class="teaser space-below">

                        <a href="<?php echo get_post_type_archive_link( 'product' ); ?>glazen-achterwand-keuken/" class="teaser__image teaser__image--cover">
                           <img src="<?php echo get_template_directory_uri() . '/assets/images/glazen-keuken-achterwand-fornuis.png'; ?>" alt="Glazen keuken achterwand fornuis" class="teaser__image-img">
                        </a>

                     </div>

                  </div>

               </div>

            </div>

            <div class="col-12 col-md-12 col-lg-6">

               <section class="text home-text">

                  <?php
                  if ( have_posts() ) {
                     while ( have_posts() ) {
                        the_title( '<h1>', '</h1>' );
                        the_post();
                        the_content();
                     }
                  }
                  ?>

               </section>

            </div>

         </div>

      </div>

   </main>

<?php get_footer(); ?>
