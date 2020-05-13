<?php
// Constants
define( 'GB_NONCE', '8dnnjndds_dn38ndjns009wsP' );

// Composer autoloading
require __DIR__ . '/vendor/autoload.php';

/**
 * Starts a PHP session
 */
function gb_start_session() {
	if ( ! session_id() )
	   session_start();
}
add_action( 'init', 'gb_start_session', 1 );

/**
* Autoloads classes
*/
spl_autoload_register( function( $class ) {

  $file = get_template_directory() . '/class/' . str_replace('\\', '/', $class ) . '.php';

  // Check if file exists, if true then require
  if ( file_exists( $file ) )
     require_once $file;
});

add_theme_support( 'post-thumbnails' );

/**
 * Loads all the files from the inc directory
 */
$files = glob( TEMPLATEPATH . '/inc/*.php' );
foreach ( $files as $file ) {
   require_once $file;
}

$offline_conversion_tracking = new Offline_Conversion_Tracking\Core;


function test_form_builder( $template ) {

	$form_settings = [
		'form_action' => 'test',
		'submit_button_class' => ['btn--block'],
		'fields' => [
			[
				'type'  => 'dropdown',
				'field_name'  => 'width',
				'label' => 'E-mail',
				'options' => [
					[
						'label' => '500 mm',
						'value' => '500'
					]
				]
			],
			[
				'type'  => 'text',
				'field_name'  => 'first_name',
				'label' => 'Voornaam',
				'required' => 'true'
			]
		]
	];

	$form = new Form_Builder\Form_Builder( $form_settings );
	// print_r( $form );

	$form->render();

}
add_action( 'template_include', 'test_form_builder' );
