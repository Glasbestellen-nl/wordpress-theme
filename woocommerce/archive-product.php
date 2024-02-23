<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); 

$term_id = get_queried_object_id();
$excerpt = get_field( 'excerpt', 'term_' . $term_id );
$number_of_columns = get_field( 'number_of_columns', 'term_' . $term_id ); ?>

<main class="main-section main-section--space-around main-section-sm-without-space main-section--grey">

   <div class="container container--sm-without-space">

      <div class="layout layout--sm-full-width">

         <div class="layout__column box-shadow">

            <?php
            if ( function_exists( 'yoast_breadcrumb' ) ) {
               yoast_breadcrumb( '<div id="breadcrumb" class="breadcrumbs small-space-below">', '</div>' );
            }

            ?>
            <article class="text large-space-below">
               <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                  <h1><?php woocommerce_page_title(); ?></h1>
               <?php endif; ?>

               <p><?php echo $excerpt; ?> <a href="#main_content" class="js-scroll-to" data-scroll-to="#main_content"><?php _e( 'Lees verder', 'glasbestellen' ); ?> &raquo;</a></p>
            </article>

            <span class="arrow-down-bar"><?php echo sprintf( __( 'Kies en stel uw %s samen', 'glasbestellen' ), strtolower( single_term_title( null, false ) ) ); ?>:</span>

            <?php
            if ( woocommerce_product_loop() ) {

               //do_action( 'woocommerce_before_shop_loop' );
               
               woocommerce_product_loop_start(); ?>

               <section class="row product-listings large-space-below">

                  <?php
                  $column_width = $number_of_columns ? 12 / $number_of_columns : 3;
                  if ( wc_get_loop_prop( 'total' ) ) {
                     while ( have_posts() ) {
                        the_post();

                        do_action( 'woocommerce_shop_loop' ); ?>

                        <div class="col-6 col-md-6 col-lg-<?php echo $column_width; ?>">
                           <?php wc_get_template_part( 'content', 'product' ); ?>
                        </div>
                        <?php
                     }
                  }
                  ?>

               </section>
               
               <?php
               woocommerce_product_loop_end();

               do_action( 'woocommerce_after_shop_loop' );
            } else {
               do_action( 'woocommerce_no_products_found' );
            }

            wc_get_template_part( 'taxonomy-product-cat/contact-box' );
            ?>

            <section class="text" id="main_content">

               <?php 
               echo term_description(); 

               wc_get_template_part( 'taxonomy-product-cat/usps' );
               
               wc_get_template_part( 'taxonomy-product-cat/gallery-images' );

               if ( $seo_content = get_field( 'seo_content', 'term_' . $term_id ) ) {
                  echo wpautop( $seo_content );
               }

               wc_get_template_part( 'taxonomy-product-cat/faq' );

               wc_get_template_part( 'taxonomy-product-cat/reviews' );
               ?>

            </section>

            <?php
            do_action( 'woocommerce_after_main_content' );
            do_action( 'woocommerce_sidebar' );
            ?>

         </div>

      </div>

   </div>

</main>

<?php get_footer( 'shop' ); ?>