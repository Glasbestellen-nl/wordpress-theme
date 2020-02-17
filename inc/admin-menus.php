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
			'title' 		=> $_POST['page_content_title'],
			'content'	=> stripslashes_deep( $_POST['page_content_text'] ),
		);
		update_option( 'product_post_type_content', $data );
		wp_redirect( admin_url( 'edit.php?post_type=product&page=products-page-content&updated=true' ) );
		exit;
	}
}

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
