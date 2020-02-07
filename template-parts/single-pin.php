<div class="pin">

   <div class="row">

      <div class="col-12 col-md-5 col-lg-5">
         <a href="<?php echo get_the_post_thumbnail_url(); ?>" class="fancybox">
            <img data-src="<?php echo get_the_post_thumbnail_url(); ?>" class="lazyload pin__image space-below" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>">
         </a>
      </div>

      <div class="col-12 col-md-7 col-lg-7">

         <div class="space-around">

            <div class="text space-below">
               <h1 class="h2"><?php the_title(); ?></h1>
               <?php the_content(); ?>
            </div>

            <?php if ( $terms = get_the_terms( get_the_id(), 'inspiratie-categorie' ) ) { ?>
               <div class="pin__tags taggers large-space-below">
                  <?php foreach ( $terms as $term ) { ?>
                     <a href="<?php echo get_term_link( $term->term_id ); ?>" class="tagger"><?php echo strtolower( $term->name ); ?></a>
                  <?php } ?>
               </div>
            <?php } ?>

            <div class="pin__buttons">
               <div class="row">
                  <?php
                  if ( ! empty( $terms ) ) {
                     if ( $post_id = gb_get_product_id_by_string( $terms[0]->name ) ) { ?>
                        <div class="col-12 col-lg-6">
                           <a href="<?php echo get_permalink( $post_id ); ?>" class="btn btn--primary btn--block btn--next pin__button"><?php _e( 'Meer informatie', 'glasbestellen' ); ?></a>
                        </div>
                     <?php
                     }
                  } ?>
                  <div class="col-12 col-lg-6">
                     <span class="btn btn--secondary btn--block btn--next pin__button js-popup-form" data-formtype="lead"><?php _e( 'Offerte aanvragen', 'glasbestellen' ); ?></span>
                  </div>
               </div>
            </div>

         </div>

      </div>

   </div>

</div>
