<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$term_id = get_queried_object_id();

if ( get_field( 'usps', 'term_' . $term_id ) ) { ?>

    <strong class="h2 space-above space-below"><?php _e( 'Redenen om voor ons te kiezen', 'glasbestellen' ); ?></strong>

    <div class="row space-below">

        <?php
        while ( have_rows( 'usps', 'term_' . $term_id ) ) {
            the_row(); ?>

            <div class="col-12 col-lg-6">
                <article class="large-space-below">
                    <strong class="h4"><i class="fas fa-check heading-icon"></i> <?php the_sub_field( 'title' ); ?></strong>
                    <?php echo wpautop( get_sub_field( 'description' ) ); ?>
                </article>
            </div>

        <?php } ?>

    </div>

<?php } ?>
