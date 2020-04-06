<?php
// Template name: Product layout 4
// Template post type: product
get_header(); ?>

   <?php
   if ( have_posts() ) {
      while ( have_posts() ) {
         the_post();
         $archive = new Configurator\Archive( get_the_id(), $_GET ); ?>

         <main class="main-section main-section--space-around main-section-sm-without-space main-section--grey">

            <div class="container container--sm-without-space">

               <div class="layout layout--sm-full-width">

                  <div class="layout__column box-shadow">

                     <?php
                     if ( function_exists( 'yoast_breadcrumb' ) ) {
                        yoast_breadcrumb( '<div class="breadcrumbs small-space-below">', '</div>' );
                     }
                     ?>

                     <section class="text large-space-below">
                        <h1><?php the_title(); ?></h1>
                        <p><?php echo get_the_excerpt(); ?> <a href="#main_content" class="js-scroll-to" data-scroll-to="#main_content"><?php _e( 'Lees verder', 'glasbestellen' ); ?> &raquo;</a></p>
                     </section>

                     <?php if ( $filters = $archive->get_filters() ) { ?>

                        <form method="post" class="filter-bar large-space-below">

                           <div class="row filter-bar__row">

                              <?php
                              foreach ( $filters as $filter ) {
                                 $filter_parent = $filter['value']; ?>

                                 <div class="col-lg-3 filter-bar__col">
                                    <div class="dropdown-group js-dropdown-group">
                                       <select class="dropdown dropdown--addon filter-bar__dropdown js-dropdown" name="filter[<?php echo $filter['value']; ?>]" onchange="this.form.submit()">
                                          <option value="">-- <?php echo $filter['title']; ?> --</option>
                                          <?php
                                          if ( ! empty( $filter['options'] ) ) {
                                             foreach ( $filter['options'] as $option ) {
                                                $selected = '';
                                                if ( ! empty( $_GET[$filter_parent] ) ) {
                                                   $selected = selected( $option['value'], $_GET[$filter_parent] );
                                                }
                                                echo '<option value="' . $option['value'] . '" ' . $selected . '>' . $option['title'] . '</option>';
                                             }
                                          }
                                          ?>
                                       </select>
                                       <div class="dropdown-group-addon dropdown-group-addon--remove js-empty-dropdown" data-submit="true">
                                          <i class="fas fa-times"></i>
                                       </div>
                                    </div>
                                 </div>

                              <?php } ?>

                           </div>

                        </form>

                     <?php } ?>

                     <?php
                     $items = $archive->get_items_query_object();
                     if ( $items->have_posts() ) { ?>

                        <section class="row product-listings large-space-below">

                           <?php
                           while ( $items->have_posts() ) {
                              $items->the_post();
                              $configurator = gb_get_configurator( get_the_id() ); ?>

                              <div class="col-12 col-md-6 col-lg-3">

                                 <div class="product-listing">
                                    <a href="<?php the_permalink(); ?>" class="product-listing__image">
                                       <img data-src="<?php echo get_the_post_thumbnail_url( get_the_id(), 'large' ); ?>" class="lazyload product-listing__image-img" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>">
                                    </a>
                                    <div class="product-listing__body">
                                       <h2 class="h5"><a href="<?php the_permalink(); ?>" class="product-listing__title" data-mh="product-listing-title"><?php the_title(); ?></a></h2>
                                       <div class="product-listing__info">
                                          <span class="product-listing__price"><?php echo sprintf( __( 'v.a. %s', 'glasbestellen' ), Money::display( $configurator->get_total_price( true, true ) ) ); ?></span>
                                          <span class="product-listing__tax"><?php _e( 'Prijs incl. BTW.', 'glasbestellen' ); ?></span>
                                          <span class="product-listing__shipping"><i class="fas fa-shipping-fast"></i> <?php _e( 'Gratis verzending', 'glasbestellen' ); ?></span>
                                       </div>
                                    </div>
                                 </div>

                              </div>

                           <?php }  ?>

                        </section>

                     <?php } wp_reset_postdata(); ?>

                     <div class="row">

                        <div class="col-lg-8 offset-lg-2">

                           <div class="card card--banner">
                              <div class="card__body">

                                 <div class="row">

                                    <div class="col-lg-7 card__column">
                                       <div class="card__text">
                                          <span class="h2"><?php _e( 'Hulp nodig?', 'glasbestellen' ); ?></span>
                                          <div class="text">
                                             <p><?php _e( 'Heeft u hulp nodig of wilt u een offerte ontvangen? We helpen u graag!', 'glasbestellen' ); ?></p>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-lg-5 d-flex align-items-center card__column card__column--last">
                                       <span class="btn btn--large btn--secondary btn--block btn--next js-popup-form" data-formtype="lead" data-popup-title="<?php _e( 'Offerte aanvragen', 'glasbestellen' ); ?>"><?php _e( 'Offerte aanvragen', 'glasbestellen' ); ?></span>
                                    </div>

                                 </div>
                              </div>
                           </div>

                        </div>

                     </div>

                     <article class="text" id="main_content">
                        <?php the_content(); ?>
                     </article>

                  </div>

               </div>

            </div>

         </main>

      <?php } ?>

   <?php } ?>

<?php get_footer(); ?>
