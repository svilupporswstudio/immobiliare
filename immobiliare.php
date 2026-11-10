<?php
/**
 * Plugin Name: Immobiliare
 * Plugin URI: https://www.matteotestoni.it/servizi/programmatore-esperto-wordpress/plugin-immobiliare-wordpress/
 * Description: Gestionale immobiliare per WordPress. Gestisci i tuoi immobili in modo semplice e veloce.
 * Version: 7.1.0
 * Author: Matteo Testoni
 * Author URI: https://www.matteotestoni.it
 * License: GPL2
 * Requires at least: 7.1
 * Tested up to: 7.1
 * Requires PHP: 8.3
 * Requires Plugins: meta-box
 * Text Domain: immobiliare
 * Domain Path: /lang
 */

defined( 'ABSPATH' ) || exit;

define( 'Immobiliare_Version', '7.1.0' );
define( 'Immobiliare_Directory', dirname( plugin_basename( __FILE__ ) ) );
define( 'Immobiliare_Path', plugin_dir_path( __FILE__ ) );
define( 'Immobiliare_URL', plugin_dir_url( __FILE__ ) );

include_once Immobiliare_Path . 'immobiliare_metabox.php';
include_once Immobiliare_Path . 'immobiliare_opzioni.php';
include_once Immobiliare_Path . 'immobiliare_tassonomie.php';
include_once Immobiliare_Path . 'immobiliare_filtri.php';
include_once Immobiliare_Path . 'immobiliare_widget.php';
include_once Immobiliare_Path . 'immobiliare_shortcode.php';

