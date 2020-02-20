<?php if ( $configurator->have_steps() ) {

   $count = 0;
   while ( $configurator->have_steps() ) {
      $configurator->the_step();
      $count ++; ?>

      <div class="v-step js-v-step<?php echo $configurator->is_step_done() ? ' v-step--done' : ''; ?>" data-step-id="<?php echo $configurator->get_step_id(); ?>" data-step-title="<?php echo $configurator->get_step_placeholder(); ?>">

         <h2 class="h4 v-step__heading"><?php echo sprintf( __( 'Stap %d: %s', 'glasbestellen' ), $count, $configurator->get_step_title() ); ?></h2>

         <div class="v-step__body">

            <div class="v-step__edit-button">
               <i class="fas fa-pen"></i>
            </div>

            <div class="v-step__content">

               <?php if ( $configurator->is_step_done() ) { ?>
                  <span class="v-step__label"><?php echo $configurator->get_formatted_step_configuration(); ?></span>
               <?php } else { ?>
                  <span class="v-step__label v-step__label--placeholder"><?php echo $configurator->get_step_placeholder(); ?></span>
               <?php } ?>

               <?php if ( $configurator->get_step_price() ) { ?>
                  <span class="v-step__price">+ <?php echo Money::display( $configurator->get_step_price() ); ?></span>
               <?php } ?>

            </div>

            <?php if ( $configurator->get_step_image() ) { ?>
               <div class="v-step__thumbnail d-none d-md-block">
                  <img src="<?php echo $configurator->get_step_image(); ?>" class="v-step__thumbnail-img">
               </div>
            <?php } ?>

         </div>

      </div>

   <?php }
}
?>

<?php if ( $configurator->is_configuration_done() ) { ?>
   <div class="text text-center">
      <p><?php _e( 'U heeft alle stappen voltooid. Plaats uw product in de winkelwagen om verder te gaan.' ); ?></p>
   </div>
<?php } ?>
