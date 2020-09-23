<?php
function gb_explanations_shortcode_callback( $atts = [] ) {

   $html = '';

   if ( empty( $atts['configurator_id'] ) ) return;
   $configurator = gb_get_configurator( $atts['configurator_id'] );

   if ( $configurator->have_steps() ) {
      while ( $configurator->have_steps() ) {
         $configurator->the_step();
         $explanation_id = $configurator->get_step_explanation_id();
         if ( ! $explanation_id ) continue;
         $explanation = get_post( $explanation_id );
         if ( ! $explanation ) continue;
         $html .= '<h2>' . $explanation->post_title . '</h2>';
         $html .= $explanation->post_content;
      }
   }

   return $html;
}
add_shortcode( 'gb_explanations', 'gb_explanations_shortcode_callback' );
