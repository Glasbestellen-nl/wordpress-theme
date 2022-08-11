<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product; ?>

<ul class="links-list large-space-below">

    <?php if ( $product->get_faq_page_url() ) { ?>
        <li class="links-list__item"><i class="fas fa-question-circle links-list__icon"></i> <a href="<?php echo $product->get_faq_page_url(); ?>" class="links-list__link" rel="nofollow" target="_blank"><?php _e( 'Veelgestelde vragen', 'glasbestellen' ); ?></a></li>
    <?php } ?>
    <?php if ( $product->get_explanation_page_url() ) { ?>
        <li class="links-list__item"><i class="fas fa-cog links-list__icon"></i> <a href="<?php echo $product->get_explanation_page_url(); ?>" class="links-list__link" rel="nofollow" target="_blank"><?php _e( 'Uitleg stappen configurator', 'glasbestellen' ); ?></a></li>
    <?php } ?>
    <?php if ( $product->get_info_file_url( 'corrections' ) ) { ?>
        <li class="links-list__item"><i class="fas fa-arrows-alt-h links-list__icon"></i> <a href="<?php echo $product->get_info_file_url( 'corrections' ); ?>" class="links-list__link" rel="nofollow" target="_blank"><?php _e( 'Glascorrecties', 'glasbestellen' ); ?></a></li>
    <?php } ?>
    <?php if ( $product->get_info_file_url( 'measurement' ) ) { ?>
        <li class="links-list__item"><i class="fas fa-ruler-combined links-list__icon"></i> <a href="<?php echo $product->get_info_file_url( 'measurement' ); ?>" class="links-list__link" rel="nofollow" target="_blank"><?php _e( 'Meetinstructie', 'glasbestellen' ); ?></a></li>
    <?php } ?>
    <?php if ( $product->get_info_file_url( 'assembly' ) ) { ?>
        <li class="links-list__item"><i class="fas fa-download links-list__icon"></i> <a href="<?php echo $product->get_info_file_url( 'assembly' ); ?>" class="links-list__link" rel="nofollow" target="_blank"><?php _e( 'Download montagehandleiding', 'glasbestellen' ); ?></a></li>
    <?php } ?>
    <?php if ( $product->get_info_file_url( 'fittings' ) ) { ?>
        <li class="links-list__item"><i class="fas fa-info-circle links-list__icon"></i> <a href="<?php echo $product->get_info_file_url( 'fittings' ); ?>" class="links-list__link" rel="nofollow" target="_blank"><?php _e( 'Beslag informatie', 'glasbestellen' ); ?></a></li>
    <?php } ?>

</ul>