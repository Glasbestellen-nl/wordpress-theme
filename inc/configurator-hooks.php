<?php
class Configurator_Hooks {

   private static $instance = null;

   public static function get_instance() {
      if ( is_null( self::$instance ) ) {
         self::$instance = new self();
      }
      return self::$instance;
   }

   public function __construct() {

      // Actions
      add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'] );
      add_action( 'wp', [$this, 'render_configurator_price_table_array'] );

      // AJAX request handlers
      add_action( 'wp_ajax_get_configuration', [$this, 'handle_ajax_get_configuration'] );
      add_action( 'wp_ajax_nopriv_get_configuration', [$this, 'handle_ajax_get_configuration'] );
      add_action( 'wp_ajax_get_configurator_total_price', [$this, 'handle_ajax_get_configuration_total_price'] );
      add_action( 'wp_ajax_nopriv_get_configurator_total_price', [$this, 'handle_ajax_get_configuration_total_price'] );
      add_action( 'wp_ajax_handle_configurator_form_submit', [$this, 'handle_ajax_configurator_form_submit'] );
      add_action( 'wp_ajax_nopriv_handle_configurator_form_submit', [$this, 'handle_ajax_configurator_form_submit'] );
      add_action( 'wp_ajax_handle_configurator_to_cart', [$this, 'handle_ajax_configurator_to_cart'] );
      add_action( 'wp_ajax_nopriv_handle_configurator_to_cart', [$this, 'handle_ajax_configurator_to_cart'] );

      // Filters
      add_filter( 'gb_step_part_price_difference', [$this, 'filter_part_price_difference'], 10, 2 );
   }

   public function enqueue_scripts() {

      global $post;

      if ( ! is_singular( 'product' ) ) return;
      $product = wc_get_product( $post->ID );
      if ( ! $product || ! $product->is_type( 'configurable' ) ) return;

      $theme = wp_get_theme();
      $version = $theme->get( 'Version' );
      $configurator_id = get_post_meta( $post->ID, 'configurator', true );
      $configurator_settings = get_post_meta( $configurator_id, 'configurator_settings', true );

      $configurator_settings['steps'] = array_map( [$this, 'map_configurator_steps'], $configurator_settings['steps'] );

      $data = [
         'productId' => $post->ID,
         'configuratorId' => $configurator_id,
         'settings' => $configurator_settings
      ];

      wp_enqueue_script( 'configurator', get_template_directory_uri() . '/assets/js/configurator.js', ['jquery', 'wp-element', 'main-js'], $version, true );
      wp_localize_script( 'configurator', 'configurator', $data );
   }

   public function handle_ajax_get_configuration() {

      $response = [];

      if ( empty( $_POST['configurator_id'] ) ) wp_die();
   
      $session_configuration = gb_get_configuration_session( $_POST['configurator_id'] );
      if ( $session_configuration ) {
         $response['configuration'] = $session_configuration;
      } else {
         $configurator = gb_get_configurator( $_POST['configurator_id'] );
         $response['configuration'] = $configurator->get_default_configuration();
      }

      wp_send_json( $response );
      wp_die();
   }

   public function handle_ajax_get_configuration_total_price() { 

      $response = [];

      if ( ! empty( $_POST['product_id'] ) ) {
         $product = wc_get_product( $_POST['product_id'] );
         $response['price_html'] = wc_price( wc_get_price_including_tax( $product ) );
      }

      wp_send_json( $response );
      wp_die();
   }

   public function handle_ajax_configurator_form_submit() {

      $response = [];

      if ( empty( $_POST['product_id'] ) || empty( $_POST['configuration'] ) ) wp_die();
   
      $product = wc_get_product( $_POST['product_id'] );
      $configurator = $product->get_configurator();
      $configurator->update( $_POST['configuration'] );
      $configurator_id = $configurator->get_id();
      $_SESSION['configuration'][$configurator_id] = $configurator->get_configuration();
      $response['price_html'] = wc_price( wc_get_price_including_tax( $product ) );
   
      wp_send_json( $response );
      wp_die();
   }

   public function handle_ajax_configurator_to_cart() {

      global $woocommerce;

      $response = [];
   
      if ( empty( $_POST['product_id'] ) ) wp_die();
   
      $product = wc_get_product( $_POST['product_id'] );
      $configurator = $product->get_configurator();
      $summary = $configurator->get_summary( $_POST['message'] );
      $cart_item_data = [
         'custom_price'  => $configurator->get_total_price(),
         'configuration_summary' => $summary,
         'configuration' => $configurator->get_configuration()
      ];
      $woocommerce->cart->add_to_cart( $_POST['product_id'], $_POST['quantity'], null, null, $cart_item_data );
      $woocommerce->cart->calculate_totals();
      $woocommerce->cart->set_session();
      $woocommerce->cart->maybe_set_cart_cookies();
   
      gb_unset_configuration_session( $configurator->get_id() );
   
      $response['url'] = wc_get_cart_url();
   
      wp_send_json( $response );
      wp_die();   
   }

   public function filter_part_price_difference( $value, $step_id ) {
      if ( in_array( $step_id, ['glasstype', 'coating'] ) ) {
         $value = sprintf( __( '%s per m2', 'glasbestellen' ), $value );
      }
      elseif ( $step_id == 'rotate_direction' ) {
         return;
      }
      return '+ ' . $value;   
   }

   public function render_configurator_price_table_array() {

      global $post;

      if ( ! empty( $_GET['show_price_table'] ) && is_singular( 'configurator' ) ) {   
         $configurator = gb_get_configurator( $post->ID );
         echo '<pre>';
         var_dump( $configurator->get_price_table() );
         echo '</pre>';
      }
   }

   public function map_configurator_steps( $step ) {
      if ( empty( $step['options'] ) ) return $step;
      $step['options'] = array_map( function( $option ) {
         if ( ! empty( $option['child_steps'] ) && ! is_array( $option['child_steps'] ) ) {
            $option['child_steps'] = [$option['child_steps']];
         }
         return $option;
      }, $step['options'] );
      return $step;
   }
}
Configurator_Hooks::get_instance();

