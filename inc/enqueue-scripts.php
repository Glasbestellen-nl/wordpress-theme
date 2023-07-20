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
   wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/assets/css/fancybox.css' );

   // Scripts
   wp_enqueue_script( 'masonry' );
   wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/js/main.js', ['jquery', 'wp-element'], $version, true );

   // Localize scripts
   $l10n = [
      'ajaxUrl'            => admin_url( 'admin-ajax.php' ),
      'ajaxNonce'          => wp_create_nonce( GB_NONCE ),
      'requestURI'         => $_SERVER['REQUEST_URI'],
      'remoteAddress'      => $_SERVER['REMOTE_ADDR'],
      'allowedFileTypes'   => get_allowed_mime_types(),
      'msg' => [
         'enterField'             => __( 'Vul a.u.b. dit veld in.', 'glasbestellen' ),
         'dimensionValueTooSmall' => __( 'Voer een maat in groter of gelijk aan {0}.', 'glasbestellen' ),
         'dimensionValueTooLarge' => __( 'Voer een maat in kleiner of gelijk aan {0}.', 'glasbestellen' ),
         'dimensionMustBeGreaterThan' => __( 'Voer een maat in groter dan {0}', 'glasbestellen' ),
         'dimensionMustBeLessThan' => __( 'Voer een maat in kleiner dan {0}', 'glasbestellen' ),
         'enterValidEmail'        => __( 'Vul a.u.b. een geldig e-mail adres in.', 'glasbestellen' ),
         'filesSelected'          => __( 'bijlage(s) geselecteerd.', 'glasbestellen' ),
         'inspiration'            => __( 'Inspiratie', 'glasbestellen' ),
         'pleaseWait'             => __( 'Bezig..', 'glasbestellen' ),
         'sent'                   => __( 'Verstuurd!', 'glasbestellen' ),
         'fileUploadLimit'        => __( 'Uw bijlages overschrijden het maximale upload limiet van {0}MB. Stuur a.u.b. grotere bijlages naar ' . get_bloginfo( 'admin_email' ) . '.', 'glasbestellen' ),
         'fileTypeNotAllowed'     => __( 'Een van uw bijlages kan niet worden verstuurd, omdat het bestandstype "{0}" is. Probeer een ander bestandstype of mail naar ' . get_bloginfo( 'admin_email' ) . '.' )
      ],
   ];
   if ( is_singular() ) {
      $l10n['postId'] = $post->ID;
   }
   wp_localize_script( 'main-js', 'gb', $l10n );
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
