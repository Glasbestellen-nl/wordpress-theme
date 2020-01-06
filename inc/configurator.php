<?php
/**
 * Add configurator body classes
 */
function gb_configurator_body_class( $class ) {
   if ( is_tax( 'startopstelling' ) || is_singular( 'configurator' ) ) {
      $class[] = 'body--grey';
   }
   // Adds javascript handler
   if ( is_singular( 'configurator' ) ) {
      $class[] = 'js-configurator';
   }
   return $class;
}
add_action( 'body_class', 'gb_configurator_body_class' );

/**
 * Hide main nav in configurator
 */
function gb_configurator_hide_main_nav( $show_nav ) {
   if ( is_tax( 'startopstelling' ) || is_singular( 'configurator' ) ) {
      $show_nav = false;
   }
   return $show_nav;
}
add_filter( 'gb_show_main_nav', 'gb_configurator_hide_main_nav' );

/**
 * Changes step part price difference output based on step id
 */
function gb_filter_part_price_difference( $value, $step_id ) {

   if ( in_array( $step_id, ['glasstype', 'coating'] ) ) {
      $value = sprintf( __( '%s per m2', 'glasbestellen' ), $value );
   }
   elseif ( $step_id == 'rotate_direction' ) {
      return;
   }
   return '+ ' . $value;
}
add_filter( 'gb_step_part_price_difference', 'gb_filter_part_price_difference', 10, 2 );

/**
 * Adds configurator meta boxes
 */
function gb_add_configurator_meta_boxes() {
   add_meta_box( 'configurator-settings-meta-box', __( 'Settings', 'glasbestellen' ), 'gb_configurator_settings_meta_box_callback', 'configurator' );
}
add_action( 'add_meta_boxes', 'gb_add_configurator_meta_boxes' );

/**
 * Renders configurator settings meta box
 */
function gb_configurator_settings_meta_box_callback( $post ) {

   if ( $value = gb_get_configurator_settings( $post->ID ) ) {
      $value = json_encode( $value, JSON_PRETTY_PRINT );
   } else {
      $value = '';
   }

   $html = '<p><textarea name="configurator_settings" class="large-text tab-support js-tab-support" rows="20">' . $value . '</textarea></p>';

   echo $html;
}

/**
 * Saves configurator post settings
 */
function gb_save_configurator( $post_id ) {

   if ( ! empty( $_POST['configurator_settings'] ) ) {

      // Strip slashes
      $value = stripslashes( $_POST['configurator_settings'] );

      // Check is valid json
      if ( json_decode( $value ) != NULL ) {

         // Update to database
         update_post_meta( $post_id, 'configurator_settings', json_decode( $value, true ) );
      }
   }
}
add_action( 'save_post_configurator', 'gb_save_configurator' );

/**
 * AJAX handles get single step html
 */
function gb_get_configurator_step_html() {

   if ( ! empty( $_GET['step_id'] ) && ! empty( $_GET['configurator_id'] ) ) {

      $step_id = $_GET['step_id'];
      $configurator_id = $_GET['configurator_id'];

      $file = TEMPLATEPATH . '/template-parts/configurator/step.php';

      if ( file_exists( $file ) ) {

         $configurator = gb_get_configurator( $configurator_id );
         ob_start();
         require_once( $file );
         $html = ob_get_clean();
         echo $html;
      }
   }

   wp_die();
}
add_action( 'wp_ajax_get_configurator_step_html', 'gb_get_configurator_step_html' );
add_action( 'wp_ajax_nopriv_get_configurator_step_html', 'gb_get_configurator_step_html' );

/**
 * AJAX handles get steps html
 */
function gb_get_configurator_steps_html() {

   if ( ! empty( $_GET['configurator_id'] ) ) {

      $configurator_id = $_GET['configurator_id'];

      $file = TEMPLATEPATH . '/template-parts/configurator/steps.php';

      if ( file_exists( $file ) ) {

         $configurator = gb_get_configurator( $configurator_id );
         ob_start();
         require_once( $file );
         $html = ob_get_clean();
         echo $html;
      }
   }
   wp_die();

}
add_action( 'wp_ajax_get_configurator_steps_html', 'gb_get_configurator_steps_html' );
add_action( 'wp_ajax_nopriv_get_configurator_steps_html', 'gb_get_configurator_steps_html' );

/**
 * AJAX handles get total configuration price
 */
function gb_get_configurator_total_price() {

   if ( ! empty( $_GET['configurator_id'] ) ) {
      $configurator_id = $_GET['configurator_id'];
      $configurator = gb_get_configurator( $configurator_id );
      echo Money::display( $configurator->get_total_price() );
   }
   wp_die();

}
add_action( 'wp_ajax_get_configurator_total_price', 'gb_get_configurator_total_price' );
add_action( 'wp_ajax_nopriv_get_configurator_total_price', 'gb_get_configurator_total_price' );

/**
 * AJAX handles configurator step submit
 */
