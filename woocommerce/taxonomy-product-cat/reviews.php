<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$term_id = get_queried_object_id();

if ( get_field( 'review_category', 'term_' . $term_id ) ) {
                  
    $reviews = gb_get_reviews( $number = 6, get_field( 'review_category', 'term_' . $term_id ) ); ?>

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