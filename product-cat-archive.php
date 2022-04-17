<?php 
get_header(); 
$the_query = new WP_Term_Query([
    'taxonomy'      => 'product_cat',
    'hide_empty'    => false
]);
$terms = $the_query->get_terms();
?>

   <main class="main-section main-section--space-around">

      <div class="container">

         <?php if ( $terms ) { ?>

            <div class="row">

               <?php
               foreach ( $terms as $term ) { 
                   $term_thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                   $term_thumb_url = wp_get_attachment_url( $term_thumb_id ); ?>
                 
                    <div class="col-12 col-md-6 col-lg-4">

                    <article class="teaser teaser--short space-below">

                        <a href="<?php echo get_term_link( $term, 'product_cat' ); ?>" class="teaser__image teaser__image--cover">
                            <img src="<?php echo $term_thumb_url; ?>" alt="<?php echo get_post_meta( $term_thumb_id, '_wp_attachment_image_alt', true ); ?>" class="teaser__image-img">
                        </a>

                        <a href="<?php echo get_term_link( $term, 'product_cat' ); ?>" class="teaser__body teaser__body--full">
                            <h3 class="h-default teaser__headline"><?php echo $term->name; ?></h3>
                        </a>

                    </article>

                    </div>

               <?php } ?>

            </div>

         <?php } ?>

         <div class="row">

            <div class="col">

               <?php $page_content = get_option( 'product_post_type_content' ); ?>

               <section class="text">
                  <h1 class="h1"><?php echo ! empty( $page_content['title'] ) ? $page_content['title'] : post_type_archive_title( '', false ); ?></h1>
                  <?php echo ! empty( $page_content['content'] ) ? wpautop( $page_content['content'] ) : ''; ?>
               </section>

            </div>

         </div>

      </div>

   </main>

<?php get_footer(); ?>