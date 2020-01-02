
<?php if ( $choices = $configurator->get_step_parts( $step_id ) ) { ?>

   <div class="row choices js-choices large-space-below">

      <?php
      foreach ( $choices as $choice ) {
         $classes = ( $configurator->get_step_choice( $step_id ) == $choice['id'] ) ? 'current' : ''; ?>

         <div class="col-6 col-md-6 col-lg-4">

            <div class="choice js-choice <?php echo $classes; ?>" data-choice-value="<?php echo $choice['id']; ?>">

               <div class="choice__body">

                  <div class="choice__image">
                     <img src="<?php echo $choice['img']; ?>" />
                  </div>

               </div>

               <div class="choice__info">
                  <span class="h5 choice__title"><?php echo $choice['title']; ?></span>
                  <?php
                  $price = $configurator->get_part_price_difference( $step_id, $choice['id'] ); ?>
                  <div class="choice__price"><?php echo apply_filters( 'gb_step_part_price_difference', Money::display( $price ), $step_id ); ?></div>
               </div>

            </div>

         </div>

      <?php } ?>

   </div>

   <input type="hidden" name="configuration[<?php echo $step_id; ?>]" class="js-configurator-step-choice" value="<?php echo $configurator->get_step_choice( $step_id ); ?>">
   <button class="btn btn--tertiary btn--next btn--block" type="submit"><?php _e( 'Bevestig', 'glasbestellen' ); ?></button>

<?php } ?>
