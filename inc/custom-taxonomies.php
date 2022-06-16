<?php
// Registers custom Taxonomies
function gb_register_taxonomies() {

	// Product categorie
	$labels = array(
		'name'                       => _x( 'Categorie', 'Taxonomy General Name', 'glasbestellen' ),
		'singular_name'              => _x( 'Categorie', 'Taxonomy Singular Name', 'glasbestellen' ),
		'menu_name'                  => __( 'Categorie&euml;n', 'glasbestellen' ),
		'all_items'                  => __( 'Alle Categorieen', 'glasbestellen' ),
		'parent_item'                => __( 'Parent Categorie', 'glasbestellen' ),
		'parent_item_colon'          => __( 'Parent Categorie:', 'glasbestellen' ),
		'new_item_name'              => __( 'Nieuwe Categorie naam', 'glasbestellen' ),
		'add_new_item'               => __( 'Voeg nieuwe Categorie toe', 'glasbestellen' ),
		'edit_item'                  => __( 'Bewerk Categorie', 'glasbestellen' ),
		'update_item'                => __( 'Update Categorie', 'glasbestellen' ),
		'separate_items_with_commas' => __( 'Scheidt Categorie&euml;n door komma\'s', 'glasbestellen' ),
		'search_items'               => __( 'Zoek Categorie&euml;n', 'glasbestellen' ),
		'add_or_remove_items'        => __( 'Voeg toe of verwijder Categorie', 'glasbestellen' ),
		'choose_from_most_used'      => __( 'Kies uit meest gebruikte Categorie&euml;n', 'glasbestellen' ),
		'not_found'                  => __( 'Niet gevonden', 'glasbestellen' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	// register_taxonomy( 'product-categorie', array( 'product' ), $args );

	// Review product
	$labels = array(
		'name'                       => _x( 'Categorie', 'Taxonomy General Name', 'glasbestellen' ),
		'singular_name'              => _x( 'Categorie', 'Taxonomy Singular Name', 'glasbestellen' ),
		'menu_name'                  => __( 'Categorie&euml;n', 'glasbestellen' ),
		'all_items'                  => __( 'Alle Categorieen', 'glasbestellen' ),
		'parent_item'                => __( 'Parent Categorie', 'glasbestellen' ),
		'parent_item_colon'          => __( 'Parent Categorie:', 'glasbestellen' ),
		'new_item_name'              => __( 'Nieuwe Categorie naam', 'glasbestellen' ),
		'add_new_item'               => __( 'Voeg nieuwe Categorie toe', 'glasbestellen' ),
		'edit_item'                  => __( 'Bewerk Categorie', 'glasbestellen' ),
		'update_item'                => __( 'Update Categorie', 'glasbestellen' ),
		'separate_items_with_commas' => __( 'Scheidt Categorie&euml;n door komma\'s', 'glasbestellen' ),
		'search_items'               => __( 'Zoek Categorie&euml;n', 'glasbestellen' ),
		'add_or_remove_items'        => __( 'Voeg toe of verwijder Categorie', 'glasbestellen' ),
		'choose_from_most_used'      => __( 'Kies uit meest gebruikte Categorie&euml;n', 'glasbestellen' ),
		'not_found'                  => __( 'Niet gevonden', 'glasbestellen' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'review-product', array( 'review' ), $args );


	// Onderwerp
	$labels = array(
		'name'                       => _x( 'Onderwerpen', 'Taxonomy General Name', 'glasbestellen' ),
		'singular_name'              => _x( 'Onderwerp', 'Taxonomy Singular Name', 'glasbestellen' ),
		'menu_name'                  => __( 'Onderwerp', 'glasbestellen' ),
		'all_items'                  => __( 'Alle onderwerpen', 'glasbestellen' ),
		'parent_item'                => __( 'Parent onderwerp', 'glasbestellen' ),
		'parent_item_colon'          => __( 'Parent onderwerp:', 'glasbestellen' ),
		'new_item_name'              => __( 'Nieuwe onderwerp naam', 'glasbestellen' ),
		'add_new_item'               => __( 'Voeg nieuw onderwerp toe', 'glasbestellen' ),
		'edit_item'                  => __( 'Bewerk onderwerp', 'glasbestellen' ),
		'update_item'                => __( 'Update onderwerp', 'glasbestellen' ),
		'separate_items_with_commas' => __( 'Scheidt onderwerpen door komma\'s', 'glasbestellen' ),
		'search_items'               => __( 'Zoek onderwerpen', 'glasbestellen' ),
		'add_or_remove_items'        => __( 'Voeg toe of verwijder onderwerp', 'glasbestellen' ),
		'choose_from_most_used'      => __( 'Kies uit meest gebruikte onderwerpen', 'glasbestellen' ),
		'not_found'                  => __( 'Niet gevonden', 'glasbestellen' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'onderwerp', array( 'artikel' ), $args );

	// Inspiratie product
	$labels = array(
		'name'                       => _x( 'Categorie', 'Taxonomy General Name', 'glasbestellen' ),
		'singular_name'              => _x( 'Categorie', 'Taxonomy Singular Name', 'glasbestellen' ),
		'menu_name'                  => __( 'Categorie&euml;n', 'glasbestellen' ),
		'all_items'                  => __( 'Alle Categorieen', 'glasbestellen' ),
		'parent_item'                => __( 'Parent Categorie', 'glasbestellen' ),
		'parent_item_colon'          => __( 'Parent Categorie:', 'glasbestellen' ),
		'new_item_name'              => __( 'Nieuwe Categorie naam', 'glasbestellen' ),
		'add_new_item'               => __( 'Voeg nieuwe Categorie toe', 'glasbestellen' ),
		'edit_item'                  => __( 'Bewerk Categorie', 'glasbestellen' ),
		'update_item'                => __( 'Update Categorie', 'glasbestellen' ),
		'separate_items_with_commas' => __( 'Scheidt Categorie&euml;n door komma\'s', 'glasbestellen' ),
		'search_items'               => __( 'Zoek Categorie&euml;n', 'glasbestellen' ),
		'add_or_remove_items'        => __( 'Voeg toe of verwijder Categorie', 'glasbestellen' ),
		'choose_from_most_used'      => __( 'Kies uit meest gebruikte Categorie&euml;n', 'glasbestellen' ),
		'not_found'                  => __( 'Niet gevonden', 'glasbestellen' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'						  => array( 'slug' => 'inspiration-product' )
	);
	register_taxonomy( 'inspiratie-categorie', array( 'inspiratie' ), $args );

	// Startopstelling
	$labels = array(
		'name'                       => _x( 'Startopstellingen', 'Taxonomy General Name', 'glasbestellen' ),
		'singular_name'              => _x( 'Startopstelling', 'Taxonomy Singular Name', 'glasbestellen' ),
		'menu_name'                  => __( 'Startopstellingen', 'glasbestellen' ),
		'all_items'                  => __( 'Alle startopstellingen', 'glasbestellen' ),
		'parent_item'                => __( 'Parent startopstelling', 'glasbestellen' ),
		'parent_item_colon'          => __( 'Parent startopstelling:', 'glasbestellen' ),
		'new_item_name'              => __( 'Nieuwe startopstelling naam', 'glasbestellen' ),
		'add_new_item'               => __( 'Voeg nieuwe startopstelling toe', 'glasbestellen' ),
		'edit_item'                  => __( 'Bewerk startopstelling', 'glasbestellen' ),
		'update_item'                => __( 'Update startopstelling', 'glasbestellen' ),
		'separate_items_with_commas' => __( 'Scheidt startopstellingen door komma\'s', 'glasbestellen' ),
		'search_items'               => __( 'Zoek startopstellingen', 'glasbestellen' ),
		'add_or_remove_items'        => __( 'Voeg toe of verwijder startopstelling', 'glasbestellen' ),
		'choose_from_most_used'      => __( 'Kies uit meest gebruikte startopstellingen', 'glasbestellen' ),
		'not_found'                  => __( 'Niet gevonden', 'glasbestellen' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'startopstelling', array( 'configurator' ), $args );

	// Filter
	$labels = array(
		'name'                       => _x( 'Filter', 'Taxonomy General Name', 'glasbestellen' ),
		'singular_name'              => _x( 'Filter', 'Taxonomy Singular Name', 'glasbestellen' ),
		'menu_name'                  => __( 'Filters', 'glasbestellen' ),
		'all_items'                  => __( 'Alle Filters', 'glasbestellen' ),
		'parent_item'                => __( 'Parent filter', 'glasbestellen' ),
		'parent_item_colon'          => __( 'Parent filter:', 'glasbestellen' ),
		'new_item_name'              => __( 'Nieuwe filter naam', 'glasbestellen' ),
		'add_new_item'               => __( 'Voeg nieuwe filter toe', 'glasbestellen' ),
		'edit_item'                  => __( 'Bewerk filter', 'glasbestellen' ),
		'update_item'                => __( 'Update filter', 'glasbestellen' ),
		'separate_items_with_commas' => __( 'Scheidt filters door komma\'s', 'glasbestellen' ),
		'search_items'               => __( 'Zoek filters', 'glasbestellen' ),
		'add_or_remove_items'        => __( 'Voeg toe of verwijder filter', 'glasbestellen' ),
		'choose_from_most_used'      => __( 'Kies uit meest gebruikte filters', 'glasbestellen' ),
		'not_found'                  => __( 'Niet gevonden', 'glasbestellen' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => false,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'filter', array( 'configurator' ), $args );


}
add_action( 'init', 'gb_register_taxonomies', 0 );
