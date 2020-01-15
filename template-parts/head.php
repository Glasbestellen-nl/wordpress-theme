<!DOCTYPE html>
<html <?php language_attributes(); ?>>

   <head>

      <?php if ( $gtm_container_id = get_option( 'gtm_container_id' ) ) { ?>
         <!-- Google Tag Manager -->
         <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
         new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
         j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
         'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
         })(window,document,'script','dataLayer','<?php echo $gtm_container_id; ?>');</script>
         <!-- End Google Tag Manager -->
      <?php } ?>

      <meta charset="<?php bloginfo( 'charset' ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php wp_title( false ); ?></title>
      <?php wp_head(); ?>
   </head>

   <body <?php body_class(); ?>

      <?php if ( isset( $gtm_container_id ) ) { ?>
         <!-- Google Tag Manager (noscript) -->
         <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $gtm_container_id; ?>"
         height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
         <!-- End Google Tag Manager (noscript) -->
      <?php } ?>

      <?php wp_body_open(); ?>
