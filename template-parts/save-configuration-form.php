<?php
if ( ! empty( $_GET['metadata'] ) ) {
   $configurator = gb_get_configurator( $_GET['metadata'] );
   ?>

   <form method="post" class="js-form-validation" novalidate>

      <div class="text text--small">
         <p><?php _e( 'Wilt u uw samenstelling als offerte ontvangen? Vul dan uw naam, e-mail en eventuele specifieke wensen in.', 'glasbestellen' ); ?></p>
      </div>

      <div class="row">

         <div class="form-group js-form-group col-12 col-md-6">
            <label class="form-label"><?php _e( 'Naam', 'glasbestellen' ); ?>: <span class="req">*</span></label>
            <input type="text" name="lead[name]" class="form-control js-form-validate" data-required="required" placeholder="<?php _e( 'Naam', 'glasbestellen' ); ?>" />
            <div class="invalid-feedback js-invalid-feedback"></div>
         </div>

         <div class="form-group js-form-group col-12 col-md-6">
            <label class="form-label"><?php _e( 'E-mail', 'glasbestellen' ); ?>: <span class="req">*</span></label>
            <input type="email" name="lead[email]" class="form-control js-form-validate" data-required="required" placeholder="<?php _e( 'E-mail', 'glasbestellen' ); ?>" />
            <div class="invalid-feedback js-invalid-feedback"></div>
         </div>

         <div class="form-group js-form-group col-12 col-md-6">
            <label class="form-label"><?php _e( 'Woonplaats', 'glasbestellen' ); ?>: <span class="req">*</span></label>
            <input type="text" name="lead[residence]" class="form-control js-form-validate" data-required="required" placeholder="<?php _e( 'Woonplaats', 'glasbestellen' ); ?>" />
            <div class="invalid-feedback js-invalid-feedback"></div>
         </div>

         <div class="form-group js-form-group col-12 col-md-6">
            <label class="form-label"><?php _e( 'Telefoonnummer', 'glasbestellen' ); ?>:</label>
            <input type="phone" name="lead[phone]" class="form-control js-form-validate" placeholder="<?php _e( 'Telefoonnummer', 'glasbestellen' ); ?>" />
         </div>

      </div>

      <div class="form-group js-form-group">
         <label class="form-label"><?php _e( 'Heeft u specifieke wensen? (optioneel)', 'glasbestellen' ); ?></label>
         <textarea name="lead[content]" class="form-control js-form-validate" rows="6" placeholder="<?php _e( 'Denk bijvoorbeeld aan montage of afwijkende maten..', 'glasbestellen' ); ?>"></textarea>
         <div class="invalid-feedback js-invalid-feedback"></div>
      </div>

      <button class="btn btn--primary btn--block btn--next space-below" type="submit"><?php _e( 'Mail mij een offerte', 'glasbestellen' ); ?></button>

      <span class="caption"><i class="fas fa-check"></i>&nbsp;&nbsp;<?php _e( 'Deze aanvraag is geheel vrijblijvend.', 'glasbestellen' ); ?></span>

      <input type="hidden" name="configurator_id" value="<?php echo $configurator->get_id(); ?>">
      <input type="hidden" name="configuration" value='<?php echo json_encode( $configurator->get_configuration() ); ?>'>

      <?php get_template_part( 'template-parts/form-hidden-fields' ); ?>

   </form>

<?php } ?>
