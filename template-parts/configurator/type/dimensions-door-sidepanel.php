<div class="row">

   <div class="col-12 col-lg-4">

      <div class="form-group js-form-group">
         <label class="form-label"><?php _e( 'Breedte opening', 'glasbestellen' ); ?> (A):</label>
         <div class="input-group">
            <input type="number" name="configuration[<?php echo $step_id; ?>][opening_width]" class="form-control form-control--addon js-form-validate" value="<?php echo $configurator->get_configured_value( 'opening_width' ); ?>" placeholder="mm" data-required="required" data-validation-rules='<?php echo $configurator->get_validation_rules( $step_id, 'opening_width' ); ?>'>
            <div class="input-group-addon">mm</div>
         </div>
         <div class="invalid-feedback js-invalid-feedback"></div>
      </div>

      <div class="form-group js-form-group">
         <label class="form-label"><?php _e( 'Hoogte deur', 'glasbestellen' ); ?> (B):</label>
         <div class="input-group">
            <input type="number" name="configuration[<?php echo $step_id; ?>][opening_height]" class="form-control form-control--addon js-form-validate" value="<?php echo $configurator->get_configured_value( 'opening_height' ); ?>" placeholder="mm" data-required="required" data-validation-rules='<?php echo $configurator->get_validation_rules( $step_id, 'opening_height' ); ?>'>
            <div class="input-group-addon">mm</div>
         </div>
         <div class="invalid-feedback js-invalid-feedback"></div>
      </div>

      <div class="form-group js-form-group">
         <label class="form-label"><?php _e( 'Breedte deur', 'glasbestellen' ); ?> (C):</label>
         <div class="input-group">
            <input type="number" name="configuration[<?php echo $step_id; ?>][door_width]" class="form-control form-control--addon js-form-validate" value="<?php echo $configurator->get_configured_value( 'door_width' ); ?>" placeholder="mm" data-required="required" data-validation-rules='<?php echo $configurator->get_validation_rules( $step_id, 'door_width' ); ?>'>
            <div class="input-group-addon">mm</div>
         </div>
         <div class="invalid-feedback js-invalid-feedback"></div>
      </div>

      <div class="form-group">
         <button type="submit" class="btn btn--tertiary btn--next btn--block" type="submit"><?php _e( 'Bevestig', 'glasbestellen' ); ?></button>
      </div>

   </div>

   <?php if ( $visual_url = $configurator->get_step_visual( $step_id ) ) { ?>
      <div class="col-12 col-lg-7 offset-lg-1">
         <img src="<?php echo $visual_url; ?>">
      </div>
   <?php } ?>

</div>
