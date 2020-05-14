<?php
if ( ! empty( $_GET['post_id'] ) && $custom_form_id = get_field( 'custom_form_id', $_GET['post_id'] ) ) {

   $form = gb_get_form_by_id( $custom_form_id );
   $form->render();

} else { ?>

   <form method="post" enctype="multipart/form-data" class="js-form-validation" novalidate>

      <p class="js-error-alert alert alert--danger" style="display: none;"></p>

      <div class="form-group js-form-group">
         <label class="form-label"><?php _e( 'Beschrijf uw wensen en uw situatie', 'glasbestellen' ); ?>: <span class="req">*</span></label>
         <textarea name="lead[content]" class="form-control js-form-validate" data-required="required" rows="6" placeholder="Beschrijf uw wensen en uw situatie"></textarea>
         <div class="invalid-feedback js-invalid-feedback"></div>
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

      <div class="form-group">
         <div class="file-input">
            <label for="lead_files_field" class="file-input__trigger js-file-input-trigger">
               <span class="fas fa-upload file-input__icon"></span>
               <span class="file-input__text js-file-input-trigger-text"><?php _e( 'Upload een foto of tekening', 'glasbestellen' ); ?></span>
            </label>
            <input type="file" class="file-input__field js-file-input-field" id="lead_files_field" multiple>
         </div>
      </div>

      <div class="form-group">
         <button class="btn btn--primary btn--block btn--next" type="submit"><?php _e( 'Verstuur', 'glasbestellen' ); ?></button>
      </div>

      <?php get_template_part( 'template-parts/form-hidden-fields' ); ?>

   </form>

<?php } ?>