function gb_handle_configurator_form_submit() {

   $response = [];

   if ( ! empty( $_POST['configurator_id'] ) && ! empty( $_POST['step_id'] ) ) {

      $configurator_id = $_POST['configurator_id'];
      $step_id = $_POST['step_id'];

      if ( ! empty( $_SESSION['configuration'][$configurator_id] ) ) {
         $configuration = $_SESSION['configuration'][$configurator_id];
      } else {
         $configuration = [];
      }

      if ( ! empty( $_POST['configuration'] ) ) {
         $configuration[$step_id] = $_POST['configuration'][$step_id];
         $configurator = gb_get_configurator( $configurator_id, false );
         $configurator->set_configuration( $configuration );

         if ( $errors = $configurator->get_errors() ) {
            $response['errors'] = $errors;
         } else {
            $_SESSION['configuration'][$configurator_id] = $configurator->get_configuration();

            if ( $configurator->configuration_done() ) {
               $response['done'] = true;
            }
         }
      }
   }

   wp_send_json( $response );

   wp_die();

}
add_action( 'wp_ajax_handle_configurator_form_submit', 'gb_handle_configurator_form_submit' );
add_action( 'wp_ajax_nopriv_handle_configurator_form_submit', 'gb_handle_configurator_form_submit' );

function gb_handle_configurator_to_cart() {

   if ( ! empty( $_POST['configurator_id'] ) ) {

      $configurator_id = $_POST['configurator_id'];

      // Get configurator object
      $configurator = gb_get_configurator( $configurator_id );

      if ( ! $configurator->configuration_done() ) wp_die();

      // Get cart object
      $cart = gb_get_cart();

      // Add item to cart
      $price         = $configurator->get_total_price();
      $summary       = $configurator->get_summary();
      $configuration = $configurator->get_configuration();
      $cart->add_item( $configurator_id, $price, 1, $summary, $configuration );

      // Store items back in session
      gb_update_cart_session_items( $cart->get_items() );

      // Return cart page url
      $cart_url = get_permalink( get_page_id_by_template( 'cart.php' ) );

      echo $cart_url;

   }

   wp_die();
}
add_action( 'wp_ajax_handle_configurator_to_cart', 'gb_handle_configurator_to_cart' );
add_action( 'wp_ajax_nopriv_handle_configurator_to_cart', 'gb_handle_configurator_to_cart' );

function gb_validate_configurator_input() {

   $response = [];

   if ( ! empty( $_GET['configurator_id'] ) ) {

      $configurator = gb_get_configurator( $_GET['configurator_id'] );

      if ( ! empty( $_GET['field'] ) && ! empty( $_GET['value'] ) ) {
         $configurator->validate_input( $_GET['field'], $_GET['value'] );
      }

      if ( $configurator->get_errors() ) {
         $response['errors'] = $configurator->get_errors();
      }
   }

   wp_send_json( $response );

   wp_die();
}
add_action( 'wp_ajax_validate_configurator_input', 'gb_validate_configurator_input' );
add_action( 'wp_ajax_nopriv_validate_configurator_input', 'gb_validate_configurator_input' );

function gb_get_configurator_choice_enlargement_html() {

   $html = '';

   if ( ! empty( $_GET['part_id'] ) ) {
      ob_start();
      $file = TEMPLATEPATH . '/template-parts/configurator/choice-enlargement.php';
      if ( file_exists( $file ) ) {
         require_once( $file );
      }
      $html = ob_get_clean();
   }
   echo $html;
   wp_die();

}
add_action( 'wp_ajax_get_configurator_choice_enlargement_html', 'gb_get_configurator_choice_enlargement_html' );
add_action( 'wp_ajax_nopriv_get_configurator_choice_enlargement_html', 'gb_get_configurator_choice_enlargement_html' );

function gb_get_configurator( $configurator_id = 0, $auto_set = true ) {

   $base = 'Configurator';

   $classes = [
      'single-showerdoor' => 'Showerdoor\Single',
      'double-showerdoor' => 'Showerdoor\Double',
      'showerdoor-with-sidepanel-in-clamps' => 'Showerdoor\With_Sidepanel_In_Clamps',
      'showerdoor-with-sidepanel-in-profile' => 'Showerdoor\With_Sidepanel_In_Profile',
      'showerdoor-on-sidepanel-in-clamps' => 'Showerdoor\On_Sidepanel_In_Clamps',
      'showerdoor-on-sidepanel-in-profile' => 'Showerdoor\On_Sidepanel_In_Profile',
   ];
   $classes = apply_filters( 'available_configurators', $classes );

   if ( $type = gb_get_configurator_type( $configurator_id ) ) {
      if ( ! empty( $classes[$type] ) ) {
         $class = $base . '\\' . $classes[$type];
         if ( class_exists( $class ) ) {
            $configurator = new $class( $configurator_id );

            // If there is already something configured
            if ( ! empty( $_SESSION['configuration'][$configurator_id] ) && $auto_set ) {
               $configurator->set_configuration( $_SESSION['configuration'][$configurator_id] );
            }
            return $configurator;
         }
      }
      return false;
   }
   return false;
}

function gb_get_configurator_type( $configurator_id ) {
   $settings = gb_get_configurator_settings( $configurator_id );
   return ( isset( $settings['type'] ) ) ? $settings['type'] : false;
}

function gb_get_configurator_settings( $configurator_id ) {
   if ( $settings = get_post_meta( $configurator_id, 'configurator_settings', true ) ) {
      return $settings;
   }
   return false;
}
