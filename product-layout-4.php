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

                     <article class="text large-space-below">
                        <h1><?php the_title(); ?></h1>
                        <p><?php echo get_the_excerpt(); ?> <a href="#main_content" class="js-scroll-to" data-scroll-to="#main_content"><?php _e( 'Lees verder', 'glasbestellen' ); ?> &raquo;</a></p>
                     </article>

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

                        <?php if ( ! $archive->get_filters() ) { ?>
                           <span class="arrow-down-bar"><?php echo sprintf( __( 'Kies en stel uw %s samen', 'glasbestellen' ), strtolower( get_the_title() ) ); ?>:</span>
                        <?php } ?>

                        <section class="row product-listings large-space-below">

                           <?php
                           $product_count = 0;
                           $column_width = get_field( 'number_of_columns' ) ? 12 / get_field( 'number_of_columns' ) : 3;
                           while ( $items->have_posts() ) {
                              $items->the_post();
                              $configurator = gb_get_configurator( get_the_id() );
                              $product_count ++; ?>

                              <div class="col-12 col-md-6 col-lg-<?php echo $column_width; ?>">
                                 <?php require( get_template_directory() . '/template-parts/product-listing.php' ); ?>
                              </div>

                           <?php }  ?>

                        </section>

                     <?php } wp_reset_postdata(); ?>

                     <?php if ( get_field( 'show_contact_box' ) ) { ?>

                        <div class="card card--banner large-space-below">

                           <div class="card__body">

                              <div class="space-lg-around">

                                 <div class="row">
                                    <div class="col-6 offset-3 col-md-4 offset-md-4 col-lg-2 offset-lg-5">
                                       <div class="avatar avatar--banner box-shadow space-below">
                                          <img data-src="<?php echo get_template_directory_uri() . '/assets/images/sales-medewerker.jpg'; ?>" class="lazyload avatar__image" />
                                       </div>
                                    </div>

                                    <div class="col-12 col-lg-4 offset-lg-4">
                                       <div class="card__text text text--small text--center space-below">
                                          <span class="h2"><?php echo get_field( 'contact_box_title' ) ?></span>
                                          <p><?php echo get_field( 'contact_box_message' ); ?></p>
                                       </div>
                                       <span class="btn btn--large btn--primary btn--block btn--next js-popup-form" data-formtype="lead" data-popup-title="<?php echo get_field( 'contact_box_btn' ); ?>"><?php echo get_field( 'contact_box_btn' ); ?></span>
                                    </div>

                                 </div>

                              </div>

                           </div>

                        </div>

                     <?php } ?>

                     <section class="text" id="main_content">

                        <?php the_content(); ?>

                        <?php if ( get_field( 'usps' ) ) { ?>

                           <strong class="h2 space-above space-below"><?php _e( 'Redenen om voor ons te kiezen', 'glasbestellen' ); ?></strong>

                           <div class="row space-below">

                              <?php
                              while ( have_rows( 'usps' ) ) {
                                 the_row(); ?>

                                 <div class="col-12 col-lg-6">
                                    <article class="large-space-below">
                                       <strong class="h4"><i class="fas fa-check heading-icon"></i> <?php the_sub_field( 'title' ); ?></strong>
                                       <?php echo wpautop( get_sub_field( 'description' ) ); ?>
                                    </article>
                                 </div>

                              <?php } ?>

                           </div>

                        <?php } ?>

                        <?php if ( $gallery_images = get_field( 'gallery_images' ) ) { ?>

                           <div class="row gallery js-bricks">

                              <?php foreach ( $gallery_images as $image ) { ?>

                                 <div class="col-6 col-md-4 col-lg-3 js-brick">

                                    <a href="<?php echo $image['url']; ?>" class="gallery__item fancybox" rel="product-images" title="<?php echo $image['caption']; ?>">
                                       <img data-src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>" class="lazyload gallery__image" />
                                    </a>

                                 </div>

                              <?php } ?>

                           </div>

                        <?php } ?>

                        <?php
                        if ( $seo_content = get_post_meta( get_the_id(), 'seo_content', true ) ) {
                           echo wpautop( $seo_content );
                        }
                        ?>

                        <?php if ( get_field( 'faq' ) ) { ?>

                           <strong class="h2 space-below"><?php _e( 'Veelgestelde vragen', 'glasbestellen' ); ?></strong>

                           <div class="row large-space-below">

                              <?php
                              while ( have_rows( 'faq' ) ) {
                                 the_row(); ?>

                                 <div class="col-12">

                                    <article class="collapse-box js-collapse-box">

                                       <header class="collapse-box__header">
                                          <strong class="collapse-box__title"><?php the_sub_field( 'question' ); ?></strong>
                                       </header>
                                       <div class="collapse-box__body text">
                                          <?php echo wpautop( get_sub_field( 'answer' ) ); ?>
                                       </div>

                                    </article>

                                 </div>

                              <?php } ?>

                           </div>

                        <?php } ?>

                        <?php
                        if ( get_field( 'review_category' ) ) {
                           $reviews = gb_get_reviews( $number = 6, get_field( 'review_category' ) ); ?>

                           <strong class="h2 space-below"><?php _e( 'Wat onze klanten zeggen..', 'glasbestellen' ); ?></strong>

                           <div class="row">

                              <?php foreach ( $reviews as $review ) { ?>

                                 <div class="col-12 col-md-6">
                                    <div class="card">
                                       <div class="review" data-mh="review">
                                          <div class="review__header">

                                             <div class="review__title">
                                                <strong class="h5 h-default"><?php echo $review->post_title; ?></strong>
                                             </div>

                                             <?php if ( $rating = get_field( 'rating', $review->ID ) ) { ?>

                                                <div class="review__rating rating">
                                                   <div class="stars rating__stars">
                                                      <?php
                                                      for ( $i = 1; $i <= 5; $i ++ ) {
                                                         $class = 'star';
                                                         if ( $i <= $rating ) {
                                                            $class .= ' star--checked';
                                                         }
                                                         echo '<div class="fas fa-star ' . $class . '"></div>';
                                                      }
                                                      ?>
                                                   </div>
                                                </div>

                                             <?php } ?>

                                          </div>

                                          <div class="review__body">
                                             <div class="text text--small review__text">
                                                <?php echo wpautop( $review->post_content ); ?>
                                                <p><?php echo '- ' . get_post_meta( $review->ID, 'name', true ); ?></p>
                                             </div>
                                          </div>

                                       </div>

                                    </div>

                                 </div>

                              <?php } ?>

                           </div>

                        <?php } ?>

                     </section>

                  </div>

               </div>

            </div>

         </main>

      <?php } ?>

   <?php } ?>

<?php get_footer(); ?>
