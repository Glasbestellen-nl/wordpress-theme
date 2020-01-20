<?php
/**
 * Enqueues scripts and stylesheets
 */
function gb_enqueue_scripts() {

   global $post;

   $theme = wp_get_theme();
   $version = $theme->get('Version');

   // CSS
   wp_enqueue_style( 'style', get_stylesheet_uri(), [], $version );
   wp_enqueue_style( 'grid', get_template_directory_uri() . '/assets/css/grid.css' );
   wp_enqueue_style( 'normalize', get_template_directory_uri() . '/assets/css/normalize.css' );
   wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/fontawesome-all.css' );

   // Scripts
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'masonry' );
   wp_enqueue_script( 'lazysizes-js', get_template_directory_uri() . '/assets/js/lazysizes.min.js', null, true );
   wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', [], $version, true );

   if ( is_singular( 'configurator' ) ) {
      wp_enqueue_script( 'configurator-js', get_template_directory_uri() . '/assets/js/configurator.js', ['jquery', 'main-js'], $version, true );
   }

   if ( gb_is_cart_page() ) {
      wp_enqueue_script( 'cart-js', get_template_directory_uri() . '/assets/js/cart.js', ['jquery', 'main-js'], $version, true );
   }

   // Localize scripts
   wp_localize_script( 'main-js', 'gb',
      array(
         'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
         'ajaxNonce'  => wp_create_nonce( GB_NONCE ),
         'requestURI' => $_SERVER['REQUEST_URI'],
         'msg' => [
            'enterField'             => __( 'Vul a.u.b. dit veld in.', 'glasbestellen' ),
            'dimensionValueTooSmall' => __( 'Voer een maat in groter of gelijk aan {0}.', 'glasbestellen' ),
            'dimensionValueTooLarge' => __( 'Voer een maat in kleiner of gelijk aan {0}.', 'glasbestellen' ),
            'enterValidEmail'        => __( 'Vul a.u.b. een geldig e-mail adres in.', 'glasbestellen' ),
            'filesSelected'          => __( 'bijlage(s) geselecteerd.', 'glasbestellen' )
         ],
         'configuratorId' => ( is_singular( 'configurator' ) ) ? $post->ID : false
      )
   );

}
add_action( 'wp_enqueue_scripts', 'gb_enqueue_scripts' );

/**
 * Enqueues admin scripts and stylesheets
 */
function gb_admin_enqueue_scripts() {

   // CSS
   wp_enqueue_style( 'admin', get_template_directory_uri() . '/assets/css/admin.css' );

   // Scripts
   wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/assets/js/admin.js', ['jquery'] );

   // Localize scripts
   wp_localize_script( 'admin-js', 'gb',
      array(
         'ajaxUrl' => admin_url( 'admin-ajax.php' ),
         'msg' => [
            'sureDeleteLead' => __( 'Weet je zeker dat je deze lead wilt verwijderen?', 'glasbestellen' )
         ]
      )
   );


}
add_action( 'admin_enqueue_scripts', 'gb_admin_enqueue_scripts' );
