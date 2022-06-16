<?php
$terms = get_the_terms( get_the_id(), 'inspiratie-categorie' );
?>

<div class="pin">

   <div class="row">

      <div class="col-12 col-md-5 col-lg-5">
         <a href="<?php echo get_the_post_thumbnail_url(); ?>" class="fancybox">
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" class="pin__image space-below" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ); ?>">
         </a>
      </div>

      <div class="col-12 col-md-7 col-lg-7">

         <div class="space-around">

            <div class="text space-below">
               <h1 class="h2"><?php the_title(); ?></h1>
               <?php the_content(); ?>
            </div>

            <?php if ( $terms ) { ?>
               <div class="pin__tags taggers large-space-below">
                  <?php foreach ( $terms as $term ) { ?>
                     <a href="<?php echo get_term_link( $term->term_id ); ?>" class="tagger"><?php echo strtolower( $term->name ); ?></a>
                  <?php } ?>
               </div>
            <?php } ?>

            <div class="pin__buttons">
               <div class="row">
                  <?php
                  if ( $terms ) {
                     if ( $product_cat_id = get_field( 'product_cat', 'term_' . $terms[0]->term_id ) ) { ?>
                        <div class="col-12 col-lg-6">
                           <a href="<?php echo get_term_link( $product_cat_id, 'product_cat' ); ?>" class="btn btn--primary btn--block btn--next pin__button"><?php _e( 'Meer informatie', 'glasbestellen' ); ?></a>
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
