<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$review_category = get_field( 'review_category' );
$review_avarage = gb_get_review_average( true, $review_category, 1 );
if ( ! $review_category || ! $review_avarage ) exit;
$reviews = $review_category ? gb_get_reviews( -1, $review_category ) : false; ?>

<div class="rating justify-content-start scroll-to js-scroll-to" data-scroll-to="#reviews">
    <div class="stars rating__stars" title="<?php _e( 'Ervaringen', 'glasbestellen' ); ?>">
        <?php
        for ( $i = 1; $i <= 5; $i ++ ) {
            $checked_class = ( $i <= $review_avarage ) ? 'star--checked' : '';
            echo '<div class="fas fa-star star ' . $checked_class . '"></div>';
        }
        ?>
    </div>
    <span class="rating__number rating__number--light-bg">9.8</span>
    <span class="link rating__count">(<?php echo count( $reviews ); ?>)</span>
</div>

