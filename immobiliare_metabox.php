<?php
defined( 'ABSPATH' ) || exit;

add_filter( 'rwmb_meta_boxes', 'immobili_register_meta_boxes' );

/**
 * Register meta boxes
 *
 * @param array $meta_boxes Existing meta boxes
 * @return array
 */
function immobili_register_meta_boxes( $meta_boxes ) {
	$prefix = 'immobili_';
	$tipomappa = 'osm';
	$google_api_key = get_option( 'immobiliare_google_api_key' );
	if ( ! empty( $google_api_key ) ) {
		$tipomappa = 'map';
	}

	$meta_boxes[] = array(
		'id'         => 'immobile',
		'title'      => __( 'Immobile', 'immobiliare' ),
		'post_types' => array( 'immobili' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'autosave'   => true,

		// List of meta fields
		'fields' => array(
			// TEXT
			array(
				'type' => 'heading',
				'name' => __( 'Dati dell\'immobile', 'immobiliare' ),
				'id'   => 'datiheading'
			),
			array(
				'name' => __( 'Vista mare/Vicinanza mare', 'immobiliare' ),
				'id'   => "{$prefix}vistamare",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'No condominio', 'immobiliare' ),
				'id'   => "{$prefix}nocondominio",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name'  => __( 'Rif', 'immobiliare' ),
				'id'    => "{$prefix}rif",
				'type'  => 'text',
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
				array(
				'name'  => __( 'Tipo immobile', 'immobiliare' ),
				'id'    => "{$prefix}tipo",
				'type'  => 'text',
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'type' => 'heading',
				'name' => __( 'Stanze', 'immobiliare' ),
				'desc' => __( 'Scegli di quali stanze è composto l\'immobile, se arredato e i metri quadrati', 'immobiliare' ),
				'id'   => 'stanzeheading'
			),
			array(
				'name'     => __( 'Arredato', 'immobiliare' ),
				'id'       => "{$prefix}arredato",
				'type'     => 'select',
				'options'  => array(
					'si' => __( 'si', 'immobiliare' ),
					'non arredato' => __( 'non arredato', 'immobiliare' ),
					'parzialmente arredato' => __( 'parzialmente arredato', 'immobiliare' ),
				),
				'multiple'    => false,
				'std'         => '-',
				'placeholder' => __( 'Arredato?', 'immobiliare' )
			),
			array(
				'name'  => __( 'mq', 'immobiliare' ),
				'id'    => "{$prefix}mq",
				'type'  => 'number',
				'std'  => 0,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'name'  => __( 'Locali', 'immobiliare' ),
				'id'    => "{$prefix}locali",
				'type'  => 'number',
				'std'   => 2,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'name'  => __( 'Ingresso', 'immobiliare' ),
				'id'    => "{$prefix}ingresso",
				'type'  => 'text',
				'std'  => 0,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'name'     => __( 'Soggiorno', 'immobiliare' ),
				'id'       => "{$prefix}soggiorno",
				'type'     => 'select',
				'options'  => array(
					'si' => __( 'si', 'immobiliare' ),
					'no' => __( 'no', 'immobiliare' ),
					'doppio' => __( 'doppio', 'immobiliare' ),
				),
				'multiple'    => false,
				'std'         => 'abitabile',
				'placeholder' => __( 'Seleziona il soggiorno/salone', 'immobiliare' )
			),
			array(
				'name'     => __( 'Cucina', 'immobiliare' ),
				'id'       => "{$prefix}cucina",
				'type'     => 'select',
				'options'  => array(
					'abitabile' => __( 'abitabile', 'immobiliare' ),
					'a vista' => __( 'a vista', 'immobiliare' ),
					'angolo cottura' => __( 'angolo cottura', 'immobiliare' ),
					'cucinotto' => __( 'cucinotto', 'immobiliare' ),
					'semiabitabile' => __( 'semiabitabile', 'immobiliare' ),
				),
				'multiple'    => false,
				'std'         => 'abitabile',
				'placeholder' => __( 'Seleziona la cucina', 'immobiliare' )
			),
			array(
				'name'     => __( 'Balcone', 'immobiliare' ),
				'id'       => "{$prefix}balcone",
				'type'     => 'select',
				'options'  => array(
					'-' => __( '-', 'immobiliare' ),
					'1' => __( '1', 'immobiliare' ),
					'2' => __( '2', 'immobiliare' ),
					'3' => __( '3', 'immobiliare' ),
					'4' => __( '4', 'immobiliare' ),
					'5' => __( '5', 'immobiliare' ),
				),
				'multiple'    => false,
				'std'         => '-',
				'placeholder' => __( 'Seleziona il balcone', 'immobiliare' )
			),
			array(
				'name'     => __( 'Terrazzo', 'immobiliare' ),
				'id'       => "{$prefix}terrazzo",
				'type'     => 'select',
				'options'  => array(
					'-' => __( '-', 'immobiliare' ),
					'1' => __( '1', 'immobiliare' ),
					'2' => __( '2', 'immobiliare' ),
					'3' => __( '3', 'immobiliare' ),
					'4' => __( '4', 'immobiliare' ),
					'5' => __( '5', 'immobiliare' ),
				),
				'multiple'    => false,
				'std'         => '-',
				'placeholder' => __( 'Seleziona il terrazzo', 'immobiliare' )
			),
			array(
				
				'name'  => __( 'Bagni', 'immobiliare' ),
				'id'    => "{$prefix}bagni",
				'type'  => 'number',
				'std'  => 2,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				
				'name'  => __( 'Camere da letto', 'immobiliare' ),
				'id'    => "{$prefix}cameredaletto",
				'type'  => 'number',
				'std'  => 0,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'name' => __( 'Cantina', 'immobiliare' ),
				'id'   => "{$prefix}cantina",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Solaio', 'immobiliare' ),
				'id'   => "{$prefix}solaio",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Portico', 'immobiliare' ),
				'id'   => "{$prefix}portico",
				'type' => 'checkbox',
				'std'  => 0
			),

			array(
				'type' => 'heading',
				'name' => __( 'Comfort / caratteristiche', 'immobiliare' ),
				'desc' => __( 'Scegli le caratteristiche peculiari e di pregio dell\'immobile', 'immobiliare' ),
				'id'   => 'stanzeheading'
			),
			array(
				'name' => __( 'Piscina', 'immobiliare' ),
				'id'   => "{$prefix}piscina",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Idromassaggio', 'immobiliare' ),
				'id'   => "{$prefix}idromassaggio",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Ascensore', 'immobiliare' ),
				'id'   => "{$prefix}ascensore",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Condizionatore', 'immobiliare' ),
				'id'   => "{$prefix}condizionatore",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Satellite', 'immobiliare' ),
				'id'   => "{$prefix}satellite",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name'     => __( 'Giardino', 'immobiliare' ),
				'id'       => "{$prefix}giardino",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'di proprietà' => __( 'di proprietà', 'immobiliare' ),
					'uso esclusivo' => __( 'uso esclusivo', 'immobiliare' ),
					'condominiale' => __( 'condominiale', 'immobiliare' ),
					'cortile privato' => __( 'cortile privato', 'immobiliare' ),
					'cortile comune' => __( 'cortile comune', 'immobiliare' ),
					'-' => __( '-', 'immobiliare' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '-',
				'placeholder' => __( 'Seleziona il giardino', 'immobiliare' )
			),
			array(
				
				'name'  => __( 'mq giardino', 'immobiliare' ),
				'id'    => "{$prefix}mqgiardino",
				'type'  => 'number',
				'std'   => __( '', 'immobiliare' ),
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'type' => 'heading',
				'name' => __( 'Valore', 'immobiliare' ),
				'desc' => __( 'Prezzo, prezzo precedente, se ha subito un ribasso, spese condominiali, categoria e rendita catastale', 'immobiliare' ),
				'id'   => 'valoreheading'
			),
			array(
				'name'  => __( 'Didascalia prezzo', 'immobiliare' ),
				'id'    => "{$prefix}didascalia_prezzo",
				'type'  => 'text',
				'std'  => 0,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				
				'name'  => __( 'Prezzo precedente', 'immobiliare' ),
				'placeholder'  => __( 'Prezzo precedente', 'immobiliare' ),
				'id'    => "{$prefix}prezzo-precedente",
				'type'  => 'number',
				'clone' => false,
				'min'  => 0,
				'step' => 1,
				'std' => 0
			),
			array(
				'name'  => __( 'Prezzo', 'immobiliare' ),
				'placeholder'  => __( 'Prezzo', 'immobiliare' ),
				'id'    => "{$prefix}prezzo",
				'type'  => 'number',
				'std'  => 0,
				'clone' => false
			),
			array(
				'name'     => __( 'Categoria Catastale', 'immobiliare' ),
				'id'       => "{$prefix}categoriacatastale",
				'type'     => 'select',
				'options'  => array(
					'A/1' => __( 'A/1', 'immobiliare' ),
					'A/2' => __( 'A/2', 'immobiliare' ),
					'A/3' => __( 'A/3', 'immobiliare' ),
					'A/4' => __( 'A/4', 'immobiliare' ),
					'A/5' => __( 'A/5', 'immobiliare' ),
					'A/6' => __( 'A/6', 'immobiliare' ),
					'A/7' => __( 'A/7', 'immobiliare' ),
					'A/8' => __( 'A/8', 'immobiliare' ),
					'A/9' => __( 'A/9', 'immobiliare' ),
					'A/10' => __( 'A/10', 'immobiliare' ),
					'A/11' => __( 'A/11', 'immobiliare' ),
					'B/1' => __( 'B/1', 'immobiliare' ),
					'B/2' => __( 'B/2', 'immobiliare' ),
					'B/3' => __( 'B/3', 'immobiliare' ),
					'B/4' => __( 'B/4', 'immobiliare' ),
					'B/5' => __( 'B/5', 'immobiliare' ),
					'B/6' => __( 'B/6', 'immobiliare' ),
					'B/7' => __( 'B/7', 'immobiliare' ),
					'B/8' => __( 'B/8', 'immobiliare' ),
					'C/1' => __( 'C/1', 'immobiliare' ),
					'C/2' => __( 'C/2', 'immobiliare' ),
					'C/3' => __( 'C/3', 'immobiliare' ),
					'C/4' => __( 'C/4', 'immobiliare' ),
					'C/5' => __( 'C/5', 'immobiliare' ),
					'C/6' => __( 'C/6', 'immobiliare' ),
					'C/7' => __( 'C/7', 'immobiliare' ),
					'D/1' => __( 'D/1', 'immobiliare' ),
					'D/2' => __( 'D/2', 'immobiliare' ),
					'D/3' => __( 'D/3', 'immobiliare' ),
					'D/4' => __( 'D/4', 'immobiliare' ),
					'D/5' => __( 'D/5', 'immobiliare' ),
					'D/6' => __( 'D/6', 'immobiliare' ),
					'D/7' => __( 'D/7', 'immobiliare' ),
					'D/8' => __( 'D/8', 'immobiliare' ),
					'D/9' => __( 'D/9', 'immobiliare' ),
					'D/10' => __( 'D/10', 'immobiliare' ),
					'E/1' => __( 'E/1', 'immobiliare' ),
					'E/2' => __( 'E/2', 'immobiliare' ),
					'E/3' => __( 'E/3', 'immobiliare' ),
					'E/4' => __( 'E/4', 'immobiliare' ),
					'E/5' => __( 'E/5', 'immobiliare' ),
					'E/6' => __( 'E/6', 'immobiliare' ),
					'E/7' => __( 'E/7', 'immobiliare' ),
					'E/8' => __( 'E/8', 'immobiliare' ),
					'E/9' => __( 'E/9', 'immobiliare' ),
					'F/1' => __( 'F/1', 'immobiliare' ),
					'F/2' => __( 'F/2', 'immobiliare' ),
					'F/3' => __( 'F/3', 'immobiliare' ),
					'F/4' => __( 'F/4', 'immobiliare' ),
					'F/5' => __( 'F/5', 'immobiliare' ),
					'F/6' => __( 'F/6', 'immobiliare' ),
					'F/7' => __( 'F/7', 'immobiliare' ),
				),
				'multiple'    => false,
				'std'         => '-',
				'placeholder' => __( 'Categoria catastale?', 'immobiliare' )
			),
			array(
				'name'  => __( 'Rendita catastale', 'immobiliare' ),
				'id'    => "{$prefix}renditacatastale",
				'type'  => 'number',
				'clone' => false,
				'min'  => 0,
				'step' => .01
			),
 			array(				
				'name'  => __( 'Spese condominiali', 'immobiliare' ),
				'placeholder'  => __( 'Spese condominiali', 'immobiliare' ),
				'id'    => "{$prefix}spese",
				'type'  => 'number',
				'std'  => 0,
				'clone' => false
			),
			array(
				'name'     => __( 'Tipo spese', 'immobiliare' ),
				'id'       => "{$prefix}spesetipo",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'mensili' => __( 'mensili', 'immobiliare' ),
					'annuali' => __( 'annuali', 'immobiliare' ),
					'nessuna' => __( 'nessuna', 'immobiliare' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'mensili',
				'placeholder' => __( 'Seleziona il tipo di spese', 'immobiliare' )
			),


			array(
				'type' => 'heading',
				'name' => __( 'Parcheggi', 'immobiliare' ),
				'desc' => __( 'Posti auto, moto e bici, se interni, esterni o privati', 'immobiliare' ),
				'id'   => 'parcheggiheading'
			),
			array(
				'name'     => __( 'Posto cicli,motocicli', 'immobiliare' ),
				'id'       => "{$prefix}postomotocicli",
				'type'     => 'select',
				'options'  => array(
					'-' => __( '-', 'immobiliare' ),
					'interno' => __( 'interno', 'immobiliare' ),
					'esterno' => __( 'esterno', 'immobiliare' ),
					'privato' => __( 'privato', 'immobiliare' ),
					
					
				),
				'multiple'    => false,
				'std'         => 'esterno',
				'placeholder' => __( 'Seleziona il posto cicli motocicli', 'immobiliare' )
			),
			array(
				'name'     => __( 'Posto auto', 'immobiliare' ),
				'id'       => "{$prefix}postoauto",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'-' => __( '-', 'immobiliare' ),
					'privato' => __( 'privato', 'immobiliare' ),
					'box singolo' => __( 'box singolo', 'immobiliare' ),
					'box doppio' => __( 'box doppio', 'immobiliare' ),
					'box triplo' => __( 'box triplo', 'immobiliare' ),
					'box quadruplo' => __( 'box quadruplo', 'immobiliare' ),
					'posto auto coperto' => __( 'posto auto coperto', 'immobiliare' ),
					'posto auto scoperto' => __( 'posto auto scoperto', 'immobiliare' ),
					'posto auto condominiale' => __( 'posto auto condominiale', 'immobiliare' ),
					'facilità di parcheggio' => __( 'facilità di parcheggio', 'immobiliare' ),
					'posto interno' => __( 'posto interno', 'immobiliare' ),
					'posto assegnato' => __( 'posto assegnato', 'immobiliare' ),
					'garage' => __( 'garage', 'immobiliare' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'piano terra',
				'placeholder' => __( 'Seleziona il posto auto', 'immobiliare' )
			),
      
			array(
				'type' => 'heading',
				'name' => __( 'Struttura dell\'immobile', 'immobiliare' ),
				'desc' => __( 'Composizione e stato del palazzo o dell\'immobile', 'immobiliare' ),
				'id'   => 'palazzoheading'
			),
			array(
				'name'     => __( 'Piano', 'immobiliare' ),
				'id'       => "{$prefix}piano",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'su due livelli' => __( 'su due livelli', 'immobiliare' ),
					'su più livelli' => __( 'su più livelli', 'immobiliare' ),
					'interrato' => __( 'interrato', 'immobiliare' ),
					'semi interrato' => __( 'semi interrato', 'immobiliare' ),
					'piano terra' => __( 'piano terra', 'immobiliare' ),
					'piano rialzato' => __( 'piano rialzato', 'immobiliare' ),
					'1' => __( '1', 'immobiliare' ),
					'2' => __( '2', 'immobiliare' ),
					'3' => __( '3', 'immobiliare' ),
					'4' => __( '4', 'immobiliare' ),
					'5' => __( '5', 'immobiliare' ),
					'6' => __( '6', 'immobiliare' ),
					'7' => __( '7', 'immobiliare' ),
					'8' => __( '8', 'immobiliare' ),
					'9' => __( '9', 'immobiliare' ),
					'10' => __( '10', 'immobiliare' ),
					'piano alto' => __( 'piano alto', 'immobiliare' ),
					'ultimo' => __( 'ultimo', 'immobiliare' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'piano terra',
				'placeholder' => __( 'Seleziona il piano', 'immobiliare' )
			),
			array(
				
				'name'  => __( 'Numero piani', 'immobiliare' ),
				'id'    => "{$prefix}numeropiani",
				'type'  => 'number',
				'std'  => 1,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'name'     => __( 'Stato', 'immobiliare' ),
				'id'       => "{$prefix}stato",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'nuovo' => __( 'nuovo', 'immobiliare' ),
					'in costruzione' => __( 'in costruzione', 'immobiliare' ),
					'ristrutturato' => __( 'ristrutturato', 'immobiliare' ),
					'ottimo' => __( 'ottimo', 'immobiliare' ),
					'buono' => __( 'buono', 'immobiliare' ),
					'discreto' => __( 'discreto', 'immobiliare' ),
					'sufficiente' => __( 'sufficiente', 'immobiliare' ),
					'da sistemare' => __( 'da sistemare', 'immobiliare' ),
					'da ristrutturare' => __( 'da ristrutturare', 'immobiliare' ),
					'abitabile' => __( 'abitabile', 'immobiliare' ),
					'occupato' => __( 'occupato', 'immobiliare' ),
					'edificabile' => __( 'edificabile', 'immobiliare' ),
					'al grezzo' => __( 'al grezzo', 'immobiliare' ),
					'in ristrutturazione' => __( 'in ristrutturazione', 'immobiliare' ),
					'da completare' => __( 'da completare', 'immobiliare' ),
					'rifiniture di lusso' => __( 'rifiniture di lusso', 'immobiliare' ),
					'affittato' => __( 'affittato', 'immobiliare' ),
					'altro' => __( 'altro', 'immobiliare' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'usato',
				'placeholder' => __( 'Seleziona lo stato', 'immobiliare' )
			),
      
			array(
				'name'     => __( 'Occupazione', 'immobiliare' ),
				'id'       => "{$prefix}Occupazione",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'libero' => __( 'libero', 'immobiliare' ),
					'occupato' => __( 'occupato', 'immobiliare' ),
					'affittato' => __( 'affittato', 'immobiliare' ),
					'altro' => __( 'altro', 'immobiliare' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'libero',
				'placeholder' => __( 'Seleziona occupazione', 'immobiliare' )
			),
      
			array(
				'name'     => __( 'Riscaldamento', 'immobiliare' ),
				'id'       => "{$prefix}riscaldamento",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'autonomo' => __( 'autonomo', 'immobiliare' ),
					'autonomo a pavimento' => __( 'autonomo a pavimento', 'immobiliare' ),
					'centralizzato' => __( 'centralizzato', 'immobiliare' ),
					'centralizzato con contacalorie' => __( 'centralizzato con contacalorie', 'immobiliare' ),
					'assente' => __( 'assente', 'immobiliare' ),
					'pompa di calore' => __( 'pompa di calore', 'immobiliare' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'autonomo',
				'placeholder' => __( 'Seleziona il riscaldamento', 'immobiliare' )
			),
			array(
				'name'     => __( 'Tipo di riscaldamento', 'immobiliare' ),
				'id'       => "{$prefix}tiporiscaldamento",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'metano' => __( 'metano', 'immobiliare' ),
					'gasolio' => __( 'gasolio', 'immobiliare' ),
					'gpl' => __( 'gpl', 'immobiliare' ),
					'legna' => __( 'legna', 'immobiliare' ),
					'misto' => __( 'misto', 'immobiliare' ),
					'elettrico' => __( 'elettrico', 'immobiliare' ),
					'pompadicalore' => __( 'pompa di calore', 'immobiliare' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'metano',
				'placeholder' => __( 'Seleziona il tipo di riscaldamento', 'immobiliare' )
			),
			
			array(
				
				'name'  => __( 'APE', 'immobiliare' ),
				'id'    => "{$prefix}ape",
				'type'  => 'text',
				'clone' => false
			),
			array(
				
				'name'  => __( 'Anno di costruzione', 'immobiliare' ),
				'id'    => "{$prefix}anno",
				'type'  => 'number',
				'clone' => false,
				'step' => 1
			),
			array(
				'type' => 'heading',
				'name' => __( 'Gallery', 'immobiliare' ),
				'desc' => __( 'Selezione multipla della galleria delle foto dell\'immobile', 'immobiliare' ),
				'id'   => 'galleryheading'
			),
			array(
				'name'             => __( 'Galleria immagini', 'immobiliare' ),
				'id'               => "{$prefix}galleria",
				'type'             => 'image_advanced'
			),
			array(
				'type' => 'heading',
				'name' => __( 'Allegati (solo PDF)', 'immobiliare' ),
				'desc' => __( 'Allegati quali planimetrie, capitolati,  progetti, certificazioni e altro', 'immobiliare' ),
				'id'   => 'allegatiheading'
			),
			array(
				'name'             => __( 'File PDF da allegare', 'immobiliare' ),
				'id'               => "{$prefix}allegati",
				'type'             => 'file_advanced',
				'max_file_uploads' => 5
			),
			array(
				'type' => 'heading',
				'name' => __( 'Planimetria', 'immobiliare' ),
				'desc' => __( 'Allega le foto delle planimetrie', 'immobiliare' ),
				'id'   => 'planimetriaheading'
			),
			array(
				'name' => __( 'Planimetria', 'immobiliare' ),
				'id'   => "{$prefix}planimetria",
				'type' => 'image_advanced'
			),
			array(
				'type' => 'heading',
				'name' => __( 'Video e Virtual Tour', 'immobiliare' ),
				'desc' => __( 'Seleziona il video dopo averlo caricato su YouTube e specifica il Virtual Tour completo di link', 'immobiliare' ),
				'id'   => 'videoheading',
			),
			array(
				'name'  => __( 'Video YouTube', 'immobiliare' ),
				'id'    => "{$prefix}video",
				'type'  => 'oembed',
				'size'  => 100,
				'desc'  => 'Video YouTube'
			),
			array(
				'name'  => __( 'Link Virtual Tour', 'immobiliare' ),
				'id'    => "{$prefix}virtualtour",
				'type' => 'text',
			),
			array(
				'type' => 'heading',
				'name' => __( 'Mappa', 'immobiliare' ),
				'desc' => __( 'Mappa ed ubicazione dell\'immobile', 'immobiliare' ),
				'id'   => 'mappaheading',
			),
			array(
				'id' => "{$prefix}address",
				'name' => __( 'Indirizzo', 'immobiliare' ),
				'type' => 'text',
			),
			array(
				
				'name'  => __( 'Zona', 'immobiliare' ),
				'id'    => "{$prefix}zona",
				'type'  => 'text',
				'clone' => false,
				'min'  => 0,
				'step' => 1,
			),
			array(
				'name'          => __( 'Geolocalizzazione', 'immobiliare' ),
				'id'            => "{$prefix}loc",
				'style'         => 'width: 100%; height: 450px;',
				'type'          => $tipomappa,
				'api_key'       => $google_api_key,
				'address_field' => "{$prefix}address",
				'language'      => 'it',
				'region'        => 'IT',
				'std'           => '44.494887,11.342616,15',
				'js_options'    => array(
					'mapTypeId'         => 'HYBRID',
					'zoomControl'       => true,
					'streetViewControl' => true,
					'mapTypeControl'    => true,
					'fullscreenControl' => true,
				),
			),
		)
	);
	return $meta_boxes;
}
