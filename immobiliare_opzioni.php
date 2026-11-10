<?php
defined( 'ABSPATH' ) || exit;

function immobiliare_menu() {
	add_options_page(
		__( 'Immobiliare', 'immobiliare' ),
		__( 'Immobiliare', 'immobiliare' ),
		'manage_options',
		'immobiliare',
		'immobiliare_opzioni'
	);
}

function immobiliare_registraopzioni() {
	$options = array(
		'immobiliare_metanotincontent'  => 'sanitize_text_field',
		'immobiliare_metainlist'         => 'sanitize_text_field',
		'immobiliare_azienda_nome'       => 'sanitize_text_field',
		'immobiliare_azienda_indirizzo'  => 'sanitize_text_field',
		'immobiliare_azienda_comune'     => 'sanitize_text_field',
		'immobiliare_azienda_provincia'  => 'sanitize_text_field',
		'immobiliare_azienda_partitaiva' => 'sanitize_text_field',
		'immobiliare_azienda_rea'        => 'sanitize_text_field',
		'immobiliare_azienda_telefono'   => 'sanitize_text_field',
		'immobiliare_azienda_email'      => 'sanitize_email',
		'immobiliare_azienda_logo'       => 'esc_url_raw',
		'immobiliare_azienda_colore'     => 'sanitize_hex_color',
		'immobiliare_google_api_key'     => 'sanitize_text_field',
		'immobiliare_azienda_facebook'   => 'esc_url_raw',
		'immobiliare_azienda_youtube'    => 'esc_url_raw',
		'immobiliare_azienda_twitter'    => 'esc_url_raw',
		'immobiliare_azienda_instagram'  => 'esc_url_raw',
	);

	foreach ( $options as $option_name => $sanitize_cb ) {
		register_setting( 'immobiliare_opzioni', $option_name, array(
			'sanitize_callback' => $sanitize_cb,
			'show_in_rest'      => false,
		) );
	}
}

function immobiliare_opzioni() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Opzioni Plugin Immobiliare', 'immobiliare' ); ?></h1>
		<p><?php esc_html_e( "Inserisci i dati dell'agenzia immobiliare o dell'impresa edile.", 'immobiliare' ); ?></p>
		
		<form method="post" action="options.php" enctype="multipart/form-data">
			<?php settings_fields( 'immobiliare_opzioni' ); ?>
			<?php do_settings_sections( 'immobiliare' ); ?>
			
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row" colspan="2">
							<hr>
							<h2><?php esc_html_e( 'Configurazioni plugin', 'immobiliare' ); ?></h2>
						</th>
					</tr>
					<tr>
						<th scope="row">
							<label for="immobiliare_metanotincontent"><?php esc_html_e( 'Nascondi i dati nella scheda immobile', 'immobiliare' ); ?></label>
						</th>
						<td>
							<input name="immobiliare_metanotincontent" type="checkbox" id="immobiliare_metanotincontent" value="1" <?php checked( get_option( 'immobiliare_metanotincontent' ), '1' ); ?> />
							<p class="description"><?php esc_html_e( 'Se attivo, i campi NON saranno aggiunti automaticamente al contenuto e sarà possibile personalizzare il tema.', 'immobiliare' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="immobiliare_metainlist"><?php esc_html_e( 'Visualizza i dati nella lista immobili', 'immobiliare' ); ?></label>
						</th>
						<td>
							<input name="immobiliare_metainlist" type="checkbox" id="immobiliare_metainlist" value="1" <?php checked( get_option( 'immobiliare_metainlist' ), '1' ); ?> />
						</td>
					</tr>

					<tr>
						<th scope="row" colspan="2">
							<hr>
							<h2><?php esc_html_e( 'Anagrafica azienda', 'immobiliare' ); ?></h2>
						</th>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_nome"><?php esc_html_e( 'Nome azienda', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_nome" type="text" id="immobiliare_azienda_nome" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_nome' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_indirizzo"><?php esc_html_e( 'Indirizzo azienda', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_indirizzo" type="text" id="immobiliare_azienda_indirizzo" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_indirizzo' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_comune"><?php esc_html_e( 'Comune azienda', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_comune" type="text" id="immobiliare_azienda_comune" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_comune' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_provincia"><?php esc_html_e( 'Provincia azienda', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_provincia" type="text" id="immobiliare_azienda_provincia" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_provincia' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_partitaiva"><?php esc_html_e( 'Partita IVA azienda', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_partitaiva" type="text" id="immobiliare_azienda_partitaiva" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_partitaiva' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_rea"><?php esc_html_e( 'REA azienda', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_rea" type="text" id="immobiliare_azienda_rea" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_rea' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_telefono"><?php esc_html_e( 'Telefono azienda', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_telefono" type="text" id="immobiliare_azienda_telefono" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_telefono' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_email"><?php esc_html_e( 'Email azienda', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_email" type="email" id="immobiliare_azienda_email" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_email' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_logo"><?php esc_html_e( 'Logo azienda (URL)', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_logo" type="url" id="immobiliare_azienda_logo" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_logo' ) ); ?>" class="regular-text" />
							<p class="description"><?php esc_html_e( 'URL del logo aziendale caricato nella sezione Media.', 'immobiliare' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_colore"><?php esc_html_e( 'Colore sociale azienda', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_colore" type="text" id="immobiliare_azienda_colore" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_colore' ) ); ?>" class="regular-text" placeholder="#ff0000" />
							<p class="description"><?php esc_html_e( 'Colore esadecimale (es: #ff0000).', 'immobiliare' ); ?></p>
						</td>
					</tr>

					<tr>
						<th scope="row" colspan="2">
							<hr>
							<h2><?php esc_html_e( 'Google Maps JavaScript API', 'immobiliare' ); ?></h2>
						</th>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_google_api_key"><?php esc_html_e( 'Google API Key', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_google_api_key" type="text" id="immobiliare_google_api_key" value="<?php echo esc_attr( get_option( 'immobiliare_google_api_key' ) ); ?>" class="regular-text" />
							<p class="description"><?php esc_html_e( 'Chiave API per visualizzare le mappe Google negli annunci.', 'immobiliare' ); ?> <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank" rel="noopener"><?php esc_html_e( 'Ottieni chiave', 'immobiliare' ); ?></a></p>
						</td>
					</tr>

					<tr>
						<th scope="row" colspan="2">
							<hr>
							<h2><?php esc_html_e( 'Canali Social', 'immobiliare' ); ?></h2>
						</th>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_facebook"><?php esc_html_e( 'Indirizzo Facebook', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_facebook" type="url" id="immobiliare_azienda_facebook" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_facebook' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_youtube"><?php esc_html_e( 'Indirizzo YouTube', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_youtube" type="url" id="immobiliare_azienda_youtube" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_youtube' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_twitter"><?php esc_html_e( 'Indirizzo Twitter / X', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_twitter" type="url" id="immobiliare_azienda_twitter" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_twitter' ) ); ?>" class="regular-text" />
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="immobiliare_azienda_instagram"><?php esc_html_e( 'Indirizzo Instagram', 'immobiliare' ); ?></label></th>
						<td>
							<input name="immobiliare_azienda_instagram" type="url" id="immobiliare_azienda_instagram" value="<?php echo esc_attr( get_option( 'immobiliare_azienda_instagram' ) ); ?>" class="regular-text" />
						</td>
					</tr>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

if ( is_admin() ) {
	add_action( 'admin_menu', 'immobiliare_menu' );
	add_action( 'admin_init', 'immobiliare_registraopzioni' );
}
