<!DOCTYPE html>
<html <?php language_attributes(); ?>>

   <head>

      <?php do_action( 'gb_top_of_head' ); ?>

      <meta charset="<?php bloginfo( 'charset' ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
      <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri();?>/assets/images/favicon.ico"/>
      <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() . '/assets/images/apple-touch-icon.png'; ?>">
      <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri() . '/assets/images/favicon-32x32.png'; ?>">
      <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri() . '/assets/images/favicon-16x16.png'; ?>">
      <title><?php wp_title( false ); ?></title>
      <?php wp_head(); ?>
   </head>

   <body <?php body_class(); ?>>

      <?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>

      <?php wp_body_open(); ?>
