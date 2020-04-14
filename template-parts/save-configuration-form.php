<?php
if ( ! empty( $_GET['metadata'] ) ) {
   $configurator = gb_get_configurator( $_GET['metadata'] );
   ?>

   <form method="post" class="js-form-validation" novalidate>

      <div class="text text--small">
         <p><?php _e( 'Wilt u nog even nadenken voor u besteld? Geen probleem! Laat uw naam en e-mailadres achter en ontvang uw samenstelling per e-mail. Zo kunt u gemakkelijk later beslissen.', 'glasbestellen' ); ?></p>
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

      </div>

      <button class="btn btn--primary btn--block btn--next" type="submit"><?php _e( 'Opslaan voor later', 'glasbestellen' ); ?></button>

      <input type="hidden" name="configurator_id" value="<?php echo $configurator->get_id(); ?>">
      <input type="hidden" name="configuration" value='<?php echo json_encode( $configurator->get_configuration() ); ?>'>

      <?php get_template_part( 'template-parts/form-hidden-fields' ); ?>

   </form>

<?php } ?>
