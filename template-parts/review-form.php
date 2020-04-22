<form method="post" class="js-form-validation" enctype="multipart/form-data" novalidate>

   <p class="js-error-alert alert alert--danger" style="display: none;"></p>

   <div class="form-group js-form-group">
      <label class="form-label"><?php _e( 'Beoordeling', 'glasbestellen' ); ?>: <span class="req">*</span></label>
      <select name="review[rating]" class="dropdown js-form-validate">
         <?php for ( $i = 1; $i <= 5; $i ++ ) {
            $selected = selected( $i, 5, false );
            $label = $i . ' ' . ( $i > 1 ? __( 'sterren', 'glasbestellen' ) : __( 'ster', 'glasbestellen' ) );
            echo '<option value="' . $i . '" ' . $selected . ' >' . $label . '</option>';
         } ?>
      </select>
   </div>

   <div class="form-group js-form-group">
      <label class="form-label"><?php _e( 'Ervaring titel', 'glasbestellen' ); ?>: <span class="req">*</span></label>
      <input type="text" name="review[title]" class="form-control js-form-validate" data-required="required" />
      <div class="invalid-feedback js-invalid-feedback"></div>
   </div>

   <div class="form-group js-form-group">
      <label class="form-label"><?php _e( 'Beschrijf uw ervaring', 'glasbestellen' ); ?>: <span class="req">*</span></label>
      <textarea name="review[message]" class="form-control js-form-validate" rows="6" placeholder="<?php _e( 'Uw ervaring..', 'glasbestellen' ); ?>" data-required="required"></textarea>
      <div class="invalid-feedback js-invalid-feedback"></div>
   </div>

   <div class="row">

      <div class="form-group js-form-group col-12 col-md-6">
         <label class="form-label"><?php _e( 'Naam', 'glasbestellen' ); ?>: <span class="req">*</span></label>
         <input type="text" name="review[name]" class="form-control js-form-validate" placeholder="Naam" data-required="required" />
         <div class="invalid-feedback js-invalid-feedback"></div>
      </div>

      <div class="form-group js-form-group col-12 col-md-6">
         <label class="form-label"><?php _e( 'E-mail', 'glasbestellen' ); ?>: <span class="req">*</span></label>
         <input type="email" name="review[email]" class="form-control js-form-validate" placeholder="E-mail" data-required="required" />
         <div class="invalid-feedback js-invalid-feedback"></div>
      </div>

   </div>

   <div class="form-group">
      <button class="btn btn--primary btn--block btn--next"><?php _e( 'Verstuur', 'glasbestellen' ); ?></button>
   </div>

   <input type="hidden" name="action" class="js-form-action" value="handle_review_form_submit">

</form>
