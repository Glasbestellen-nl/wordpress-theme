<?php
/**
 * Register products page content submenu
 */
function gb_register_products_submenu() {
	$page = add_submenu_page( 'edit.php?post_type=product', __( 'Pagina content', 'glasbestellen' ), __( 'Pagina content', 'glasbestellen' ), 'edit_posts', 'products-page-content', 'gb_products_content_page' );
	add_action( 'load-' . $page, 'gb_products_page_content_load'  );
}
add_action( 'admin_menu', 'gb_register_products_submenu' );

/**
 * Loads products page content menu page
 */
function gb_products_page_content_load() {

	if ( isset( $_POST['page_content_submit'] ) )	 {

		$data = array(
			'title' 			=> $_POST['page_content_title'],
			'content'			=> stripslashes_deep( $_POST['page_content_text'] ),
			'meta_title' 		=> $_POST['page_meta_title'],
			'meta_description'  => $_POST['page_meta_description']
		);
		update_option( 'product_post_type_content', $data );
		wp_redirect( admin_url( 'edit.php?post_type=product&page=products-page-content&updated=true' ) );
		exit;
	}
}

/**
 * Sets products archive meta title from options value
 */
function gb_products_archive_meta_title( $title ) {
	if ( ! get_query_var( 'is_product_cat_archive' ) ) return $title;
	$page_content = get_option( 'product_post_type_content' );
	if ( ! empty( $page_content['meta_title'] ) ) {
		$title = $page_content['meta_title'] . ' - ' . get_bloginfo( 'name' );
	}
	return $title;
}
add_filter( 'wpseo_title', 'gb_products_archive_meta_title' );

/**
 * Sets products archive meta description from options value
 */
function gb_products_archive_meta_description( $desc ) {
	if ( ! get_query_var( 'is_product_cat_archive' ) ) return $desc;
	$page_content = get_option( 'product_post_type_content' );
	if ( ! empty( $page_content['meta_description'] ) ) {
		$desc = $page_content['meta_description'];
	}
	return $desc;
}
add_filter( 'wpseo_metadesc', 'gb_products_archive_meta_description' );


/**
 * Products page content menu page
 */
function gb_products_content_page() {

	$data = get_option( 'product_post_type_content' ); ?>

	<div class="wrap">

		<h2><?php _e( 'Products page content', 'glasbestellen' ); ?></h2>

		<?php
		if ( isset( $_GET['updated'] ) && esc_attr( $_GET['updated'] ) == 'true' )
			echo '<div class="updated"><p>' . __( 'Content succesvol opgeslagen', 'glasbestellen' ) . '</p></div>';
		?>

		<form method="post" action="<?php admin_url( 'edit.php?post_type=products&page=products-page-content' ); ?>">

			<table class="form-table">

				<tr>
					<th><label for="page_content_title"><?php _e( 'Titel', 'glasbestellen' ); ?>:</label></th>
					<td><input type="text" name="page_content_title" id="page_content_title" class="regular-text"<?php if ( ! empty( $data['title'] ) ) echo 'value="' . $data['title'] . '"'; ?>></td>
				</tr>

				<tr>
					<th><label for="page_meta_title"><?php _e( 'Meta title', 'glasbestellen' ); ?>:</label></th>
					<td><input type="text" name="page_meta_title" id="page_content_title" class="regular-text"<?php if ( ! empty( $data['meta_title'] ) ) echo 'value="' . $data['meta_title'] . '"'; ?>></td>
				</tr>

				<tr>
					<th><label for="page_meta_description"><?php _e( 'Meta description', 'glasbestellen' ); ?>:</label></th>
					<td><textarea rows="5" cols="50" name="page_meta_description"><?php echo ! empty( $data['meta_description'] ) ? $data['meta_description'] : ''; ?></textarea></td>
				</tr>

				<tr>
					<th><label for="page_content_text"><?php _e( 'Content', 'glasbestellen' ); ?>:</label></th>
					<?php $content = ''; if ( ! empty( $data['content'] ) ) $content = $data['content']; ?>
					<td><?php wp_editor( $content, 'page_content_text', array( 'textarea_name' => 'page_content_text' ) ); ?></td>
				</tr>

			</table><!--End .form-table-->

			<?php submit_button( __( 'Opslaan', 'glasbestellen' ), 'primary', 'page_content_submit', false ); ?>

		</form>

	</div><!--End .wrap-->

	<?php
}
