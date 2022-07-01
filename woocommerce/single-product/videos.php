<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$video_args = ['autoplay' => 1, 'rel' => 0];
$video_types = ['product', 'measure', 'assembly', 'explainer'];
?>

<div class="video-list">
    <div class="row">

    <?php
    foreach ( $video_types as $video_type ) {
        $youtube_id = get_field( $video_type . '_video_youtube_id' );
        if ( $youtube_id ) {
            $url = add_query_arg( $video_args, 'https://www.youtube.com/embed/' . $youtube_id );

            switch ( $video_type ) {
                case 'product';
                    $product_caption = get_field( 'product_video_caption' );
                    $caption = $product_caption ? $product_caption : __( 'Product video', 'glasbesellen' );
                    break;
                case 'measure';
                    $caption = __( 'Hoe meten?', 'glasbesellen' );
                    break;
                case 'assembly';
                    $caption = __( 'Hoe monteren?', 'glasbesellen' );
                    break;
                case 'explainer';
                    $caption = __( 'Uitleg configurator', 'glasbesellen' );
                    break;
            }
            ?>

            <div class="col-4 col-md-4">
                <div class="video-list__item">
                    <a href="<?php echo $url; ?>" data-fancybox class="video-list__item-canvas lr-video fancybox-various fancybox.iframe">
                        <div class="lr-video__play"></div>
                        <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/0.jpg" class="lr-video__img">
                    </a>
                    <span class="video-list__item-caption"><?php echo $caption; ?></span>
                </div>
            </div>

        <?php
        }
    }
    ?>

    </div>
</div>