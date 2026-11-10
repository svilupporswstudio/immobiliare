<?php
defined( 'ABSPATH' ) || exit;

class Immobiliare_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'immobiliare_widget',
			__( 'Immobiliare Widget', 'immobiliare' ),
			array(
				'description'                 => __( 'Widget per form di ricerca immobili del Plugin Immobiliare', 'immobiliare' ),
				'customize_selective_refresh' => true,
			)
		);
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Titolo ricerca', 'immobiliare' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p class="description">
			<?php esc_html_e( 'Widget per modulo di ricerca immobili del Plugin Immobiliare.', 'immobiliare' ); ?>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		return $instance;
	}

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';

		echo $args['before_widget'];
		echo '<div class="widget-text wp_widget_plugin_box">';
		?>
		<form method="get" name="cercaimmobili" class="formcercaimmobili" action="<?php echo esc_url( home_url( '/immobili/' ) ); ?>">
			<h5>
				<?php
				if ( ! empty( $title ) ) {
					echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
				} else {
					echo $args['before_title'] . esc_html__( 'Ricerca Immobili', 'immobiliare' ) . $args['after_title'];
				}
				?>
			</h5>

			<?php
			$terms = get_terms( array(
				'taxonomy'   => 'comuni',
				'orderby'    => 'name',
				'hide_empty' => true,
			) );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				echo '<label for="comuni">' . esc_html__( 'Comune', 'immobiliare' ) . ' <select name="comuni" id="comuni"><option value="">' . esc_html__( 'Comune o Zona', 'immobiliare' ) . '</option>';
				foreach ( $terms as $term ) {
					echo '<option value="' . esc_attr( $term->slug ) . '">' . esc_html( $term->name ) . '</option>';
				}
				echo '</select></label>';
			}

			// Tipologie con gerarchia figli
			$terms = get_terms( array(
				'taxonomy'   => 'tipologia',
				'orderby'    => 'name',
				'hide_empty' => true,
			) );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$list_of_terms  = '<label for="tipologia">' . esc_html__( 'Tipologia', 'immobiliare' ) . ' ';
				$list_of_terms .= '<select name="tipologia" id="tipologia" style="width:100%;"><option value="">' . esc_html__( 'Scegli una tipologia', 'immobiliare' ) . '</option>';

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
				$list_of_terms .= '</select></label>';
				echo $list_of_terms;
			}
			?>

			<label for="immobili_cameredaletto">
				<?php esc_html_e( 'Camere da letto', 'immobiliare' ); ?>
				<select name="immobili_cameredaletto" id="immobili_cameredaletto" style="width:100%;">
					<option value=""><?php esc_html_e( 'Camere da letto', 'immobiliare' ); ?></option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4"><?php esc_html_e( '4 o più', 'immobiliare' ); ?></option>
				</select>
			</label>

			<label for="immobili_bagni">
				<?php esc_html_e( 'Bagni', 'immobiliare' ); ?>
				<select name="immobili_bagni" id="immobili_bagni" style="width:100%;">
					<option value=""><?php esc_html_e( 'Bagni', 'immobiliare' ); ?></option>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3"><?php esc_html_e( '3 o più', 'immobiliare' ); ?></option>
				</select>
			</label>

			<label for="immobili_mq">
				<?php esc_html_e( 'Superficie', 'immobiliare' ); ?>
				<select name="immobili_mq" id="immobili_mq" style="width:100%;">
					<option value=""><?php esc_html_e( 'Superficie', 'immobiliare' ); ?></option>
					<option value="50"><?php esc_html_e( 'fino a 50 mq', 'immobiliare' ); ?></option>
					<option value="50_70"><?php esc_html_e( 'da 50 mq a 70 mq', 'immobiliare' ); ?></option>
					<option value="70_100"><?php esc_html_e( 'da 70 mq a 100 mq', 'immobiliare' ); ?></option>
					<option value="100_150"><?php esc_html_e( 'da 100 mq a 150 mq', 'immobiliare' ); ?></option>
					<option value="150_200"><?php esc_html_e( 'da 150 mq a 200 mq', 'immobiliare' ); ?></option>
					<option value="200"><?php esc_html_e( 'oltre i 200 mq', 'immobiliare' ); ?></option>
				</select>
			</label>

			<label for="immobili_prezzo">
				<?php esc_html_e( 'Prezzo', 'immobiliare' ); ?>
				<select name="immobili_prezzo" id="immobili_prezzo" style="width:100%;">
					<option value=""><?php esc_html_e( 'Prezzo', 'immobiliare' ); ?></option>
					<option value="50000"><?php esc_html_e( 'fino a &euro; 50.000', 'immobiliare' ); ?></option>
					<option value="100000"><?php esc_html_e( 'fino a &euro; 100.000', 'immobiliare' ); ?></option>
					<option value="150000"><?php esc_html_e( 'fino a &euro; 150.000', 'immobiliare' ); ?></option>
					<option value="1"><?php esc_html_e( 'oltre &euro; 150.000', 'immobiliare' ); ?></option>
				</select>
			</label>

			<div class="row">
				<div class="large-12 medium-12 small-12 columns">
					<input type="radio" name="contratto" value="Vendita" id="contattoVendita">
					<label class="radio" for="contattoVendita"><?php esc_html_e( 'Vendita', 'immobiliare' ); ?></label>
				</div>
				<div class="large-12 medium-12 small-12 columns">
					<input type="radio" name="contratto" value="Affitto" id="contrattoAffitto">
					<label class="radio" for="contrattoAffitto"><?php esc_html_e( 'Affitto', 'immobiliare' ); ?></label>
				</div>
				<div class="large-12 medium-12 small-12 columns">
					<button type="submit" class="button btn btn-ricerca"><i class="fa fa-search"></i> <?php esc_html_e( 'Cerca', 'immobiliare' ); ?></button>
				</div>
			</div>
		</form>
		<?php
		echo '</div>';
		echo $args['after_widget'];
	}
}

function immobiliare_register_widget() {
	register_widget( 'Immobiliare_Widget' );
}
add_action( 'widgets_init', 'immobiliare_register_widget' );
