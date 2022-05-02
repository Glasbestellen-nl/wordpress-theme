<?php
/**
 * Registers custom post types
 */
function gb_register_post_types() {

	// Review
	$labels = array(
		'name'                  => _x( 'Ervaring', 'Post Type General Name', 'glasbestellen' ),
		'singular_name'         => _x( 'Ervaring', 'Post Type Singular Name', 'glasbestellen' ),
		'menu_name'             => __( 'Ervaringen', 'glasbestellen' ),
		'name_admin_bar'        => __( 'Ervaring', 'glasbestellen' ),
		'archives'              => __( 'Ervaring archieven', 'glasbestellen' ),
		'attributes'            => __( 'Ervaring attributen', 'glasbestellen' ),
		'parent_item_colon'     => __( 'Parent Ervaring:', 'glasbestellen' ),
		'all_items'             => __( 'Alle Ervaringen', 'glasbestellen' ),
		'add_new_item'          => __( 'Voeg nieuw Ervaring toe', 'glasbestellen' ),
		'add_new'               => __( 'Voeg nieuwe toe', 'glasbestellen' ),
		'new_item'              => __( 'Nieuwe Ervaring', 'glasbestellen' ),
		'edit_item'             => __( 'Bewerk Ervaring', 'glasbestellen' ),
		'update_item'           => __( 'Update Ervaring', 'glasbestellen' ),
		'view_item'             => __( 'Bekijk Ervaring', 'glasbestellen' ),
		'view_items'            => __( 'Bekijk Ervaringen', 'glasbestellen' ),
		'search_items'          => __( 'Zoek Ervaringen', 'glasbestellen' ),
		'not_found'             => __( 'Niet gevonden', 'glasbestellen' ),
		'not_found_in_trash'    => __( 'Niet gevonden in prullenbak', 'glasbestellen' ),
		'featured_image'        => __( 'Uitgelichte afbeelding', 'glasbestellen' ),
		'set_featured_image'    => __( 'Stel uitgelichte afbeelding in', 'glasbestellen' ),
		'remove_featured_image' => __( 'Verwijder uitgelichte afbeelding', 'glasbestellen' ),
		'use_featured_image'    => __( 'Gebruik als uitgelichte afbeelding', 'glasbestellen' ),
		'insert_into_item'      => __( 'Voeg aan Review toe', 'glasbestellen' ),
		'uploaded_to_this_item' => __( 'Geupload naar deze ervaring', 'glasbestellen' ),
		'items_list'            => __( 'Ervaringen lijst', 'glasbestellen' ),
		'items_list_navigation' => __( 'Ervaringen lijst navigatie', 'glasbestellen' ),
		'filter_items_list'     => __( 'Filter Ervaringen lijst', 'glasbestellen' ),
	);
	$args = array(
		'label'                 => __( 'Review', 'glasbestellen' ),
		'description'           => __( 'Post Type Description', 'glasbestellen' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'custom-fields', 'excerpt', 'comments' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'             => 'dashicons-format-chat',
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite'					=> array( 'slug' => _x( 'ervaringen', 'Product rewrite slug', 'glasbestellen' ) )
	);
	register_post_type( 'review', $args );

	// Inspiratie
	$labels = array(
		'name'                  => _x( 'Inspiratie', 'Post Type General Name', 'glasbestellen' ),
		'singular_name'         => _x( 'Inspiratie', 'Post Type Singular Name', 'glasbestellen' ),
		'menu_name'             => __( 'Inspiratie', 'glasbestellen' ),
		'name_admin_bar'        => __( 'Inspiratie', 'glasbestellen' ),
		'archives'              => __( 'Inspiratie archieven', 'glasbestellen' ),
		'attributes'            => __( 'Inspiratie attributen', 'glasbestellen' ),
		'parent_item_colon'     => __( 'Parent Inspiratie:', 'glasbestellen' ),
		'all_items'             => __( 'Alle Inspiratie', 'glasbestellen' ),
		'add_new_item'          => __( 'Voeg nieuw Inspiratie toe', 'glasbestellen' ),
		'add_new'               => __( 'Voeg nieuwe toe', 'glasbestellen' ),
		'new_item'              => __( 'Nieuwe Inspiratie', 'glasbestellen' ),
		'edit_item'             => __( 'Bewerk Inspiratie', 'glasbestellen' ),
		'update_item'           => __( 'Update Inspiratie', 'glasbestellen' ),
		'view_item'             => __( 'Bekijk Inspiratie', 'glasbestellen' ),
		'view_items'            => __( 'Bekijk Inspiratie', 'glasbestellen' ),
		'search_items'          => __( 'Zoek Inspiratie', 'glasbestellen' ),
		'not_found'             => __( 'Niet gevonden', 'glasbestellen' ),
		'not_found_in_trash'    => __( 'Niet gevonden in prullenbak', 'glasbestellen' ),
		'featured_image'        => __( 'Uitgelichte afbeelding', 'glasbestellen' ),
		'set_featured_image'    => __( 'Stel uitgelichte afbeelding in', 'glasbestellen' ),
		'remove_featured_image' => __( 'Verwijder uitgelichte afbeelding', 'glasbestellen' ),
		'use_featured_image'    => __( 'Gebruik als uitgelichte afbeelding', 'glasbestellen' ),
		'insert_into_item'      => __( 'Voeg aan Inspiratie toe', 'glasbestellen' ),
		'uploaded_to_this_item' => __( 'Geupload naar dit Inspiratie', 'glasbestellen' ),
		'items_list'            => __( 'Inspiratie lijst', 'glasbestellen' ),
		'items_list_navigation' => __( 'Inspiratie lijst navigatie', 'glasbestellen' ),
		'filter_items_list'     => __( 'Filter Inspiratie lijst', 'glasbestellen' ),
	);
	$args = array(
		'label'                 => __( 'Inspiratie', 'glasbestellen' ),
		'description'           => __( 'Post Type Description', 'glasbestellen' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'custom-fields', 'excerpt', 'thumbnail' ),
		'taxonomies'            => array( 'inspiratie-categorie' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'             => 'dashicons-format-gallery',
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite'					=> array( 'slug' => _x( 'werk', 'Product rewrite slug', 'glasbestellen' ) )
	);
	register_post_type( 'inspiratie', $args );

	// Artikel
	$labels = array(
		'name'                => _x( 'Kenniscentrum', 'Post Type General Name', 'glasbestellen' ),
		'singular_name'       => _x( 'Artikel', 'Post Type Singular Name', 'glasbestellen' ),
		'menu_name'           => __( 'Kenniscentrum', 'glasbestellen' ),
		'parent_item_colon'   => __( 'Parent artikel:', 'glasbestellen' ),
		'all_items'           => __( 'Alle artikelen', 'glasbestellen' ),
		'view_item'           => __( 'Bekijk artikelen', 'glasbestellen' ),
		'add_new_item'        => __( 'Voeg nieuw artikel toe', 'glasbestellen' ),
		'add_new'             => __( 'Voeg nieuwe toe', 'glasbestellen' ),
		'edit_item'           => __( 'Bewerk artikel', 'glasbestellen' ),
		'update_item'         => __( 'Update artikel', 'glasbestellen' ),
		'search_items'        => __( 'Zoek artikelen', 'glasbestellen' ),
		'not_found'           => __( 'Niet gevonden', 'glasbestellen' ),
		'not_found_in_trash'  => __( 'Niet gevonden in prullenbak', 'glasbestellen' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields', ),
		'hierarchical'        => false,
		'taxonomies'          => array( 'onderwerp' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'map_meta_cap'        => true,
		'has_archive'         => _x( 'kenniscentrum', 'Rewrite', 'glasbestellen' ),
		'rewrite'             => array( 'slug' => _x( 'kenniscentrum', 'Rewrite', 'glasbestellen' ) . '/%onderwerp%', 'with_front' => false ),
	);
	register_post_type( 'artikel', $args );

	// Configurator
	$labels = array(
		'name'                => _x( 'Configurator', 'Post Type General Name', 'glasbestellen' ),
		'singular_name'       => _x( 'Configurator', 'Post Type Singular Name', 'glasbestellen' ),
		'menu_name'           => __( 'Configuratoren', 'glasbestellen' ),
		'parent_item_colon'   => __( 'Parent configurator:', 'glasbestellen' ),
		'all_items'           => __( 'Alle configuratoren', 'glasbestellen' ),
		'view_item'           => __( 'Bekijk configurator', 'glasbestellen' ),
		'add_new_item'        => __( 'Voeg nieuwe configurator toe', 'glasbestellen' ),
		'add_new'             => __( 'Voeg nieuwe toe', 'glasbestellen' ),
		'edit_item'           => __( 'Bewerk configurator', 'glasbestellen' ),
		'update_item'         => __( 'Update configurator', 'glasbestellen' ),
		'search_items'        => __( 'Zoek configuratoren', 'glasbestellen' ),
		'not_found'           => __( 'Niet gevonden', 'glasbestellen' ),
		'not_found_in_trash'  => __( 'Niet gevonden in prullenbak', 'glasbestellen' ),
	);
	$args = array(
		'label'                 => __( 'Configurator', 'glasbestellen' ),
		'description'           => __( 'Post Type Description', 'glasbestellen' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'page-attributes' ),
		'taxonomies'            => array( 'startopstelling', 'filter' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 100,
		'menu_icon'             => 'dashicons-align-right',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'rewrite'					=> ['slug' => _x( 'producten', 'Product slug', 'glasbestellen' ) . '/%product%']
	);
	register_post_type( 'configurator', $args );

	// Onderdeel
	$labels = array(
		'name'                => _x( 'Onderdeel', 'Post Type General Name', 'glasbestellen' ),
		'singular_name'       => _x( 'Onderdeel', 'Post Type Singular Name', 'glasbestellen' ),
		'menu_name'           => __( 'Onderdelen', 'glasbestellen' ),
		'parent_item_colon'   => __( 'Parent Onderdeel:', 'glasbestellen' ),
		'all_items'           => __( 'Alle Onderdelen', 'glasbestellen' ),
		'view_item'           => __( 'Bekijk Onderdelen', 'glasbestellen' ),
		'add_new_item'        => __( 'Voeg nieuwe Onderdeel toe', 'glasbestellen' ),
		'add_new'             => __( 'Voeg nieuwe toe', 'glasbestellen' ),
		'edit_item'           => __( 'Bewerk Onderdeel', 'glasbestellen' ),
		'update_item'         => __( 'Update Onderdeel', 'glasbestellen' ),
		'search_items'        => __( 'Zoek Onderdeelen', 'glasbestellen' ),
		'not_found'           => __( 'Niet gevonden', 'glasbestellen' ),
		'not_found_in_trash'  => __( 'Niet gevonden in prullenbak', 'glasbestellen' ),
	);
	$args = array(
		'label'                 => __( 'Onderdeel', 'glasbestellen' ),
		'description'           => __( 'Post Type Description', 'glasbestellen' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'excerpt', 'custom-fields', 'thumbnail' ),
		'taxonomies'            => array( 'startopstelling' ),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 100,
		'menu_icon'             => 'dashicons-admin-generic',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'onderdeel', $args );

	// Transactie
	$labels = array(
		'name'                => _x( 'Transacties', 'Post Type General Name', 'glasbestellen' ),
		'singular_name'       => _x( 'Transactie', 'Post Type Singular Name', 'glasbestellen' ),
		'menu_name'           => __( 'Transacties', 'glasbestellen' ),
		'parent_item_colon'   => __( 'Parent transactie:', 'glasbestellen' ),
		'all_items'           => __( 'Alle transacties', 'glasbestellen' ),
		'view_item'           => __( 'Bekijk transactie', 'glasbestellen' ),
		'add_new_item'        => __( 'Voeg nieuwe transactie toe', 'glasbestellen' ),
		'add_new'             => __( 'Voeg nieuwe toe', 'glasbestellen' ),
		'edit_item'           => __( 'Bewerk transactie', 'glasbestellen' ),
		'update_item'         => __( 'Update transactie', 'glasbestellen' ),
		'search_items'        => __( 'Zoek transacties', 'glasbestellen' ),
		'not_found'           => __( 'Niet gevonden', 'glasbestellen' ),
		'not_found_in_trash'  => __( 'Niet gevonden in prullenbak', 'glasbestellen' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'custom-fields' ),
		'hierarchical'        => true,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 2,
		'menu_icon'           => 'dashicons-chart-area',
		'can_export'          => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'map_meta_cap'        => true,
	);
	register_post_type( 'transactie', $args );

	// Explanation
	$labels = array(
		'name'                => _x( 'Uitleg', 'Post Type General Name', 'glasbestellen' ),
		'singular_name'       => _x( 'Uitleg', 'Post Type Singular Name', 'glasbestellen' ),
		'menu_name'           => __( 'Uitleg', 'glasbestellen' ),
		'parent_item_colon'   => __( 'Parent Uitleg:', 'glasbestellen' ),
		'all_items'           => __( 'Alle Uitlegs', 'glasbestellen' ),
		'view_item'           => __( 'Bekijk Uitleg', 'glasbestellen' ),
		'add_new_item'        => __( 'Voeg nieuwe Uitleg toe', 'glasbestellen' ),
		'add_new'             => __( 'Voeg nieuwe toe', 'glasbestellen' ),
		'edit_item'           => __( 'Bewerk Uitleg', 'glasbestellen' ),
		'update_item'         => __( 'Update Uitleg', 'glasbestellen' ),
		'search_items'        => __( 'Zoek Uitlegs', 'glasbestellen' ),
		'not_found'           => __( 'Niet gevonden', 'glasbestellen' ),
		'not_found_in_trash'  => __( 'Niet gevonden in prullenbak', 'glasbestellen' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'custom-fields', 'editor' ),
		'show_in_rest' 		 => true,
		'hierarchical'        => true,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-info',
		'can_export'          => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'has_archive'         => false,
		'map_meta_cap'        => true,
	);
	register_post_type( 'uitleg', $args );

	// Forms
	$labels = array(
		'name'                => _x( 'Formulier', 'Post Type General Name', 'glasbestellen' ),
		'singular_name'       => _x( 'Formulier', 'Post Type Singular Name', 'glasbestellen' ),
		'menu_name'           => __( 'Formulieren', 'glasbestellen' ),
		'parent_item_colon'   => __( 'Parent Formulier:', 'glasbestellen' ),
		'all_items'           => __( 'Alle Formulieren', 'glasbestellen' ),
		'view_item'           => __( 'Bekijk Formulieren', 'glasbestellen' ),
		'add_new_item'        => __( 'Voeg nieuwe Formulier toe', 'glasbestellen' ),
		'add_new'             => __( 'Voeg nieuwe toe', 'glasbestellen' ),
		'edit_item'           => __( 'Bewerk Formulier', 'glasbestellen' ),
		'update_item'         => __( 'Update Formulier', 'glasbestellen' ),
		'search_items'        => __( 'Zoek Formuliers', 'glasbestellen' ),
		'not_found'           => __( 'Niet gevonden', 'glasbestellen' ),
		'not_found_in_trash'  => __( 'Niet gevonden in prullenbak', 'glasbestellen' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'custom-fields' ),
		'show_in_rest' 		 => true,
		'hierarchical'        => true,
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-editor-table',
		'can_export'          => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'has_archive'         => false,
		'map_meta_cap'        => true,
	);
	register_post_type( 'form', $args );

	// FAQ
	$labels = array(
		'name'                => _x( 'Onderwerpen', 'Post Type General Name', 'glasbestellen' ),
		'singular_name'       => _x( 'Onderwerp', 'Post Type Singular Name', 'glasbestellen' ),
		'menu_name'           => __( 'FAQ', 'glasbestellen' ),
		'parent_item_colon'   => __( 'Parent onderwerp:', 'glasbestellen' ),
		'all_items'           => __( 'Alle onderwerpen', 'glasbestellen' ),
		'view_item'           => __( 'Bekijk onderwerp', 'glasbestellen' ),
		'add_new_item'        => __( 'Voeg nieuw onderwerp toe', 'glasbestellen' ),
		'add_new'             => __( 'Voeg nieuwe toe', 'glasbestellen' ),
		'edit_item'           => __( 'Bewerk onderwerp', 'glasbestellen' ),
		'update_item'         => __( 'Update onderwerp', 'glasbestellen' ),
		'search_items'        => __( 'Zoek onderwerpen', 'glasbestellen' ),
		'not_found'           => __( 'Niet gevonden', 'glasbestellen' ),
		'not_found_in_trash'  => __( 'Niet gevonden in prullenbak', 'glasbestellen' ),
	);
	$args = array(
		'labels'              => $labels,
		'supports'            => array( 'title', 'custom-fields' ),
		'show_in_rest' 		 => true,
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 100,
		'menu_icon'           => 'dashicons-editor-help',
		'can_export'          => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'has_archive'         => false,
		'map_meta_cap'        => true,
		'rewrite'				 => array( 'slug' => _x( 'veelgestelde-vragen', 'FAQ rewrite slug', 'glasbestellen' ) )
	);
	register_post_type( 'faq', $args );

}
add_action( 'init', 'gb_register_post_types', 0 );
