<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$term_id = get_queried_object_id();

if ( get_field( 'show_contact_box', 'term_' . $term_id ) ) { ?>

    <div class="card card--banner large-space-below">

    <div class="card__body">

        <div class="row">
            <div class="col-6 offset-3 col-md-3 offset-md-0 col-lg-2">
                <div class="avatar avatar--banner box-shadow space-sm-below">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/sales-medewerker.jpg'; ?>" class="avatar__image" />
                </div>
            </div>

            <div class="col-md-9 col-lg-10">
                <div class="card__text text text-sm-center space-below">
                <span class="h2"><?php echo get_field( 'contact_box_title', 'term_' . $term_id ) ?></span>
                <p><?php echo get_field( 'contact_box_message', 'term_' . $term_id ); ?></p>
                </div>
                <span class="btn btn--large btn--primary btn--block btn--next js-popup-form" data-formtype="lead" data-popup-title="<?php echo get_field( 'contact_box_btn', 'term_' . $term_id ); ?>"><?php echo get_field( 'contact_box_btn', 'term_' . $term_id ); ?></span>
            </div>

        </div>

    </div>

    </div>

<?php } ?>