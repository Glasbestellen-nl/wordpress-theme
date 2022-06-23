<?php
get_header();
$term_id = get_queried_object_id();
$configurator = get_field( 'configurator', 'term_' . $term_id ); ?>

<div class="hero hero--shadow">

	<div class="hero__inner">

		<div class="container">

			<div class="hero__body text-center">

				<div class="hero__header">
					<h1 class="h1 hero__title"><?php echo ( get_field( 'second_title', 'term_' . $term_id ) ) ? get_field( 'second_title', 'term_' . $term_id ) : single_term_title(); ?></h1>
				</div>

				<div class="hero__buttons">
					<div class="hero__button">
						<?php if ( $configurator ) { ?>
							<a href="<?php echo get_term_link( $configurator, 'startopstelling' ); ?>" class="hero__button-btn btn btn--primary btn--large btn--next"><?php _e( 'Op maat samenstellen', 'glasbestellen' ); ?></a>
						<?php } ?>
					</div>
					<div class="hero__button">
						<span class="hero__button-btn btn btn--<?php echo ( $configurator ) ? 'secondary' : 'primary'; ?> btn--large btn--next js-popup-form" data-formtype="lead" data-popup-title="<?php _e( 'Offerte aanvragen', 'glasbestellen' ); ?>"><?php _e( 'Ontvang offerte', 'glasbestellen' ); ?></span>
					</div>
				</div>

				<?php if ( ( ! $configurator ) && ( ! get_field( 'hide_hero_button_cta', 'term_' . $term_id ) ) ) { ?>
					<span class="hero__button-cta space-above"><?php _e( 'Binnen 1 dag in je mail!', 'glasbestellen' ); ?></span>
				<?php } ?>

				<?php if ( get_field( 'show_sticker', 'term_' . $term_id ) ) { ?>
					<div class="hero__sticker d-none d-lg-block">
						<div class="sticker">
							<div class="sticker__body">
								<span class="sticker__text"><?php _e( 'Laten plaatsen?', 'glasbestellen' ); ?></span>
								<span class="sticker__text sticker__text--highlighted"><?php _e( 'Geen probleem!', 'glasbestellen' ); ?></span>
							</div>
						</div>
					</div>
				<?php } ?>

			</div>

		</div>

	</div>

	<img src="<?php echo gb_get_cover_image_url( 'term_' . $term_id ); ?>" class="hero__background">

</div>

<main class="main-section main-section--space-around">

	<div class="container">

		<div class="row">

			<div class="col-12 col-md-12 col-lg-<?php echo ( get_field( 'review_category', 'term_' . $term_id  ) ) ? '7' : '12'; ?>">

				<section class="section text space-lg-right">

					<?php
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<div class="breadcrumbs space-below">', '</div>' );
					}
					echo '<h2 class="h1">' . sprintf( __( '%s op maat', 'glasbestellen' ), single_term_title( null, false ) ) . '</h2>';
					echo term_description();
					?>

				</section>

			</div>

			<?php
			if ( $reviews = gb_get_reviews( $number = 14, get_field( 'review_category', 'term_' . $term_id ) ) ) { ?>

				<div class="col-12 col-md-12 col-lg-5">

				<section class="section">

					<strong class="h3"><?php _e( 'Wat onze klanten zeggen..', 'glasbestellen' ); ?></strong>

					<div class="card rotator js-rotator">

						<?php foreach ( $reviews as $review ) { ?>

							<div class="rotator__item js-rotator-item">

							<article class="review">

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
													echo '<div class="fas fa-star ' . $class . '"></div> ';
												}
												?>
											</div>
										</div>

									<?php } ?>

								</div>

								<div class="review__body">
									<div class="text text--small review__text">
										<?php echo wpautop( get_the_excerpt( $review->ID ) ); ?>
									</div>
								</div>

							</article>

							</div>

						<?php } ?>

					</div>

				</section>

				</div>

			<?php } ?>

		</div>

	</div>

	<?php if ( $gallery_images = get_field( 'gallery_images', 'term_' . $term_id ) ) { ?>

		<div class="area area--grey">

			<div class="container">

				<section class="row gallery js-bricks">

				<?php foreach ( $gallery_images as $image ) { ?>

					<div class="col-6 col-md-4 col-lg-3 js-brick">

						<a href="<?php echo $image['url']; ?>" class="gallery__item fancybox" data-fancybox="gallery" rel="product-images" title="<?php echo $image['caption']; ?>">
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>" class="gallery__image" />
						</a>

					</div>

				<?php } ?>

				</section>

			</div>

		</div>

	<?php } ?>

	<?php if ( get_field( 'youtube_videos', 'term_' . $term_id ) ) { ?>

		<div class="area">

			<div class="container">

				<header class="divider divider--line-behind divider--centered">
					<strong class="divider__content h2"><?php _e( 'Informatie video\'s', 'glasbestellen' ); ?></strong>
				</header>

				<div class="row">

					<?php
					while ( have_rows( 'youtube_videos', 'term_' . $term_id ) ) {
						the_row(); ?>

						<div class="space-below col-12 col-md-6">
							<div class="embed-container space-below">
								<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php the_sub_field( 'youtube_video_id' ); ?>?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
							<span class="h5 text-center"><?php the_sub_field( 'video_caption' ); ?></span>
						</div>

					<?php } ?>

				</div>
			</div>
		</div>

	<?php } ?>

	<div class="area">

		<div class="container">

			<?php if ( have_rows( 'usps', 'term_' . $term_id ) ) { ?>

				<header class="divider divider--line-behind divider--centered">
				<strong class="divider__content h2"><?php _e( 'Redenen om voor ons te kiezen', 'glasbestellen' ); ?></strong>
				</header>

				<section class="section">

				<div class="row">

					<?php
					while ( have_rows( 'usps', 'term_' . $term_id ) ) {
						the_row(); ?>

						<div class="col-12 col-md-6 col-lg-6">

							<article class="card">

							<div class="card__body" data-mh="usp-card-body">

								<strong class="h4 card__title"><?php the_sub_field( 'title' ); ?></strong>
								<div class="text card__text">
									<?php echo wpautop( get_sub_field( 'description' ) ); ?>
								</div>

							</div>

							</article>

						</div>

					<?php } ?>

				</div>

				</section>

			<?php } ?>

			<?php if ( have_rows( 'faq', 'term_' . $term_id ) ) { ?>

				<header class="divider divider--line-behind divider--centered">
				<strong class="divider__content h2"><?php _e( 'Veelgestelde vragen', 'glasbestellen' ); ?></strong>
				</header>

				<section class="section">

				<div class="row">

					<?php
					while ( have_rows( 'faq', 'term_' . $term_id ) ) {
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

				</section>

			<?php } ?>

			<div class="divider divider--line-behind divider--centered divider--end">
				<div class="divider__content">
				<span class="btn btn--primary btn--large btn--next js-popup-form" data-formtype="lead" data-popup-title="<?php _e( 'Offerte aanvragen', 'glasbestellen' ); ?>"><?php _e( 'Ontvang offerte', 'glasbestellen' ); ?></span>
				</div>
			</div>

		</div>

	</div>

	<?php if ( $seo_content = get_field( 'seo_content', 'term_' . $term_id ) ) { ?>

		<div class="area">
			<div class="container">
				<arcticle class="text">
				<?php echo wpautop( $seo_content ); ?>
				</article>
			</div>
		</div>

	<?php } ?>

</main>

<?php get_footer(); ?>
