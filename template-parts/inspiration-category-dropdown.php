<select class="dropdown js-url-dropdown">
   <option selected="true" disabled="disabled"><?php _e( 'Filter op product', 'glasbestellen' ); ?></option>
   <option value="<?php echo get_post_type_archive_link( 'inspiratie' ); ?>"><?php _e( 'Alle producten', 'glasbestellen' ); ?></option>
   <?php
   if ( $categories = get_terms( 'taxonomy=inspiratie-categorie&hide_empty=0' ) ) {
      foreach ( $categories as $category ) {
         $selected = selected( get_queried_object_id(), $category->term_id, false );
         echo '<option value="' . get_term_link( $category ) . '" ' . $selected . '>' . $category->name . '</option>';
      }
   }
   ?>
</select>
