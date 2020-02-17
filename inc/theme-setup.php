<?php
/**
 * Creates custom database tables
 */
function gb_create_db_tables() {

   global $wpdb;

   $charset_collate = $wpdb->get_charset_collate();

   // Create leads table
   $table_name = $wpdb->prefix . 'leads';

   $query_1 = "CREATE TABLE $table_name (
      lead_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      lead_content text COLLATE utf8mb4_unicode_ci NOT NULL,
      lead_relation bigint(20) unsigned NOT NULL,
      lead_date datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      PRIMARY KEY (lead_id)
   ) $charset_collate;";

   // Create lead metadata table
   $table_name = $wpdb->prefix . 'leadmeta';

   $query_2 = "CREATE TABLE $table_name (
      meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
      lead_id bigint(20) unsigned NOT NULL,
      meta_key varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      meta_value longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
      PRIMARY KEY (meta_id)
   ) $charset_collate;";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( [$query_1, $query_2] );

}
add_action( 'after_switch_theme', 'gb_create_db_tables' );

/**
 * Adds user roles
 */
function gb_add_user_roles() {

   // Customer role
   add_role(
       'relation',
       __( 'Relatie', 'glasbestellen' ),
       array(
           'read'         => true,
           'edit_posts'   => false,
           'delete_posts' => false,
       )
   );

}
add_action( 'after_switch_theme', 'gb_add_user_roles' );

/**
 * Creates custom upload directories
 */
function gb_create_custom_directories() {

   $attachments_dirname = gb_get_lead_attachments_dir();

   if ( ! file_exists( $attachments_dirname ) )
      wp_mkdir_p( $attachments_dirname );

}
add_action( 'after_switch_theme', 'gb_create_custom_directories' );

/**
 * Sets excerpt length
 */
function gb_excerpt_length() {
   if ( is_singular( 'product' ) ) {
      return 30;
   }
   return 20;
}
add_filter( 'excerpt_length', 'gb_excerpt_length' );

/**
 * Loads scripts in footer
 */
function gb_footer_scripts() { ?>

   <!-- Async font awesome css -->
   <script type="text/javascript">
      (function() {
         var css = document.createElement('link');
         css.href = '<?php echo site_url(); ?>/wp-content/themes/glasbestellen/assets/css/fontawesome-all.css';
         css.rel = 'stylesheet';
         css.type = 'text/css';
         document.getElementsByTagName('head')[0].appendChild(css);
      })();
   </script>

   <?php
}
add_action( 'wp_footer', 'gb_footer_scripts' );
