<div class="row modal__row">

   <div class="col-12 col-md-7 col-lg-8">

      <div class="modal__column modal__column--main">

         <form class="js-configurator-step-form">

            <p class="js-error-alert alert alert--danger" style="display: none;"></p>

            <?php
            $base = TEMPLATEPATH . '/template-parts/configurator/type';
            if ( $step_type = $configurator->get_step_type( $step_id ) ) {

               $file = $base . '/' . $step_type . '.php';
               if ( file_exists( $file ) ) {
                  require_once( $file );
               }
               do_action( 'configurator_step_form_html', $step_type );

            } else {
               require_once( $base . '/choices.php' );
            }
            ?>

            <input type="hidden" name="configurator_id" value="<?php echo $configurator->get_id(); ?>">
            <input type="hidden" name="step_id" value="<?php echo $step_id; ?>">
            <input type="hidden" name="action" class="js-form-action" value="handle_configurator_form_submit">

         </form>

      </div>

   </div>

   <div class="col-12 col-md-5 col-lg-4">

      <div class="modal__column modal__column--side">

         <?php
         if (
            $configurator->get_step_parts( $step_id )
            && ! $configurator->get_step_field( 'show_info', $step_id )
         ) { ?>

            <div class="choice__enlargement js-choice-enlargement">
            </div>

         <?php } else { ?>

            <div class="modal__info text text--small">
               <h3 class="h3 h-underlined"><?php _e( 'Informatie', 'glasbestellen' ); ?></h3>
               <?php echo $configurator->get_step_description( $step_id ); ?>
            </div>

         <?php } ?>

      </div>

   </div>

</div>
