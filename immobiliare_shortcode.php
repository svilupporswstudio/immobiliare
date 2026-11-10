<?php
defined( 'ABSPATH' ) || exit;

function immobili_ultimiinseriti() {
	$immobili_args                  = array(
		'posts_per_page' => 10,
		'post_type'      => 'immobili',
		'post_status'    => 'publish',
	);
	$immobili_ultimiimmobiliinseriti = get_posts( $immobili_args );

	$immobili_strReturn = '<h2>' . esc_html__( 'Ultimi immobili inseriti', 'immobiliare' ) . '</h2><ul class="ultimiimmobiliinseriti">';
	foreach ( $immobili_ultimiimmobiliinseriti as $immobile ) {
		$immobili_strReturn .= '<li><a href="' . esc_url( get_permalink( $immobile->ID ) ) . '">' . esc_html( get_the_title( $immobile->ID ) ) . '</a></li>';
	}
	$immobili_strReturn .= '</ul>';

	return $immobili_strReturn;
}

function immobili_ultimivendita() {
	$immobili_args = array(
		'posts_per_page' => 10,
		'post_type'      => 'immobili',
		'post_status'    => 'publish',
		'tax_query'      => array(
			array(
				'taxonomy' => 'contratto',
				'field'    => 'slug',
				'terms'    => 'vendita',
			),
		),
	);
	$immobili_ultimiimmobiliinseriti = get_posts( $immobili_args );

	$immobili_strReturn = '<h2>' . esc_html__( 'Ultimi immobili in vendita', 'immobiliare' ) . '</h2><ul class="ultimiimmobilivendita">';
	foreach ( $immobili_ultimiimmobiliinseriti as $immobile ) {
		$immobili_strReturn .= '<li><a href="' . esc_url( get_permalink( $immobile->ID ) ) . '">' . esc_html( get_the_title( $immobile->ID ) ) . '</a></li>';
	}
	$immobili_strReturn .= '</ul>';

	return $immobili_strReturn;
}

function immobili_ultimiaffitto() {
	$immobili_args = array(
		'posts_per_page' => 10,
		'post_type'      => 'immobili',
		'post_status'    => 'publish',
		'tax_query'      => array(
			array(
				'taxonomy' => 'contratto',
				'field'    => 'slug',
				'terms'    => 'affitto',
			),
		),
	);
	$immobili_ultimiimmobiliinseriti = get_posts( $immobili_args );

	$immobili_strReturn = '<h2>' . esc_html__( 'Ultimi immobili in affitto', 'immobiliare' ) . '</h2><ul class="ultimiimmobiliaffitto">';
	foreach ( $immobili_ultimiimmobiliinseriti as $immobile ) {
		$immobili_strReturn .= '<li><a href="' . esc_url( get_permalink( $immobile->ID ) ) . '">' . esc_html( get_the_title( $immobile->ID ) ) . '</a></li>';
	}
	$immobili_strReturn .= '</ul>';

	return $immobili_strReturn;
}

