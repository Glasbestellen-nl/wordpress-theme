<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$product_cat = get_first_term_by_id( get_the_id(), 'product_cat' );
$technical_details = get_field( 'technical_details' );

if ( $technical_details ) { ?>

    <table class="details-table">
        <tbody>

            <?php
            $rows_count = 0;
            while ( have_rows( 'technical_details' ) ) {
                the_row();
                $rows_count ++;
                $class = ( $rows_count % 2 ) ? 'details-table__row' : 'details-table__row details-table__row--even'; ?>

                <tr class="<?php echo $class; ?>">
                    <td class="details-table__col"><?php the_sub_field( 'label' ); ?></td>
                    <td class="details-table__col"><?php the_sub_field( 'description' ); ?></td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
<?php
} else {

    $technical_details = get_field( 'technical_details', 'term_' . $product_cat );
    if ( $technical_details ) {
        $count = 0;
        while ( have_rows( 'technical_details', 'term_' . $product_cat ) ) {
        the_row();
        $count ++; ?>

            <?php if ( count( $technical_details ) > 1 && $count == 2 ) { ?>
                <div id="hidden_technical_details_tables" class="d-none">
            <?php } ?>

            <div class="large-space-below">

                <header class="space-below">
                    <strong><?php the_sub_field( 'title' ); ?></strong>
                    <?php if ( get_sub_field( 'subline' ) ) { ?>
                        <p><?php the_sub_field( 'subline' ); ?></p>
                    <?php } ?>
                </header>

                <div class="space-below">

                    <?php if ( get_sub_field( 'rows' ) ) { ?>
                        <div>
                        <table class="details-table">
                            <tbody>
                                <?php
                                $rows_count = 0;
                                while ( have_rows( 'rows' ) ) {
                                    the_row();
                                    $rows_count ++;
                                    $class = ( $rows_count % 2 ) ? 'details-table__row' : 'details-table__row details-table__row--even'; ?>

                                    <tr class="<?php echo $class; ?>">
                                    <td class="details-table__col"><?php the_sub_field( 'label' ); ?></td>
                                    <td class="details-table__col"><?php the_sub_field( 'description' ); ?></td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    <?php } ?>
                </div>

                <?php if ( $count == 1 ) { ?>
                    <span class="link js-show-target-trigger" data-show-target="#hidden_technical_details_tables" data-hide-after="true"><?php _e( 'Meer specificaties tonen' ); ?> <i class="fas fa-arrow-down"></i></span>
                <?php } ?>

            </div>

            <?php
            if ( count( $technical_details ) > 1 && $count == count( $technical_details ) ) 
                echo '</div>';
        }
    }
}
?>