function immobiliare_load_textdomain() {
	load_plugin_textdomain( 'immobiliare', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
}
add_action( 'plugins_loaded', 'immobiliare_load_textdomain' );

function immobili_print() {
	if ( function_exists( 'rwmb_meta' ) ) {
		echo esc_html( rwmb_meta( 'immobili_arredato' ) );
	}
}

function immobili_init() {
	$labels = array(
		'name'               => __( 'Immobili', 'immobiliare' ),
		'singular_name'      => __( 'Immobile', 'immobiliare' ),
		'add_new'            => __( 'Aggiungi Immobile', 'immobiliare' ),
		'add_new_item'       => __( 'Aggiungi Immobile', 'immobiliare' ),
		'edit_item'          => __( 'Modifica', 'immobiliare' ),
		'new_item'           => __( 'Nuovo Immobile', 'immobiliare' ),
		'all_items'          => __( 'Tutti gli Immobili', 'immobiliare' ),
		'view_item'          => __( 'Vedi la pagina', 'immobiliare' ),
		'search_items'       => __( 'Cerca', 'immobiliare' ),
		'not_found'          => __( 'Nessun Immobile trovato', 'immobiliare' ),
		'not_found_in_trash' => __( 'Nessun Immobile trovato nel cestino', 'immobiliare' ),
		'parent_item_colon'  => '',
		'menu_name'          => __( 'Immobili', 'immobiliare' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'menu_icon'          => Immobiliare_URL . 'img/immobili.png',
		'rewrite'            => array( 'slug' => 'immobili' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'excerpt', 'editor', 'thumbnail', 'page-attributes' ),
		'show_in_rest'       => true
	);

	register_post_type( 'immobili', $args );
}
add_action( 'init', 'immobili_init' );

function immobili_css() {
	wp_enqueue_style( 'immobiliare-styles', Immobiliare_URL . 'css/immobili.css', array(), Immobiliare_Version );
}
add_action( 'wp_enqueue_scripts', 'immobili_css' );

function immobili_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

	if ( ! $post || 'immobili' !== $post_type ) {
		return $messages;
	}

	$messages['immobili'] = array(
		0  => '',
		1  => __( 'Immobile aggiornato.', 'immobiliare' ),
		2  => __( 'Campo personalizzato aggiornato.', 'immobiliare' ),
		3  => __( 'Campo personalizzato eliminato.', 'immobiliare' ),
		4  => __( 'Immobile aggiornato.', 'immobiliare' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Immobile ripristinato alla revisione %s', 'immobiliare' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6  => __( 'Immobile pubblicato.', 'immobiliare' ),
		7  => __( 'Immobile salvato.', 'immobiliare' ),
		8  => __( 'Immobile inviato.', 'immobiliare' ),
		9  => sprintf(
			__( 'Immobile programmato per: <strong>%1$s</strong>.', 'immobiliare' ),
			wp_date( __( 'M j, Y @ G:i', 'immobiliare' ), strtotime( $post->post_date ) )
		),
		10 => __( 'Bozza immobile aggiornata.', 'immobiliare' )
	);

	if ( $post_type_object && $post_type_object->publicly_queryable ) {
		$permalink = get_permalink( $post->ID );
		$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'Visualizza immobile', 'immobiliare' ) );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link      = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Anteprima immobile', 'immobiliare' ) );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}

	return $messages;
}
add_filter( 'post_updated_messages', 'immobili_updated_messages' );

/**
 * Modern Help Tabs implementation (replaces deprecated contextual_help hook from WP 3.3).
 */
function immobili_add_help_tabs() {
	$screen = get_current_screen();
	if ( ! $screen ) {
		return;
	}

	if ( 'immobili' === $screen->id ) {
		$help_content = '<p>' . esc_html__( 'Cose da ricordare in modifica di un immobile:', 'immobiliare' ) . '</p>' .
			'<ul>' .
			'<li>' . esc_html__( 'Specifica dettagliatamente in quali tipologie può essere inserito.', 'immobiliare' ) . '</li>' .
			'<li>' . esc_html__( 'Specifica nel titolo se in vendita o affitto e la tipologia.', 'immobiliare' ) . '</li>' .
			'</ul>' .
			'<p>' . esc_html__( 'Se vuoi pianificare la pubblicazione di un annuncio nel futuro:', 'immobiliare' ) . '</p>' .
			'<ul>' .
			'<li>' . esc_html__( 'Nel pannello di pubblicazione, modifica la data di pubblicazione indicando una data futura.', 'immobiliare' ) . '</li>' .
			'</ul>' .
			'<p><strong>' . esc_html__( 'Per maggiori informazioni:', 'immobiliare' ) . '</strong></p>' .
			'<p><a href="https://www.matteotestoni.it/servizi/programmatore-esperto-wordpress/plugin-immobiliare-wordpress/" target="_blank" rel="noopener">' . esc_html__( 'Guida ufficiale Plugin Immobiliare', 'immobiliare' ) . '</a></p>' .
			'<p><a href="https://wordpress.org/plugins/immobiliare/" target="_blank" rel="noopener">' . esc_html__( 'Pagina su WordPress.org', 'immobiliare' ) . '</a></p>';

		$screen->add_help_tab( array(
			'id'      => 'immobili_help_tab',
			'title'   => __( 'Guida Gestione Immobile', 'immobiliare' ),
			'content' => $help_content,
		) );
	} elseif ( 'edit-immobili' === $screen->id ) {
		$screen->add_help_tab( array(
			'id'      => 'immobili_list_help_tab',
			'title'   => __( 'Elenco Immobili', 'immobiliare' ),
			'content' => '<p>' . esc_html__( 'Elenco immobili inseriti con dettaglio di categoria, tipologia, contratto, comune e attributi.', 'immobiliare' ) . '</p>',
		) );
	}
}
add_action( 'current_screen', 'immobili_add_help_tabs' );

function immobili_aggiungiattributialcontenutolista( $content ) {
	$post = get_post();
	if ( ! function_exists( 'rwmb_meta' ) || ! $post ) {
		return $content;
	}

	if ( ( get_post_type( $post ) === 'immobili' ) && is_archive() ) {
		$immobile_tabellacaratteristiche = '<span class="blog-tags minor-meta">';

		$locali = rwmb_meta( 'immobili_locali' );
		if ( ! empty( $locali ) && $locali !== '0' ) {
			$immobile_tabellacaratteristiche .= '<div class="immobili-attribute-list"><span class="label">' . esc_html__( 'Numero locali:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $locali ) . '</span></div>';
		}

		$mq = rwmb_meta( 'immobili_mq' );
		if ( ! empty( $mq ) ) {
			$immobile_tabellacaratteristiche .= '<div class="immobili-attribute-list"><span class="label">' . esc_html__( 'Mq:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $mq ) . '</span></div>';
		}

		$bagni = rwmb_meta( 'immobili_bagni' );
		if ( ! empty( $bagni ) && $bagni !== '0' ) {
			$immobile_tabellacaratteristiche .= '<div class="immobili-attribute-list"><span class="label">' . esc_html__( 'Bagni:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $bagni ) . '</span></div>';
		}

		$camere = rwmb_meta( 'immobili_cameredaletto' );
		if ( ! empty( $camere ) && $camere !== '0' ) {
			$immobile_tabellacaratteristiche .= '<div class="immobili-attribute-list"><span class="label">' . esc_html__( 'Camere da letto:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $camere ) . '</span></div>';
		}

		$rif = rwmb_meta( 'immobili_rif' );
		if ( ! empty( $rif ) ) {
			$immobile_tabellacaratteristiche .= '<div class="immobili-attribute-list"><span class="label">' . esc_html__( 'Rif.:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $rif ) . '</span></div>';
		}

		$immobile_tabellacaratteristiche .= '</span>';
		$content                        .= $immobile_tabellacaratteristiche;
	}

	return $content;
}

function immobili_aggiungiattributialcontenutoscheda( $content ) {
	$post = get_post();
	if ( ! function_exists( 'rwmb_meta' ) || ! $post ) {
		return $content;
	}

	if ( ( get_post_type( $post ) === 'immobili' ) && is_single() ) {
		$immobile_prezzo = '';
		$prezzo          = rwmb_meta( 'immobili_prezzo' );
		if ( ! empty( $prezzo ) ) {
			$immobile_prezzo = '<div style="margin-bottom:2rem"><h2 style="clear:both">' . esc_html__( 'Prezzo:', 'immobiliare' ) . ' ' . number_format( (float) $prezzo, 0, ',', '.' ) . ' &euro;</h2></div>';
		}

		$immobile_video = '';
		$video          = rwmb_meta( 'immobili_video', 'type=oembed' );
		if ( ! empty( $video ) ) {
			$immobile_video = '<style type="text/css">.rwmb-oembed-not-available {display: none;}</style>' .
				'<div style="margin-bottom:2rem">' . $video . '</div>';
		}

		$immobile_virtualtour = '';
		$virtualtour          = rwmb_meta( 'immobili_virtualtour' );
		if ( ! empty( $virtualtour ) ) {
			$immobile_virtualtour = '<h2>' . esc_html__( 'Virtual Tour', 'immobiliare' ) . '</h2><div class="virtualtour"><div style="margin-bottom:2rem">' . $virtualtour . '</div></div>';
		}

		$immobile_galleria      = '';
		$immobile_listagalleria = rwmb_meta( 'immobili_galleria', 'type=image' );
		if ( is_array( $immobile_listagalleria ) && count( $immobile_listagalleria ) > 0 ) {
			$immobile_galleria  = '<style type="text/css">';
			$immobile_galleria .= "#gallery-1 { margin: auto;}\n";
			$immobile_galleria .= "#gallery-1 .gallery-item { float: left; margin-top: 10px; text-align: center; width: 25%; }\n";
			$immobile_galleria .= "#gallery-1 img { border: 2px solid #cfcfcf; }\n";
			$immobile_galleria .= "#gallery-1 .gallery-caption { margin-left: 0; }\n";
			$immobile_galleria .= '</style>';
			$immobile_galleria .= '<h2>' . esc_html__( 'Galleria immagini', 'immobiliare' ) . '</h2>';
			$immobile_galleria .= '<div id="gallery-1" style="margin-bottom:2rem" class="gallery galleryid-9999 gallery-columns-3 gallery-size-thumbnail">';
			foreach ( $immobile_listagalleria as $image ) {
				$img_title          = isset( $image['title'] ) ? esc_attr( $image['title'] ) : '';
				$img_full           = isset( $image['full_url'] ) ? esc_url( $image['full_url'] ) : '';
				$img_src            = isset( $image['url'] ) ? esc_url( $image['url'] ) : '';
				$immobile_galleria .= "<dl class=\"gallery-item\"><dt class=\"gallery-icon landscape\"><a href='{$img_full}' title='{$img_title}'><img src='{$img_src}' data-caption='{$img_title}' alt='{$img_title}' class=\"attachment-thumbnail size-thumbnail\" /></a></dt></dl>\n";
			}
			$immobile_galleria .= '<br style="clear: both"></div>';
		}

		$immobile_planimetria      = '';
		$immobile_listaplanimetria = rwmb_meta( 'immobili_planimetria', 'type=image' );
		if ( is_array( $immobile_listaplanimetria ) && count( $immobile_listaplanimetria ) > 0 ) {
			$immobile_planimetria  = '<style type="text/css">';
			$immobile_planimetria .= "#planimetria-1 { margin: auto;}\n";
			$immobile_planimetria .= "#planimetria-1 .gallery-item { float: left; margin-top: 10px; text-align: center; width: 25%; }\n";
			$immobile_planimetria .= "#planimetria-1 img { border: 2px solid #cfcfcf; }\n";
			$immobile_planimetria .= "#planimetria-1 .gallery-caption { margin-left: 0; }\n";
			$immobile_planimetria .= '</style>';
			$immobile_planimetria .= '<h2>' . esc_html__( 'Planimetrie', 'immobiliare' ) . '</h2>';
			$immobile_planimetria .= '<div id="planimetria-1" style="margin-bottom:2rem" class="gallery galleryid-9999 gallery-columns-3 gallery-size-thumbnail">';
			foreach ( $immobile_listaplanimetria as $image ) {
				$img_title             = isset( $image['title'] ) ? esc_attr( $image['title'] ) : '';
				$img_full              = isset( $image['full_url'] ) ? esc_url( $image['full_url'] ) : '';
				$img_src               = isset( $image['url'] ) ? esc_url( $image['url'] ) : '';
				$immobile_planimetria .= "<dl class=\"gallery-item\"><dt class=\"gallery-icon landscape\"><a href='{$img_full}' title='{$img_title}'><img src='{$img_src}' data-caption='{$img_title}' alt='{$img_title}' class=\"attachment-thumbnail size-thumbnail\" /></a></dt></dl>\n";
			}
			$immobile_planimetria .= '<br style="clear: both"></div>';
		}

		$immobile_allegati      = '';
		$immobile_listaallegati = rwmb_meta( 'immobili_allegati', 'type=file' );
		if ( is_array( $immobile_listaallegati ) && count( $immobile_listaallegati ) > 0 ) {
			$immobile_allegati  = '<h2>' . esc_html__( 'Allegati', 'immobiliare' ) . '</h2>';
			$immobile_allegati .= '<ul class="documents">';
			foreach ( $immobile_listaallegati as $allegato ) {
				$doc_title          = isset( $allegato['title'] ) ? esc_html( $allegato['title'] ) : '';
				$doc_url            = isset( $allegato['url'] ) ? esc_url( $allegato['url'] ) : '';
				$immobile_allegati .= "<li><a href='{$doc_url}' title='{$doc_title}' role='button' target='_blank' rel='noopener'><i class=\"fa fa-file-pdf-o fa-lg fa-fw\" style=\"color:#CF1312\"></i>{$doc_title}</a></li>";
			}
			$immobile_allegati .= '</ul>';
		}

		$immobile_tabellacaratteristiche = '<h2>' . esc_html__( 'Caratteristiche', 'immobiliare' ) . '</h2>';
		$immobile_tabellacaratteristiche .= '<ul class="menu caratteristiche">';

		$rif = rwmb_meta( 'immobili_rif' );
		if ( ! empty( $rif ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Riferimento:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $rif ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_vistamare' ) === '1' ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Vista Mare:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'si', 'immobiliare' ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_nocondominio' ) === '1' ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Condominio:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'no', 'immobiliare' ) . '</span></li>';
		}

		$tipo = rwmb_meta( 'immobili_tipo' );
		if ( ! empty( $tipo ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Tipo:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $tipo ) . '</span></li>';
		}

		$immobile_tabellacaratteristiche .= '</ul><h2>' . esc_html__( 'Stanze', 'immobiliare' ) . '</h2><ul class="menu caratteristiche">';

		$locali = rwmb_meta( 'immobili_locali' );
		if ( ! empty( $locali ) && $locali !== '0' ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Numero locali:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $locali ) . '</span></li>';
		}

		$mq = rwmb_meta( 'immobili_mq' );
		if ( ! empty( $mq ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Mq:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $mq ) . '</span></li>';
		}

		$bagni = rwmb_meta( 'immobili_bagni' );
		if ( ! empty( $bagni ) && $bagni !== '0' ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Bagni:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $bagni ) . '</span></li>';
		}

		$camere = rwmb_meta( 'immobili_cameredaletto' );
		if ( ! empty( $camere ) && $camere !== '0' ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Camere da letto:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $camere ) . '</span></li>';
		}

		$ingresso = rwmb_meta( 'immobili_ingresso' );
		if ( ! empty( $ingresso ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Ingresso:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $ingresso ) . '</span></li>';
		}

		$soggiorno = rwmb_meta( 'immobili_soggiorno' );
		if ( ! empty( $soggiorno ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Soggiorno:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $soggiorno ) . '</span></li>';
		}

		$cucina = rwmb_meta( 'immobili_cucina' );
		if ( ! empty( $cucina ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Cucina:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $cucina ) . '</span></li>';
		}

		$balcone = rwmb_meta( 'immobili_balcone' );
		if ( ! empty( $balcone ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Balcone:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $balcone ) . '</span></li>';
		}

		$terrazzo = rwmb_meta( 'immobili_terrazzo' );
		if ( ! empty( $terrazzo ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Terrazzo:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $terrazzo ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_cantina' ) === '1' ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Cantina:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'si', 'immobiliare' ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_solaio' ) === '1' ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Solaio:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'si', 'immobiliare' ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_portico' ) !== '' ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Portico:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'si', 'immobiliare' ) . '</span></li>';
		}

		$arredato = rwmb_meta( 'immobili_arredato' );
		if ( ! empty( $arredato ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Arredato:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $arredato ) . '</span></li>';
		}

		$immobile_tabellacaratteristiche .= '</ul><h2>' . esc_html__( 'Parcheggi', 'immobiliare' ) . '</h2><ul class="menu caratteristiche">';

		$postoauto = rwmb_meta( 'immobili_postoauto' );
		if ( ! empty( $postoauto ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Posto auto:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $postoauto ) . '</span></li>';
		}

		$postomoto = rwmb_meta( 'immobili_postomotocicli' );
		if ( ! empty( $postomoto ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Posto cicli e motocicli:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $postomoto ) . '</span></li>';
		}

		$speseCondominiali = rwmb_meta( 'immobili_spese' );
		if ( $speseCondominiali === '0' ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Spese cond.:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'nessuna', 'immobiliare' ) . '</span></li>';
		} elseif ( ! empty( $speseCondominiali ) ) {
			$spesetipo = rwmb_meta( 'immobili_spesetipo' );
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Spese cond.:', 'immobiliare' ) . '</span> <span class="value">&euro; ' . esc_html( $speseCondominiali ) . ' ' . esc_html( $spesetipo ) . '</span></li>';
		}

		$immobile_confort = '';

		$cat_catastale = rwmb_meta( 'immobili_categoriacatastale' );
		if ( ! empty( $cat_catastale ) ) {
			$immobile_confort .= '<li><span class="label">' . esc_html__( 'Categoria Catastale:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $cat_catastale ) . '</span></li>';
		}

		$rendita = rwmb_meta( 'immobili_renditacatastale' );
		if ( ! empty( $rendita ) ) {
			$immobile_confort .= '<li><span class="label">' . esc_html__( 'Rendita Catastale:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $rendita ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_piscina' ) === '1' ) {
			$immobile_confort .= '<li><span class="label">' . esc_html__( 'Piscina:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'si', 'immobiliare' ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_idromassaggio' ) === '1' ) {
			$immobile_confort .= '<li><span class="label">' . esc_html__( 'Idromassaggio:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'si', 'immobiliare' ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_ascensore' ) === '1' ) {
			$immobile_confort .= '<li><span class="label">' . esc_html__( 'Ascensore:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'si', 'immobiliare' ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_condizionatore' ) === '1' ) {
			$immobile_confort .= '<li><span class="label">' . esc_html__( 'Condizionatore:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'si', 'immobiliare' ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_satellite' ) === '1' ) {
			$immobile_confort .= '<li><span class="label">' . esc_html__( 'Satellite:', 'immobiliare' ) . '</span> <span class="value">' . esc_html__( 'si', 'immobiliare' ) . '</span></li>';
		}

		if ( rwmb_meta( 'immobili_giardino' ) === '1' ) {
			$giardino   = rwmb_meta( 'immobili_giardino' );
			$mqgiardino = rwmb_meta( 'immobili_mqgiardino' );
			$immobile_confort .= '<li><span class="label">' . esc_html__( 'Giardino:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $giardino ) . ' ' . esc_html__( 'di', 'immobiliare' ) . ' ' . esc_html( $mqgiardino ) . ' mq</span></li>';
		}

		if ( ! empty( $immobile_confort ) ) {
			$immobile_confort = '<h2>' . esc_html__( 'Confort', 'immobiliare' ) . '</h2><ul class="menu caratteristiche">' . $immobile_confort . '</ul>';
			$immobile_tabellacaratteristiche .= '</ul>' . $immobile_confort . '<ul class="menu caratteristiche">';
		}

		$immobile_tabellacaratteristiche .= '</ul><h2>' . esc_html__( 'Struttura', 'immobiliare' ) . '</h2><ul class="menu caratteristiche">';

		$piano = rwmb_meta( 'immobili_piano' );
		if ( ! empty( $piano ) ) {
			$numpiani = rwmb_meta( 'immobili_numeropiani' );
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Piano:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $piano ) . ' ' . esc_html__( 'di', 'immobiliare' ) . ' ' . esc_html( $numpiani ) . ' ' . esc_html__( 'piani', 'immobiliare' ) . '</span></li>';
		}

		$stato = rwmb_meta( 'immobili_stato' );
		if ( ! empty( $stato ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Stato immobile:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $stato ) . '</span></li>';
		}

		$riscaldamento = rwmb_meta( 'immobili_riscaldamento' );
		if ( ! empty( $riscaldamento ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Riscaldamento:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $riscaldamento ) . '</span></li>';
		}

		$tiporiscaldamento = rwmb_meta( 'immobili_tiporiscaldamento' );
		if ( ! empty( $tiporiscaldamento ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Tipo riscaldamento:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $tiporiscaldamento ) . '</span></li>';
		}

		$ape = rwmb_meta( 'immobili_ape' );
		if ( ! empty( $ape ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'APE:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $ape ) . '</span></li>';
		}

		$anno = rwmb_meta( 'immobili_anno' );
		if ( ! empty( $anno ) ) {
			$immobile_tabellacaratteristiche .= '<li><span class="label">' . esc_html__( 'Anno Costruzione:', 'immobiliare' ) . '</span> <span class="value">' . esc_html( $anno ) . '</span></li>';
		}

		$immobile_tabellacaratteristiche .= '</ul>';

		$immobile_mappa = '';
		$map_key        = get_option( 'immobiliare_google_api_key' );
		if ( ! empty( $map_key ) ) {
			$args = array(
				'js_options'   => array(
					'mapTypeId'   => 'HYBRID',
					'zoomControl' => true,
				),
				'type'         => 'HYBRID',
				'width'        => '100%',
				'height'       => '400px',
				'zoom'         => 15,
				'marker'       => true,
				'language'     => 'it',
				'marker_title' => 'immobile',
				'info_window'  => rwmb_meta( 'immobili_address' ),
				'api_key'      => $map_key,
			);
			$rendered_map = rwmb_meta( 'immobili_loc', $args );
			if ( ! empty( $rendered_map ) ) {
				$immobile_mappa = '<h2>' . esc_html__( 'Mappa', 'immobiliare' ) . '</h2>' . $rendered_map;
			}
		}

		$content .= $immobile_prezzo . $immobile_video . $immobile_virtualtour . $immobile_galleria . $immobile_planimetria . $immobile_allegati . $immobile_tabellacaratteristiche . $immobile_mappa;
	}

	return $content;
}

if ( get_option( 'immobiliare_metanotincontent' ) !== '1' ) {
	add_filter( 'the_content', 'immobili_aggiungiattributialcontenutoscheda' );
}

if ( get_option( 'immobiliare_metainlist' ) === '1' ) {
	add_filter( 'the_content', 'immobili_aggiungiattributialcontenutolista' );
}

/**
 * Filtri di ricerca aggiuntivi tramite meta_query
 */
function immobili_add_meta_to_search( $query ) {
	if ( ! is_admin() && $query->is_main_query() && ( $query->get( 'post_type' ) === 'immobili' ) ) {
		$meta_queries = array();

		// Riferimento
		if ( isset( $_GET['immobili_rif'] ) && '' !== trim( $_GET['immobili_rif'] ) ) {
			$immobili_rif   = sanitize_text_field( wp_unslash( $_GET['immobili_rif'] ) );
			$meta_queries[] = array(
				'key'     => 'immobili_rif',
				'value'   => $immobili_rif,
				'compare' => '=',
			);
		}

		// Bagni
		if ( isset( $_GET['immobili_bagni'] ) && '' !== trim( $_GET['immobili_bagni'] ) ) {
			$bagni = sanitize_text_field( wp_unslash( $_GET['immobili_bagni'] ) );
			if ( '1' === $bagni || '2' === $bagni ) {
				$meta_queries[] = array(
					'key'     => 'immobili_bagni',
					'value'   => (int) $bagni,
					'compare' => '=',
					'type'    => 'NUMERIC',
				);
			} elseif ( '3' === $bagni ) {
				$meta_queries[] = array(
					'key'     => 'immobili_bagni',
					'value'   => 3,
					'compare' => '>=',
					'type'    => 'NUMERIC',
				);
			}
		}

		// Camere da letto
		if ( isset( $_GET['immobili_cameredaletto'] ) && '' !== trim( $_GET['immobili_cameredaletto'] ) ) {
			$camere = sanitize_text_field( wp_unslash( $_GET['immobili_cameredaletto'] ) );
			if ( in_array( $camere, array( '1', '2', '3' ), true ) ) {
				$meta_queries[] = array(
					'key'     => 'immobili_cameredaletto',
					'value'   => (int) $camere,
					'compare' => '=',
					'type'    => 'NUMERIC',
				);
			} elseif ( '4' === $camere ) {
				$meta_queries[] = array(
					'key'     => 'immobili_cameredaletto',
					'value'   => 4,
					'compare' => '>=',
					'type'    => 'NUMERIC',
				);
			}
		}

		// Superficie MQ
		if ( isset( $_GET['immobili_mq'] ) && '' !== trim( $_GET['immobili_mq'] ) ) {
			$mq = sanitize_text_field( wp_unslash( $_GET['immobili_mq'] ) );
			switch ( $mq ) {
				case '50':
					$meta_queries[] = array(
						'key'     => 'immobili_mq',
						'value'   => 50,
						'compare' => '<=',
						'type'    => 'NUMERIC',
					);
					break;
				case '50_70':
					$meta_queries[] = array(
						'key'     => 'immobili_mq',
						'value'   => array( 50, 70 ),
						'compare' => 'BETWEEN',
						'type'    => 'NUMERIC',
					);
					break;
				case '70_100':
					$meta_queries[] = array(
						'key'     => 'immobili_mq',
						'value'   => array( 70, 100 ),
						'compare' => 'BETWEEN',
						'type'    => 'NUMERIC',
					);
					break;
				case '100_150':
					$meta_queries[] = array(
						'key'     => 'immobili_mq',
						'value'   => array( 100, 150 ),
						'compare' => 'BETWEEN',
						'type'    => 'NUMERIC',
					);
					break;
				case '150_200':
					$meta_queries[] = array(
						'key'     => 'immobili_mq',
						'value'   => array( 150, 200 ),
						'compare' => 'BETWEEN',
						'type'    => 'NUMERIC',
					);
					break;
				case '200':
					$meta_queries[] = array(
						'key'     => 'immobili_mq',
						'value'   => 200,
						'compare' => '>=', // Fixed invalid comparison '=>'
						'type'    => 'NUMERIC',
					);
					break;
			}
		}

		// Prezzo
		if ( isset( $_GET['immobili_prezzo'] ) && '' !== trim( $_GET['immobili_prezzo'] ) ) {
			$prezzo = sanitize_text_field( wp_unslash( $_GET['immobili_prezzo'] ) );
			switch ( $prezzo ) {
				case '50000':
				case '100000':
				case '150000':
					$meta_queries[] = array(
						'key'     => 'immobili_prezzo',
						'value'   => (int) $prezzo,
						'compare' => '<=',
						'type'    => 'NUMERIC',
					);
					break;
				case '1':
					$meta_queries[] = array(
						'key'     => 'immobili_prezzo',
						'value'   => 150000,
						'compare' => '>',
						'type'    => 'NUMERIC',
					);
					break;
			}
		}

		if ( ! empty( $meta_queries ) ) {
			$meta_queries['relation'] = 'AND';
			$query->set( 'meta_query', $meta_queries );
		}
	}

	return $query;
}
add_action( 'pre_get_posts', 'immobili_add_meta_to_search' );