function immobili_ricerca() {
	$immobili_strReturn  = '<div>';
	$immobili_strReturn .= '<form method="get" name="cercaimmobili" class="formcercaimmobili" action="' . esc_url( home_url( '/immobili/' ) ) . '">';
	$immobili_strReturn .= '<h3>' . esc_html__( 'Ricerca Immobili', 'immobiliare' ) . '</h3>';

	$terms = get_terms( array(
		'taxonomy'   => 'comuni',
		'orderby'    => 'name',
		'hide_empty' => true,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$immobili_strReturn .= '<label for="comuni">' . esc_html__( 'Località', 'immobiliare' ) . ' <select name="comuni" id="comuni"><option value="">' . esc_html__( 'Scegli una località', 'immobiliare' ) . '</option>';
		foreach ( $terms as $term ) {
			$immobili_strReturn .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
		}
		$immobili_strReturn .= '</select></label>';
	}

	$terms = get_terms( array(
		'taxonomy'   => 'contratto',
		'orderby'    => 'name',
		'hide_empty' => true,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$immobili_strReturn .= '<label for="contratto">' . esc_html__( 'Contratto', 'immobiliare' ) . ' <select name="contratto" id="contratto"><option value="">' . esc_html__( 'Scegli un contratto', 'immobiliare' ) . '</option>';
		foreach ( $terms as $term ) {
			$immobili_strReturn .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
		}
		$immobili_strReturn .= '</select></label>';
	}

	$terms = get_terms( array(
		'taxonomy'   => 'categoria',
		'orderby'    => 'name',
		'hide_empty' => true,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$immobili_strReturn .= '<label for="categoria">' . esc_html__( 'Categoria', 'immobiliare' ) . ' <select name="categoria" id="categoria"><option value="">' . esc_html__( 'Scegli una categoria', 'immobiliare' ) . '</option>';
		foreach ( $terms as $term ) {
			$immobili_strReturn .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
		}
		$immobili_strReturn .= '</select></label>';
	}

	$terms = get_terms( array(
		'taxonomy'   => 'tipologia',
		'orderby'    => 'name',
		'hide_empty' => true,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$list_of_terms  = '<label for="tipologia">' . esc_html__( 'Tipologia', 'immobiliare' ) . ' ';
		$list_of_terms .= '<select name="tipologia" id="tipologia"><option value="">' . esc_html__( 'Scegli una tipologia', 'immobiliare' ) . '</option>';
		foreach ( $terms as $term ) {
			if ( 0 === (int) $term->parent ) {
				$tchildren = get_term_children( $term->term_id, 'tipologia' );
				$children  = array();
				if ( ! empty( $tchildren ) && ! is_wp_error( $tchildren ) ) {
					foreach ( $tchildren as $child ) {
						$cterm = get_term_by( 'id', $child, 'tipologia' );
						if ( $cterm ) {
							$children[ $cterm->name ] = $cterm;
						}
					}
					ksort( $children );
				}

				if ( count( $children ) > 0 ) {
					$list_of_terms .= '<optgroup label="' . esc_attr( $term->name ) . '">';
					if ( $term->count > 0 ) {
						$list_of_terms .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html__( 'Tutto', 'immobiliare' ) . ' ' . esc_html( $term->name ) . ' (' . (int) $term->count . ')</option>';
					}
				} else {
					$list_of_terms .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . ' (' . (int) $term->count . ')</option>';
				}

				foreach ( $children as $child ) {
					$list_of_terms .= '<option value="' . esc_attr( $child->slug ) . '">' . esc_html( $child->name ) . ' (' . (int) $child->count . ')</option>';
				}

				if ( count( $children ) > 0 ) {
					$list_of_terms .= '</optgroup>';
				}
			}
		}
		$list_of_terms      .= '</select></label>';
		$immobili_strReturn .= $list_of_terms;
	}

	$immobili_strReturn .= '<label for="immobili_cameredaletto">' . esc_html__( 'Camere', 'immobiliare' ) . ' <select name="immobili_cameredaletto" id="immobili_cameredaletto">';
	$immobili_strReturn .= '<option value="">' . esc_html__( 'Camere', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="1">1</option>';
	$immobili_strReturn .= '<option value="2">2</option>';
	$immobili_strReturn .= '<option value="3">3</option>';
	$immobili_strReturn .= '<option value="4">4</option>';
	$immobili_strReturn .= '<option value="0">' . esc_html__( 'Più di 4', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '</select></label>';

	$immobili_strReturn .= '<label for="immobili_mq">' . esc_html__( 'Superficie', 'immobiliare' ) . ' <select name="immobili_mq" id="immobili_mq">';
	$immobili_strReturn .= '<option value="">' . esc_html__( 'Superficie', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="50">' . esc_html__( 'fino a 50 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="50_70">' . esc_html__( 'da 50 mq a 70 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="70_100">' . esc_html__( 'da 70 mq a 100 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="100_150">' . esc_html__( 'da 100 mq a 150 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="150_200">' . esc_html__( 'da 150 mq a 200 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="200">' . esc_html__( 'oltre i 200 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '</select></label>';

	$immobili_strReturn .= '<label for="immobili_prezzo">' . esc_html__( 'Prezzo', 'immobiliare' ) . ' <select name="immobili_prezzo" id="immobili_prezzo">';
	$immobili_strReturn .= '<option value="">' . esc_html__( 'Prezzo', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="50000">' . esc_html__( 'fino a &euro; 50.000', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="100000">' . esc_html__( 'fino a &euro; 100.000', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="150000">' . esc_html__( 'fino a &euro; 150.000', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="1">' . esc_html__( 'oltre &euro; 150.000', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '</select></label>';

	$immobili_strReturn .= '<div style="margin-top:1rem"><button type="submit" class="button round ricerca expand avia-button avia-size-large avia-position-center"><i class="fa fa-search fa-fw" style="margin:0;"></i> ' . esc_html__( 'Cerca', 'immobiliare' ) . '</button></div>';
	$immobili_strReturn .= '</form></div>';

	return $immobili_strReturn;
}

function immobili_ricerca_enfold() {
	$immobili_strReturn  = '<div>';
	$immobili_strReturn .= '<form method="get" name="cercaimmobili" class="formcercaimmobili" action="' . esc_url( home_url( '/immobili/' ) ) . '">';
	$immobili_strReturn .= '<h3>' . esc_html__( 'Ricerca Immobili', 'immobiliare' ) . '</h3>';

	$terms = get_terms( array(
		'taxonomy'   => 'comuni',
		'orderby'    => 'name',
		'hide_empty' => true,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$list_of_terms  = '<div style="float:left;min-width:150px;width:auto;padding:0 10px;">';
		$list_of_terms .= '<select name="comuni" id="comuni"><option value="">' . esc_html__( 'Comune o Zona', 'immobiliare' ) . '</option>';
		foreach ( $terms as $term ) {
			if ( 0 === (int) $term->parent ) {
				$tchildren = get_term_children( $term->term_id, 'comuni' );
				$children  = array();
				if ( ! empty( $tchildren ) && ! is_wp_error( $tchildren ) ) {
					foreach ( $tchildren as $child ) {
						$cterm = get_term_by( 'id', $child, 'comuni' );
						if ( $cterm ) {
							$children[ $cterm->name ] = $cterm;
						}
					}
					ksort( $children );
				}

				if ( count( $children ) > 0 ) {
					$list_of_terms .= '<optgroup label="' . esc_attr( $term->name ) . '">';
					if ( $term->count > 0 ) {
						$list_of_terms .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html__( 'Tutto', 'immobiliare' ) . ' ' . esc_html( $term->name ) . ' (' . (int) $term->count . ')</option>';
					}
				} else {
					$list_of_terms .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . ' (' . (int) $term->count . ')</option>';
				}

				foreach ( $children as $child ) {
					$list_of_terms .= '<option value="' . esc_attr( $child->slug ) . '">' . esc_html( $child->name ) . ' (' . (int) $child->count . ')</option>';
				}

				if ( count( $children ) > 0 ) {
					$list_of_terms .= '</optgroup>';
				}
			}
		}
		$list_of_terms      .= '</select></div>';
		$immobili_strReturn .= $list_of_terms;
	}

	$terms = get_terms( array(
		'taxonomy'   => 'contratto',
		'orderby'    => 'name',
		'hide_empty' => true,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$immobili_strReturn .= '<div style="float:left;min-width:150px;width:auto;padding:0 10px;"><select name="contratto" id="contratto"><option value="">' . esc_html__( 'Contratto', 'immobiliare' ) . '</option>';
		foreach ( $terms as $term ) {
			$immobili_strReturn .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
		}
		$immobili_strReturn .= '</select></div>';
	}

	$terms = get_terms( array(
		'taxonomy'   => 'categoria',
		'orderby'    => 'name',
		'hide_empty' => true,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$immobili_strReturn .= '<div style="float:left;min-width:150px;width:auto;padding:0 10px;"><select name="categoria" id="categoria"><option value="">' . esc_html__( 'Categoria', 'immobiliare' ) . '</option>';
		foreach ( $terms as $term ) {
			$immobili_strReturn .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
		}
		$immobili_strReturn .= '</select></div>';
	}

	$terms = get_terms( array(
		'taxonomy'   => 'tipologia',
		'orderby'    => 'name',
		'hide_empty' => true,
	) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$list_of_terms  = '<div style="float:left;min-width:150px;width:auto;padding:0 10px;">';
		$list_of_terms .= '<select name="tipologia" id="tipologia"><option value="">' . esc_html__( 'Tipologia', 'immobiliare' ) . '</option>';
		foreach ( $terms as $term ) {
			if ( 0 === (int) $term->parent ) {
				$tchildren = get_term_children( $term->term_id, 'tipologia' );
				$children  = array();
				if ( ! empty( $tchildren ) && ! is_wp_error( $tchildren ) ) {
					foreach ( $tchildren as $child ) {
						$cterm = get_term_by( 'id', $child, 'tipologia' );
						if ( $cterm ) {
							$children[ $cterm->name ] = $cterm;
						}
					}
					ksort( $children );
				}

				if ( count( $children ) > 0 ) {
					$list_of_terms .= '<optgroup label="' . esc_attr( $term->name ) . '">';
					if ( $term->count > 0 ) {
						$list_of_terms .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html__( 'Tutto', 'immobiliare' ) . ' ' . esc_html( $term->name ) . ' (' . (int) $term->count . ')</option>';
					}
				} else {
					$list_of_terms .= '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . ' (' . (int) $term->count . ')</option>';
				}

				foreach ( $children as $child ) {
					$list_of_terms .= '<option value="' . esc_attr( $child->slug ) . '">' . esc_html( $child->name ) . ' (' . (int) $child->count . ')</option>';
				}

				if ( count( $children ) > 0 ) {
					$list_of_terms .= '</optgroup>';
				}
			}
		}
		$list_of_terms      .= '</select></div>';
		$immobili_strReturn .= $list_of_terms;
	}

	$immobili_strReturn .= '<div style="float:left;min-width:150px;width:auto;padding:0 10px;"><select name="immobili_cameredaletto" id="immobili_cameredaletto">';
	$immobili_strReturn .= '<option value="">' . esc_html__( 'Camere', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="1">1</option>';
	$immobili_strReturn .= '<option value="2">2</option>';
	$immobili_strReturn .= '<option value="3">3</option>';
	$immobili_strReturn .= '<option value="4">4</option>';
	$immobili_strReturn .= '<option value="0">' . esc_html__( 'Più di 4', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '</select></div>';

	$immobili_strReturn .= '<div style="float:left;min-width:150px;width:auto;padding:0 10px;"><select name="immobili_mq" id="immobili_mq">';
	$immobili_strReturn .= '<option value="">' . esc_html__( 'Superficie', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="50">' . esc_html__( 'fino a 50 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="50_70">' . esc_html__( 'da 50 mq a 70 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="70_100">' . esc_html__( 'da 70 mq a 100 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="100_150">' . esc_html__( 'da 100 mq a 150 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="150_200">' . esc_html__( 'da 150 mq a 200 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="200">' . esc_html__( 'oltre i 200 mq', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '</select></div>';

	$immobili_strReturn .= '<div style="float:left;min-width:150px;width:auto;padding:0 10px;"><select name="immobili_prezzo" id="immobili_prezzo">';
	$immobili_strReturn .= '<option value="">' . esc_html__( 'Prezzo', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="50000">' . esc_html__( 'fino a &euro; 50.000', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="100000">' . esc_html__( 'fino a &euro; 100.000', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="150000">' . esc_html__( 'fino a &euro; 150.000', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '<option value="1">' . esc_html__( 'oltre &euro; 150.000', 'immobiliare' ) . '</option>';
	$immobili_strReturn .= '</select></div>';

	$immobili_strReturn .= '<div style="float:left;min-width:150px;width:auto;padding:0 10px;">';
	$immobili_strReturn .= '<input type="radio" name="contratto" value="Vendita" id="contattoVendita"><label class="radio" for="contattoVendita">' . esc_html__( 'Vendita', 'immobiliare' ) . '</label>';
	$immobili_strReturn .= '<input type="radio" name="contratto" value="Affitto" id="contrattoAffitto"><label class="radio" for="contrattoAffitto">' . esc_html__( 'Affitto', 'immobiliare' ) . '</label>';
	$immobili_strReturn .= '</div>';

	$immobili_strReturn .= '<div style="float:left;min-width:150px;width:auto;padding:0 10px;"><button type="submit" class="button round ricerca expand avia-button avia-size-large avia-position-center"><i class="fa fa-search fa-fw" style="margin:0;"></i> ' . esc_html__( 'Cerca', 'immobiliare' ) . '</button></div>';
	$immobili_strReturn .= '</form></div>';

	return $immobili_strReturn;
}

add_shortcode( 'immobili_ultimiinseriti', 'immobili_ultimiinseriti' );
add_shortcode( 'immobili_ultimivendita', 'immobili_ultimivendita' );
add_shortcode( 'immobili_ultimiaffitto', 'immobili_ultimiaffitto' );
add_shortcode( 'immobili_ricerca', 'immobili_ricerca' );
add_shortcode( 'immobili_ricerca_enfold', 'immobili_ricerca_enfold' );
