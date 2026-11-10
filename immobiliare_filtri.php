<?php
defined( 'ABSPATH' ) || exit;

add_action( 'restrict_manage_posts', 'restrict_manage_posts_immobiliare' );

function restrict_manage_posts_immobiliare() {
	$type = isset( $_GET['post_type'] ) ? sanitize_key( $_GET['post_type'] ) : 'post';

	if ( 'immobili' === $type ) {
		// Filtro Comuni
		$current_v = isset( $_GET['comuni'] ) ? sanitize_text_field( wp_unslash( $_GET['comuni'] ) ) : '';
		$terms     = get_terms( array(
			'taxonomy'   => 'comuni',
			'orderby'    => 'name',
			'hide_empty' => false,
		) );
		?>
		<select name="comuni">
			<option value=""><?php esc_html_e( 'Filtra per comune', 'immobiliare' ); ?></option>
			<?php
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					printf(
						'<option value="%s"%s>%s</option>',
						esc_attr( $term->slug ),
						selected( $current_v, $term->slug, false ),
						esc_html( $term->name )
					);
				}
			}
			?>
		</select>

		<!-- Filtro Tipologia -->
		<?php
		$current_v = isset( $_GET['tipologia'] ) ? sanitize_text_field( wp_unslash( $_GET['tipologia'] ) ) : '';
		$terms     = get_terms( array(
			'taxonomy'   => 'tipologia',
			'orderby'    => 'name',
			'hide_empty' => false,
		) );
		?>
		<select name="tipologia">
			<option value=""><?php esc_html_e( 'Filtra per tipologia', 'immobiliare' ); ?></option>
			<?php
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					printf(
						'<option value="%s"%s>%s</option>',
						esc_attr( $term->slug ),
						selected( $current_v, $term->slug, false ),
						esc_html( $term->name )
					);
				}
			}
			?>
		</select>

		<!-- Filtro Contratto -->
		<?php
		$current_v = isset( $_GET['contratto'] ) ? sanitize_text_field( wp_unslash( $_GET['contratto'] ) ) : '';
		$terms     = get_terms( array(
			'taxonomy'   => 'contratto',
			'orderby'    => 'name',
			'hide_empty' => false,
		) );
		?>
		<select name="contratto">
			<option value=""><?php esc_html_e( 'Filtra per contratto', 'immobiliare' ); ?></option>
			<?php
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					printf(
						'<option value="%s"%s>%s</option>',
						esc_attr( $term->slug ),
						selected( $current_v, $term->slug, false ),
						esc_html( $term->name )
					);
				}
			}
			?>
		</select>

		<!-- Filtro Tag -->
		<?php
		$current_v = isset( $_GET['immobili_tag'] ) ? sanitize_text_field( wp_unslash( $_GET['immobili_tag'] ) ) : '';
		$terms     = get_terms( array(
			'taxonomy'   => 'immobili_tag',
			'orderby'    => 'name',
			'hide_empty' => false,
		) );
		?>
		<select name="immobili_tag">
			<option value=""><?php esc_html_e( 'Filtra per tag', 'immobiliare' ); ?></option>
			<?php
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					printf(
						'<option value="%s"%s>%s</option>',
						esc_attr( $term->slug ),
						selected( $current_v, $term->slug, false ),
						esc_html( $term->name )
					);
				}
			}
			?>
		</select>
		<?php
	}
}

add_filter( 'parse_query', 'parse_query_immobiliare' );

function parse_query_immobiliare( $query ) {
	global $pagenow;
	$type = isset( $_GET['post_type'] ) ? sanitize_key( $_GET['post_type'] ) : 'post';

	if ( 'immobili' === $type && is_admin() && 'edit.php' === $pagenow && isset( $_GET['ADMIN_FILTER_FIELD_VALUE'] ) && '' !== $_GET['ADMIN_FILTER_FIELD_VALUE'] ) {
		$query->query_vars['meta_key']   = 'META_KEY';
		$query->query_vars['meta_value'] = sanitize_text_field( wp_unslash( $_GET['ADMIN_FILTER_FIELD_VALUE'] ) );
	}
}
