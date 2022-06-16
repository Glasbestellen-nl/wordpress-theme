<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$review_category = get_field( 'review_category' );
$reviews = ( $review_category ) ? gb_get_reviews( -1, $review_category ) : false; 
if ( $reviews ) {
?>

    <div class="large-space-above" id="reviews">

        <header class="large-space-below">
            <strong class="h2"><?php _e( 'Wat onze klanten zeggen..', 'glasbestellen' ); ?></strong>
        </header>

        <div class="row space-below">

            <?php
            $reviews_count = 0;
            $reviews_show = isset( $_GET['show_all_reviews'] ) ? count( $reviews ) : 6;
            foreach ( $reviews as $review ) {
                $reviews_count ++;
                if ( $reviews_count > $reviews_show ) break; ?>

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

        <?php if ( ! isset( $_GET['show_all_reviews'] ) ) { ?>
            <div class="text-center">
                <a href="<?php echo add_query_arg( 'show_all_reviews', 'true' ); ?>#reviews"><?php printf( __( 'Alle %s ervaringen bekijken', 'glasbestellen' ), count( $reviews ) ); ?> &raquo;</a>
            </div>
        <?php } ?>

    </div>

<?php } ?>
