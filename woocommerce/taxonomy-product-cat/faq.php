<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$term_id = get_queried_object_id();

if ( get_field( 'faq', 'term_' . $term_id ) ) { ?>

    <strong class="h2 space-below"><?php _e( 'Veelgestelde vragen', 'glasbestellen' ); ?></strong>

    <div class="row large-space-below">

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

<?php } ?>