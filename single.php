<?php get_header(); ?>

   <?php
   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post(); ?>

         <main class="main-section main-section--space-around main-section--grey">

            <div class="container">

               <section class="layout">

                  <div class="layout__column box-shadow">

                     <div class="row">

                        <div class="col-12 col-lg-8">

                           <?php
                           if ( function_exists( 'yoast_breadcrumb' ) ) {
                              yoast_breadcrumb( '<div class="breadcrumbs space-below">', '</div>' );
                           }
                           ?>

                           <article class="text">
                              <?php
                              the_title( '<h1>', '</h1>' );
                              the_content();
                               ?>
                           </article>

                           <?php if ( $tags = get_the_tags() ) { ?>
                              <div class="taggers space-below">
                                 <?php foreach ( $tags as $tag ) { ?>
                                    <a href="<?php echo get_term_link( $tag->term_id ); ?>" class="tagger"><?php echo strtolower( $tag->name ); ?></a>
                                 <?php } ?>
                              </div>
                           <?php } ?>

                        </div>

                        <div class="col-12 col-lg-4">

                           <div class="row">

                              <?php if ( $product = gb_find_product_by_string( get_the_title() ) ) { ?>

                                 <div class="col-12 col-md-6 col-lg-12">

                                    <div class="card" data-mh="action-box">
                                       <div class="card__body text-center">
                                          <h2 class="h3 card__title"><?php echo sprintf( __( '%s nodig?', 'glasbestellen' ), $product->post_title ); ?></h2>
                                          <div class="text space-below">
                                             <p class="card__text"><?php _e( 'Laat ons u overtuigen op de product pagina', 'glasbestellen' ); ?></p>
                                          </div>
                                          <a href="<?php echo get_permalink( $product ); ?>" class="btn btn--primary btn--block btn--next"><?php _e( 'Meer informatie', 'glasbestellen' ); ?></a>
                                       </div>
                                    </div>

                                 </div>

                              <?php } ?>

                              <div class="col-12 col-md-6 col-lg-12">

                                 <div class="card" data-mh="action-box">
                                    <div class="card__body text text-center">
                                       <h2 class="h3 card__title"><?php _e( 'Neem contact op', 'glasbestellen' ); ?></h2>
                                       <p class="card__text space-below"><?php _e( 'Bel of mail ons voor advies. Wij informeren u graag!', 'glasbestellen' ); ?></p>
                                       <span class="btn btn--secondary btn--block btn--next js-popup-form" data-formtype="lead"><?php _e( 'Neem contact op', 'glasbestellen' ); ?></a>
                                    </div>
                                 </div>

                              </div>

                           </div>

                        </div>

                     </div>

                  </div>

               </section>

            </div>

         </main>

      <?php } ?>

   <?php } ?>

<?php get_footer(); ?>
