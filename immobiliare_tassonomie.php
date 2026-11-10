<?php
defined( 'ABSPATH' ) || exit;

/**
 * Registrazione tassonomie custom per il post type Immobili
 */
function immobili_registra_tassonomie() {
	// 1. Tassonomia Tipologia
	$labels_tipologia = array(
		'name'              => _x( 'Tipologie', 'taxonomy general name', 'immobiliare' ),
		'singular_name'     => _x( 'Tipologia', 'taxonomy singular name', 'immobiliare' ),
		'search_items'      => __( 'Cerca tipologia', 'immobiliare' ),
		'all_items'         => __( 'Tutte le tipologie', 'immobiliare' ),
		'parent_item'       => __( 'Tipologia padre', 'immobiliare' ),
		'parent_item_colon' => __( 'Tipologia padre:', 'immobiliare' ),
		'edit_item'         => __( 'Modifica tipologia', 'immobiliare' ),
		'update_item'       => __( 'Aggiorna tipologia', 'immobiliare' ),
		'add_new_item'      => __( 'Aggiungi nuova tipologia', 'immobiliare' ),
		'new_item_name'     => __( 'Nome della nuova tipologia', 'immobiliare' ),
		'menu_name'         => __( 'Tipologie', 'immobiliare' ),
	);
	register_taxonomy( 'tipologia', 'immobili', array(
		'labels'            => $labels_tipologia,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'tipologia' ),
	) );

	// 2. Tassonomia Categoria (es. residenziale, commerciale)
	$labels_categoria = array(
		'name'              => _x( 'Categorie', 'taxonomy general name', 'immobiliare' ),
		'singular_name'     => _x( 'Categoria', 'taxonomy singular name', 'immobiliare' ),
		'search_items'      => __( 'Cerca categoria', 'immobiliare' ),
		'all_items'         => __( 'Tutte le categorie', 'immobiliare' ),
		'parent_item'       => __( 'Categoria padre', 'immobiliare' ),
		'parent_item_colon' => __( 'Categoria padre:', 'immobiliare' ),
		'edit_item'         => __( 'Modifica categoria', 'immobiliare' ),
		'update_item'       => __( 'Aggiorna categoria', 'immobiliare' ),
		'add_new_item'      => __( 'Aggiungi nuova categoria', 'immobiliare' ),
		'new_item_name'     => __( 'Nome della nuova categoria', 'immobiliare' ),
		'menu_name'         => __( 'Categorie', 'immobiliare' ),
	);
	register_taxonomy( 'categoria', 'immobili', array(
		'labels'            => $labels_categoria,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'categoria-immobili' ),
	) );

	// 3. Tassonomia Tag
	$labels_tag = array(
		'name'              => _x( 'Tag Immobili', 'taxonomy general name', 'immobiliare' ),
		'singular_name'     => _x( 'Tag Immobile', 'taxonomy singular name', 'immobiliare' ),
		'search_items'      => __( 'Cerca tag', 'immobiliare' ),
		'all_items'         => __( 'Tutti i tag', 'immobiliare' ),
		'parent_item'       => __( 'Tag padre', 'immobiliare' ),
		'parent_item_colon' => __( 'Tag padre:', 'immobiliare' ),
		'edit_item'         => __( 'Modifica tag', 'immobiliare' ),
		'update_item'       => __( 'Aggiorna tag', 'immobiliare' ),
		'add_new_item'      => __( 'Aggiungi nuovo tag', 'immobiliare' ),
		'new_item_name'     => __( 'Nome del tag', 'immobiliare' ),
		'menu_name'         => __( 'Tag', 'immobiliare' ),
		'not_found'         => __( 'Nessun tag trovato', 'immobiliare' ),
	);
	register_taxonomy( 'immobili_tag', 'immobili', array(
		'labels'            => $labels_tag,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'tag-immobili' ),
	) );

	// 4. Tassonomia Contratto (Vendita / Affitto)
	$labels_contratto = array(
		'name'              => _x( 'Contratti', 'taxonomy general name', 'immobiliare' ),
		'singular_name'     => _x( 'Contratto', 'taxonomy singular name', 'immobiliare' ),
		'search_items'      => __( 'Cerca Contratto', 'immobiliare' ),
		'all_items'         => __( 'Tutti i contratti', 'immobiliare' ),
		'parent_item'       => __( 'Contratto padre', 'immobiliare' ),
		'parent_item_colon' => __( 'Contratto padre:', 'immobiliare' ),
		'edit_item'         => __( 'Modifica Contratto', 'immobiliare' ),
		'update_item'       => __( 'Aggiorna Contratto', 'immobiliare' ),
		'add_new_item'      => __( 'Aggiungi nuovo Contratto', 'immobiliare' ),
		'new_item_name'     => __( 'Nome del nuovo Contratto', 'immobiliare' ),
		'menu_name'         => __( 'Contratti', 'immobiliare' ),
	);
	register_taxonomy( 'contratto', 'immobili', array(
		'labels'            => $labels_contratto,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'contratto' ),
	) );

	// 5. Tassonomia Comuni / Località
	$labels_comune = array(
		'name'              => _x( 'Comuni / Località', 'taxonomy general name', 'immobiliare' ),
		'singular_name'     => _x( 'Località', 'taxonomy singular name', 'immobiliare' ),
		'search_items'      => __( 'Cerca Località', 'immobiliare' ),
		'all_items'         => __( 'Tutte le località', 'immobiliare' ),
		'parent_item'       => __( 'Località padre', 'immobiliare' ),
		'parent_item_colon' => __( 'Località padre:', 'immobiliare' ),
		'edit_item'         => __( 'Modifica Località', 'immobiliare' ),
		'update_item'       => __( 'Aggiorna Località', 'immobiliare' ),
		'add_new_item'      => __( 'Aggiungi nuova Località', 'immobiliare' ),
		'new_item_name'     => __( 'Nome della nuova Località', 'immobiliare' ),
		'menu_name'         => __( 'Località', 'immobiliare' ),
	);
	register_taxonomy( 'comuni', 'immobili', array(
		'labels'            => $labels_comune,
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_in_rest'      => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'comuni' ),
	) );
}
add_action( 'init', 'immobili_registra_tassonomie', 0 );
