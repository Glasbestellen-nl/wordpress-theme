<?php get_header(); ?>

   <main class="main-section main-section--space-around main-section--grey">

      <div class="container">

         <section class="page-header page-header--centered page-header--large">

            <h1 class="h1 page-header__headline page-header__headline--large"><?php _e( 'Klanttevredenheid is wat ons drijft', 'glasbestellen' ); ?></h1>
            <span class="subline page-header__subline space-below"><?php _e( 'Onze klanten beoordelen ons gemiddeld met', 'glasbestellen' ); ?>:</span>

            <div class="rating space-below">
               <div class="stars stars--large rating__stars">
                  <?php
                  for ( $i = 1; $i <= 5; $i ++ ) {
                     $checked_class = ( $i <= gb_get_review_average( false, null, 0 ) ) ? 'star--checked' : '';
                     echo '<div class="fas fa-star star ' . $checked_class . '"></div> ';
                  }
                  ?>
               </div>
               <strong class="rating__number rating__number--light-bg"><?php echo gb_get_review_average( true ); ?></strong>
            </div>

            <span class="btn btn--primary btn--next space-above space-below js-popup-form" data-formtype="review" data-popup-title="<?php _e( 'Ervaring schrijven', 'glasbestellen' ); ?>"><?php _e( 'Review schrijven', 'glasbestellen' ); ?></span>
            <div class="caption">
               <?php echo '...' . sprintf( __( 'of via <a href="%s" target="_blank">Facebook</a> of <a href="%s" target="_blank">Google</a>', 'glasbestellen' ), 'https://www.facebook.com/pg/glasbestellen.nl/reviews/', 'http://search.google.com/local/writereview?placeid=ChIJQ09hFjOZxkcRKJSdguzRcTg' ); ?>
            </div>

         </section>

         <?php if ( have_posts() ) { ?>

            <div class="row js-bricks">

               <?php
               while ( have_posts() ) {
                  the_post(); ?>

                  <div class="col-12 col-lg-6 js-brick">

                     <div class="card">

                        <article class="review">

                           <div class="review__header">

                              <div class="review__title">
                                 <strong class="h4 h-default"><?php the_title(); ?></strong>
                              </div>

                              <?php if ( $rating = get_field( 'rating' ) ) { ?>

                                 <div class="review__rating rating rating--review">
                                    <div class="stars rating__stars">
                                       <?php
                                       for ( $i = 1; $i <= 5; $i ++ ) {
                                          $class = 'star';
                                          if ( $i <= $rating ) {
                                             $class .= ' star--checked';
                                          }
                                          echo '<div class="fas fa-star ' . $class . '"></div> ';
                                       }
                                       ?>
                                    </div>
                                 </div>

                              <?php } ?>

                           </div>

                           <div class="review__body">

                              <div class="text review__text">
                                 <?php the_content(); ?>
                                 <p><?php echo '- ' . get_post_meta( get_the_id(), 'name', true ); ?></p>
                              </div>

                              <?php if ( $responses = get_comments( ['post_id' => get_the_id()] ) ) { ?>
                                 <div class="review__responses">
                                    <?php foreach ( $responses as $response ) { ?>

                                       <div class="review__response text">
                                          <h3 class="h5 review__response-title"><?php echo sprintf( __( 'Reactie van %s', 'glasbestellen' ), get_bloginfo( 'name' ) ); ?></h3>
                                          <div class="review__response-body">
                                             <?php echo wpautop( $response->comment_content ); ?>
                                          </div>
                                       </div>

                                    <?php } ?>
                                 </div>
                              <?php } ?>

                           </div>

                        </article>

                     </div>

                  </div>

               <?php } ?>

            </div>

         <?php } ?>

      </div>

   </main>

<?php get_footer(); ?>
