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

   add_role(
      'employee',
      'Employee',
      [
         'read' => true,
         'edit_posts' => true,
         'delete_posts' => true
      ]
   );
}
add_action('after_setup_theme', 'gb_add_user_roles');

function gb_add_user_role_caps() {

   $role = get_role('employee');

   $role->add_cap('manage_woocommerce');
   $role->add_cap('edit_shop_order');
   $role->add_cap('read_published_shop_order');
   $role->add_cap('edit_others_shop_orders');
   $role->add_cap('edit_published_shop_orders');
   $role->add_cap('publish_shop_orders');
   $role->add_cap('delete_shop_order');
   $role->add_cap('delete_others_shop_orders');
   $role->add_cap('read_shop_order');
   $role->add_cap('read_private_shop_orders');
   $role->add_cap('edit_private_shop_orders');
   $role->add_cap('delete_private_shop_orders');
   $role->add_cap('edit_post');
   $role->add_cap('edit_posts');
   $role->add_cap('publish_posts');
   $role->add_cap('delete_post');
   $role->add_cap('delete_posts');
   $role->add_cap('read_post');

   $roles = array(
      'administrator',
      'editor',
      'employee'
   );

   foreach ($roles as $role_name) {
      $role = get_role($role_name);
      $role->add_cap('manage_crm');
   }
}
add_action('init', 'gb_add_user_role_caps', 1);

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
