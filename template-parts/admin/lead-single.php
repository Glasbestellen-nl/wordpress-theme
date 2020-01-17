<div class="wrap">

   <h2><?php echo __( 'Lead', 'glasbestellen' ) . ' #' . $_GET['lead_id']; ?></h2>

   <form class="js-lead-form" method="post">

      <div id="poststuff">

         <div id="post-body" class="metabox-holder columns-2">

            <div id="postbox-container-2" class="postbox-container">

               <div class="postbox postbox-space-large">

                  <h2 class="hndle"><?php _e( 'Lead informatie', 'glasbestellen' ); ?></h2>

                  <div class="inside">

                     <div class="form-row form-row-underlined">
                        <label class="form-row-label"><?php _e( 'Naam', 'glasbestellen' ); ?>:</label>
                        <div class="form-row-text"><?php echo $relation->get_name() ? $relation->get_name() : __( 'Onbekend relatie', 'glasbestellen' ); ?></div>
                     </div>

                     <div class="form-row form-row-underlined">
                        <label class="form-row-label"><?php _e( 'Bericht', 'glasbestellen' ); ?>:</label>
                        <div class="form-row-text"><?php echo $lead->get_content(); ?></div>
                     </div>

                     <div class="form-row form-row-underlined">
                        <label class="form-row-label"><?php _e( 'Email', 'glasbestellen' ); ?>:</label>
                        <div class="form-row-text"><?php echo $relation->get_email(); ?></div>
                     </div>

                     <div class="form-row form-row-underlined">
                        <label class="form-row-label"><?php _e( 'Telefoonnummer', 'glasbestellen' ); ?>:</label>
                        <div class="form-row-text"><?php echo $relation->get_phone(); ?></div>
                     </div>

                     <div class="form-row form-row-underlined">
                        <label class="form-row-label"><?php _e( 'Woonplaats', 'glasbestellen' ); ?>:</label>
                        <div class="form-row-text"><?php echo $relation->get_residence(); ?></div>
                     </div>

                     <?php if ( $attachments = $lead->get_attachments() ) { ?>
                        <div class="form-row form-row-underlined">
                           <label class="form-row-label"><?php _e( 'Bijlages', 'glasbestellen' ); ?>:</label>
                           <ul class="attachment-list">
                              <?php
                              $count = 0;
                              foreach ( $attachments as $attachment ) {
                                 $count ++;
                                 echo '<li><a href="' . $attachment['url'] . '" target="_blank">' . __( 'Bijlage', 'glasbestellen' ) . ' ' . $count . '</a></li>';
                              }
                              ?>
                           </ul>
                        </div>
                     <?php } ?>

                     <div class="form-row">
                        <label for="lead_note_field" class="form-row-label"><?php _e( 'Notities', 'glasbestellen' ); ?>:</label>
                        <textarea name="lead_note" id="lead_note_field" class="regular-text textarea-large js-blur-update-lead" rows="7" placeholder="<?php _e( 'Notities', 'glasbestellen' ); ?>"><?php echo $lead->get_note(); ?></textarea>
                     </div>

                  </div>

               </div>

               <div class="postbox postbox-space-large">

                  <h2 class="hndle"><?php _e( 'Technische informatie', 'glasbestellen' ); ?></h2>

                  <div class="inside">

                     <?php if ( $request_uri = CRM::get_lead_meta( $_GET['lead_id'], 'request_uri', true ) ) { ?>
                        <div class="form-row">
                           <label class="form-row-label"><?php _e( 'Request URI', 'glasbestellen' ); ?>:</label>
                           <div class="form-row-text"><?php echo $request_uri; ?></div>
                        </div>
                     <?php } ?>

                     <?php if ( $remote_address = CRM::get_lead_meta( $_GET['lead_id'], 'remote_address', true ) ) { ?>
                        <div class="form-row">
                           <label class="form-row-label"><?php _e( 'IP adres', 'glasbestellen' ); ?>:</label>
                           <div class="form-row-text"><?php echo $remote_address; ?></div>
                        </div>
                     <?php } ?>

                     <?php if ( $gclid = CRM::get_lead_meta( $_GET['lead_id'], 'gclid', true ) ) { ?>
                        <div class="form-row">
                           <label class="form-row-label"><?php _e( 'Google Analytics Client ID', 'glasbestellen' ); ?>:</label>
                           <div class="form-row-text"><?php echo $gclid; ?></div>
                        </div>
                     <?php } ?>

                  </div>

               </div>

               <div class="postbox postbox-space-large">

                  <h2 class="hndle"><?php _e( 'Offline Conversion Tracking', 'glasbestellen' ); ?></h2>

                  <div class="inside">

                     <div class="js-conversion-tracking-dashboard">

                        <?php
                        $conversion_meta = CRM::get_lead_meta( $_GET['lead_id'], 'conversion_data', true );
                        $conversion_data = new Offline_Conversion_Tracking\Conversion_Data( $conversion_meta );
                        $dashboard_ui    = new Offline_Conversion_Tracking\Dashboard_UI;
                        $dashboard_ui->set_conversion_data( $conversion_data );
                        $dashboard_ui->render_fields();
                        ?>

                        <div class="js-items-table">
                           <?php $dashboard_ui->render_table(); ?>
                        </div>

                        <p><?php $dashboard_ui->render_buttons(); ?></p>

                     </div>

                  </div>

               </div>

            </div>

            <div id="postbox-container-1" class="postbox-container">

               <div class="postbox postbox-space-medium">

                  <h2 class="hndle"><?php _e( 'Lead details', 'glasbestellen' ); ?></h2>

                  <div class="inside">

                     <div class="form-row">
                        <label class="form-row-label"><?php _e( 'Datum', 'glasbestellen' ); ?>:</label>
                        <div class="form-row-text"><?php echo $lead->get_date( 'd F Y h:i' ); ?></div>
                     </div>

                     <div class="form-row">
                        <label class="form-row-label"><?php _e( 'Beheerder', 'glasbestellen' ); ?>:</label>
                        <?php if ( $owners = CRM::get_owners() ) { ?>
                           <select name="lead_owner" class="js-change-update-lead">
                              <option value=""><?php _e( 'Beheerder selecteren', 'glasbestellen' ); ?></option>
                              <?php
                              foreach ( $owners as $owner ) {
                                 $selected = selected( $lead->get_owner(), $owner->ID, false );
                                 echo '<option value="' . $owner->ID . '" ' . $selected . '>' . $owner->display_name . '</option>';
                              }
                              ?>
                           </select>
                        <?php } ?>
                     </div>

                     <!-- <div class="form-row">
                        <?php submit_button( __( 'Lead bijwerken', 'glasbestellen' ), 'primary', 'submit_lead', false ); ?>
                     </div> -->

                     <div class="form-row">
                        <div class="form-row-text submitbox">
                           <a href="#" class="submitdelete js-delete-lead"><?php _e( 'Verwijderen', 'glasbestellen' ); ?></a>
                        </div>
                     </div>

                  </div>

               </div>

               <div class="postbox">

                  <h2 class="hndle"><?php _e( 'Lead status', 'glasbestellen' ); ?></h2>

                  <div class="inside">

                     <?php if ( $statuses = CRM::get_lead_statuses() ) { ?>
                        <div class="postbox-checklist">

                           <ul>
                              <?php
                              foreach ( $statuses as $status => $label ) {
                                 $checked = checked( $lead->get_status(), $status, false ); ?>
                                 <li>
                                    <label>
                                       <?php echo '<input type="radio" name="lead_status" class="js-change-update-lead" value="' . $status . '" ' . $checked .  '> ' . $label; ?>
                                    </label>
                                 </li>
                              <?php } ?>
                           </ul>

                        </div>
                     <?php } ?>

                  </div>

               </div>

            </div>

         </div>

      </div>

      <input type="hidden" value="<?php echo $_GET['lead_id']; ?>" name="lead_id">

   </form>

</div>
