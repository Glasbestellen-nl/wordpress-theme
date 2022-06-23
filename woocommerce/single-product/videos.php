<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( get_field( 'measure_video_youtube_id' ) || get_field( 'assembly_video_youtube_id' ) || get_field( 'explainer_video_youtube_id' )) {

    $video_args = ['autoplay' => 1, 'rel' => 0]; ?>

    <div class="video-list">

        <div class="row">

            <?php
            if ( $youtube_id = get_field( 'measure_video_youtube_id' ) ) {
                $url = add_query_arg( $video_args, 'https://www.youtube.com/embed/' . $youtube_id ); ?>
                <div class="col-4 col-md-4">
                <div class="video-list__item">
                    <a href="<?php echo $url; ?>" data-fancybox class="video-list__item-canvas lr-video fancybox-various fancybox.iframe">
                        <div class="lr-video__play"></div>
                        <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/maxresdefault.jpg" class="lr-video__img">
                    </a>
                    <span class="video-list__item-caption"><?php _e( 'Hoe meten?', 'glasbestellen' ); ?></span>
                </div>
                </div>
            <?php } ?>

            <?php if ( $youtube_id = get_field( 'assembly_video_youtube_id' ) ) {
                $url = add_query_arg( $video_args, 'https://www.youtube.com/embed/' . $youtube_id ); ?>
                <div class="col-4 col-md-4">
                <div class="video-list__item">
                    <a href="<?php echo $url; ?>" data-fancybox class="video-list__item-canvas lr-video fancybox-various fancybox.iframe">
                        <div class="lr-video__play"></div>
                        <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/maxresdefault.jpg" class="lr-video__img">
                    </a>
                    <span class="video-list__item-caption"><?php _e( 'Hoe monteren?', 'glasbestellen' ); ?></span>
                </div>
                </div>
            <?php } ?>

            <?php if ( $youtube_id = get_field( 'explainer_video_youtube_id' ) ) {
                $url = add_query_arg( $video_args, 'https://www.youtube.com/embed/' . $youtube_id ); ?>
                <div class="col-4 col-md-4">
                <div class="video-list__item">
                    <a href="<?php echo $url; ?>" data-fancybox class="video-list__item-canvas lr-video fancybox-various fancybox.iframe">
                        <div class="lr-video__play"></div>
                        <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/maxresdefault.jpg" class="lr-video__img">
                    </a>
                    <span class="video-list__item-caption"><?php _e( 'Uitleg configurator', 'glasbestellen' ); ?></span>
                </div>
                </div>
            <?php } ?>
        </div>

    </div>

<?php } ?>