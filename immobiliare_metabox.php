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
				'name' => __( 'Dati dell\'immobile', 'meta-box' ),
				'id'   => 'datiheading'
			),
			array(
				'name' => __( 'Vista mare/Vicinanza mare', 'meta-box' ),
				'id'   => "{$prefix}vistamare",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'No condominio', 'meta-box' ),
				'id'   => "{$prefix}nocondominio",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name'  => __( 'Rif', 'meta-box' ),
				'id'    => "{$prefix}rif",
				'type'  => 'text',
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
				array(
				'name'  => __( 'Tipo immobile', 'meta-box' ),
				'id'    => "{$prefix}tipo",
				'type'  => 'text',
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'type' => 'heading',
				'name' => __( 'Stanze', 'meta-box' ),
				'desc' => __( 'Scegli di quali stanze è composto l\'immobile, se arredato e i metri quadrati', 'immobiliare' ),
				'id'   => 'stanzeheading'
			),
			array(
				'name'     => __( 'Arredato', 'meta-box' ),
				'id'       => "{$prefix}arredato",
				'type'     => 'select',
				'options'  => array(
					'si' => __( 'si', 'meta-box' ),
					'non arredato' => __( 'non arredato', 'meta-box' ),
					'parzialmente arredato' => __( 'parzialmente arredato', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => '-',
				'placeholder' => __( 'Arredato?', 'meta-box' )
			),
			array(
				'name'  => __( 'mq', 'meta-box' ),
				'id'    => "{$prefix}mq",
				'type'  => 'number',
				'std'  => 0,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'name'  => __( 'Locali', 'meta-box' ),
				'id'    => "{$prefix}locali",
				'type'  => 'number',
				'std'   => 2,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'name'  => __( 'Ingresso', 'meta-box' ),
				'id'    => "{$prefix}ingresso",
				'type'  => 'text',
				'std'  => 0,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'name'     => __( 'Soggiorno', 'meta-box' ),
				'id'       => "{$prefix}soggiorno",
				'type'     => 'select',
				'options'  => array(
					'si' => __( 'si', 'meta-box' ),
					'no' => __( 'no', 'meta-box' ),
					'doppio' => __( 'doppio', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => 'abitabile',
				'placeholder' => __( 'Seleziona il soggiorno/salone', 'meta-box' )
			),
			array(
				'name'     => __( 'Cucina', 'meta-box' ),
				'id'       => "{$prefix}cucina",
				'type'     => 'select',
				'options'  => array(
					'abitabile' => __( 'abitabile', 'meta-box' ),
					'a vista' => __( 'a vista', 'meta-box' ),
					'angolo cottura' => __( 'angolo cottura', 'meta-box' ),
					'cucinotto' => __( 'cucinotto', 'meta-box' ),
					'semiabitabile' => __( 'semiabitabile', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => 'abitabile',
				'placeholder' => __( 'Seleziona la cucina', 'meta-box' )
			),
			array(
				'name'     => __( 'Balcone', 'meta-box' ),
				'id'       => "{$prefix}balcone",
				'type'     => 'select',
				'options'  => array(
					'-' => __( '-', 'meta-box' ),
					'1' => __( '1', 'meta-box' ),
					'2' => __( '2', 'meta-box' ),
					'3' => __( '3', 'meta-box' ),
					'4' => __( '4', 'meta-box' ),
					'5' => __( '5', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => '-',
				'placeholder' => __( 'Seleziona il balcone', 'meta-box' )
			),
			array(
				'name'     => __( 'Terrazzo', 'meta-box' ),
				'id'       => "{$prefix}terrazzo",
				'type'     => 'select',
				'options'  => array(
					'-' => __( '-', 'meta-box' ),
					'1' => __( '1', 'meta-box' ),
					'2' => __( '2', 'meta-box' ),
					'3' => __( '3', 'meta-box' ),
					'4' => __( '4', 'meta-box' ),
					'5' => __( '5', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => '-',
				'placeholder' => __( 'Seleziona il terrazzo', 'meta-box' )
			),
			array(
				
				'name'  => __( 'Bagni', 'meta-box' ),
				'id'    => "{$prefix}bagni",
				'type'  => 'number',
				'std'  => 2,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				
				'name'  => __( 'Camere da letto', 'meta-box' ),
				'id'    => "{$prefix}cameredaletto",
				'type'  => 'number',
				'std'  => 0,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'name' => __( 'Cantina', 'meta-box' ),
				'id'   => "{$prefix}cantina",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Solaio', 'meta-box' ),
				'id'   => "{$prefix}solaio",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Portico', 'meta-box' ),
				'id'   => "{$prefix}portico",
				'type' => 'checkbox',
				'std'  => 0
			),

			array(
				'type' => 'heading',
				'name' => __( 'Comfort / caratteristiche', 'meta-box' ),
				'desc' => __( 'Scegli le caratteristiche peculiari e di pregio dell\'immobile', '{$prefix}' ),
				'id'   => 'stanzeheading'
			),
			array(
				'name' => __( 'Piscina', 'meta-box' ),
				'id'   => "{$prefix}piscina",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Idromassaggio', 'meta-box' ),
				'id'   => "{$prefix}idromassaggio",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Ascensore', 'meta-box' ),
				'id'   => "{$prefix}ascensore",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Condizionatore', 'meta-box' ),
				'id'   => "{$prefix}condizionatore",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name' => __( 'Satellite', 'meta-box' ),
				'id'   => "{$prefix}satellite",
				'type' => 'checkbox',
				'std'  => 0
			),
			array(
				'name'     => __( 'Giardino', 'meta-box' ),
				'id'       => "{$prefix}giardino",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'di proprietà' => __( 'di proprietà', 'meta-box' ),
					'uso esclusivo' => __( 'uso esclusivo', 'meta-box' ),
					'condominiale' => __( 'condominiale', 'meta-box' ),
					'cortile privato' => __( 'cortile privato', 'meta-box' ),
					'cortile comune' => __( 'cortile comune', 'meta-box' ),
					'-' => __( '-', 'meta-box' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '-',
				'placeholder' => __( 'Seleziona il giardino', 'meta-box' )
			),
			array(
				
				'name'  => __( 'mq giardino', 'meta-box' ),
				'id'    => "{$prefix}mqgiardino",
				'type'  => 'number',
				'std'   => __( '', 'meta-box' ),
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'type' => 'heading',
				'name' => __( 'Valore', 'meta-box' ),
				'desc' => __( 'Prezzo, prezzo precedente, se ha subito un ribasso, spese condominiali, categoria e rendita catastale', '{$prefix}' ),
				'id'   => 'valoreheading'
			),
			array(
				'name'  => __( 'Didascalia prezzo', 'meta-box' ),
				'id'    => "{$prefix}didascalia_prezzo",
				'type'  => 'text',
				'std'  => 0,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				
				'name'  => __( 'Prezzo precedente', 'meta-box' ),
				'placeholder'  => __( 'Prezzo precedente', 'meta-box' ),
				'id'    => "{$prefix}prezzo-precedente",
				'type'  => 'number',
				'clone' => false,
				'min'  => 0,
				'step' => 1,
				'std' => 0
			),
			array(
				'name'  => __( 'Prezzo', 'meta-box' ),
				'placeholder'  => __( 'Prezzo', 'meta-box' ),
				'id'    => "{$prefix}prezzo",
				'type'  => 'number',
				'std'  => 0,
				'clone' => false
			),
			array(
				'name'     => __( 'Categoria Catastale', 'meta-box' ),
				'id'       => "{$prefix}categoriacatastale",
				'type'     => 'select',
				'options'  => array(
					'A/1' => __( 'A/1', 'meta-box' ),
					'A/2' => __( 'A/2', 'meta-box' ),
					'A/3' => __( 'A/3', 'meta-box' ),
					'A/4' => __( 'A/4', 'meta-box' ),
					'A/5' => __( 'A/5', 'meta-box' ),
					'A/6' => __( 'A/6', 'meta-box' ),
					'A/7' => __( 'A/7', 'meta-box' ),
					'A/8' => __( 'A/8', 'meta-box' ),
					'A/9' => __( 'A/9', 'meta-box' ),
					'A/10' => __( 'A/10', 'meta-box' ),
					'A/11' => __( 'A/11', 'meta-box' ),
					'B/1' => __( 'B/1', 'meta-box' ),
					'B/2' => __( 'B/2', 'meta-box' ),
					'B/3' => __( 'B/3', 'meta-box' ),
					'B/4' => __( 'B/4', 'meta-box' ),
					'B/5' => __( 'B/5', 'meta-box' ),
					'B/6' => __( 'B/6', 'meta-box' ),
					'B/7' => __( 'B/7', 'meta-box' ),
					'B/8' => __( 'B/8', 'meta-box' ),
					'C/1' => __( 'C/1', 'meta-box' ),
					'C/2' => __( 'C/2', 'meta-box' ),
					'C/3' => __( 'C/3', 'meta-box' ),
					'C/4' => __( 'C/4', 'meta-box' ),
					'C/5' => __( 'C/5', 'meta-box' ),
					'C/6' => __( 'C/6', 'meta-box' ),
					'C/7' => __( 'C/7', 'meta-box' ),
					'D/1' => __( 'D/1', 'meta-box' ),
					'D/2' => __( 'D/2', 'meta-box' ),
					'D/3' => __( 'D/3', 'meta-box' ),
					'D/4' => __( 'D/4', 'meta-box' ),
					'D/5' => __( 'D/5', 'meta-box' ),
					'D/6' => __( 'D/6', 'meta-box' ),
					'D/7' => __( 'D/7', 'meta-box' ),
					'D/8' => __( 'D/8', 'meta-box' ),
					'D/9' => __( 'D/9', 'meta-box' ),
					'D/10' => __( 'D/10', 'meta-box' ),
					'E/1' => __( 'E/1', 'meta-box' ),
					'E/2' => __( 'E/2', 'meta-box' ),
					'E/3' => __( 'E/3', 'meta-box' ),
					'E/4' => __( 'E/4', 'meta-box' ),
					'E/5' => __( 'E/5', 'meta-box' ),
					'E/6' => __( 'E/6', 'meta-box' ),
					'E/7' => __( 'E/7', 'meta-box' ),
					'E/8' => __( 'E/8', 'meta-box' ),
					'E/9' => __( 'E/9', 'meta-box' ),
					'F/1' => __( 'F/1', 'meta-box' ),
					'F/2' => __( 'F/2', 'meta-box' ),
					'F/3' => __( 'F/3', 'meta-box' ),
					'F/4' => __( 'F/4', 'meta-box' ),
					'F/5' => __( 'F/5', 'meta-box' ),
					'F/6' => __( 'F/6', 'meta-box' ),
					'F/7' => __( 'F/7', 'meta-box' ),
				),
				'multiple'    => false,
				'std'         => '-',
				'placeholder' => __( 'Categoria catastale?', 'meta-box' )
			),
			array(
				'name'  => __( 'Rendita catastale', 'meta-box' ),
				'id'    => "{$prefix}renditacatastale",
				'type'  => 'number',
				'clone' => false,
				'min'  => 0,
				'step' => .01
			),
 			array(				
				'name'  => __( 'Spese condominiali', 'meta-box' ),
				'placeholder'  => __( 'Spese condominiali', 'meta-box' ),
				'id'    => "{$prefix}spese",
				'type'  => 'number',
				'std'  => 0,
				'clone' => false
			),
			array(
				'name'     => __( 'Tipo spese', 'meta-box' ),
				'id'       => "{$prefix}spesetipo",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'mensili' => __( 'mensili', 'meta-box' ),
					'annuali' => __( 'annuali', 'meta-box' ),
					'nessuna' => __( 'nessuna', 'meta-box' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'mensili',
				'placeholder' => __( 'Seleziona il tipo di spese', 'meta-box' )
			),


			array(
				'type' => 'heading',
				'name' => __( 'Parcheggi', 'meta-box' ),
				'desc' => __( 'Posti auto, moto e bici, se interni, esterni o privati', '{$prefix}' ),
				'id'   => 'parcheggiheading'
			),
			array(
				'name'     => __( 'Posto cicli,motocicli', 'meta-box' ),
				'id'       => "{$prefix}postomotocicli",
				'type'     => 'select',
				'options'  => array(
					'-' => __( '-', 'meta-box' ),
					'interno' => __( 'interno', 'meta-box' ),
					'esterno' => __( 'esterno', 'meta-box' ),
					'privato' => __( 'privato', 'meta-box' ),
					
					
				),
				'multiple'    => false,
				'std'         => 'esterno',
				'placeholder' => __( 'Seleziona il posto cicli motocicli', 'meta-box' )
			),
			array(
				'name'     => __( 'Posto auto', 'meta-box' ),
				'id'       => "{$prefix}postoauto",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'-' => __( '-', 'meta-box' ),
					'privato' => __( 'privato', 'meta-box' ),
					'box singolo' => __( 'box singolo', 'meta-box' ),
					'box doppio' => __( 'box doppio', 'meta-box' ),
					'box triplo' => __( 'box triplo', 'meta-box' ),
					'box quadruplo' => __( 'box quadruplo', 'meta-box' ),
					'posto auto coperto' => __( 'posto auto coperto', 'meta-box' ),
					'posto auto scoperto' => __( 'posto auto scoperto', 'meta-box' ),
					'posto auto condominiale' => __( 'posto auto condominiale', 'meta-box' ),
					'facilità di parcheggio' => __( 'facilità di parcheggio', 'meta-box' ),
					'posto interno' => __( 'posto interno', 'meta-box' ),
					'posto assegnato' => __( 'posto assegnato', 'meta-box' ),
					'garage' => __( 'garage', 'meta-box' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'piano terra',
				'placeholder' => __( 'Seleziona il posto auto', 'meta-box' )
			),
      
			array(
				'type' => 'heading',
				'name' => __( 'Struttura dell\'immobile', 'meta-box' ),
				'desc' => __( 'Composizione e stato del palazzo o dell\'immobile', '{$prefix}' ),
				'id'   => 'palazzoheading'
			),
			array(
				'name'     => __( 'Piano', 'meta-box' ),
				'id'       => "{$prefix}piano",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'su due livelli' => __( 'su due livelli', 'meta-box' ),
					'su più livelli' => __( 'su più livelli', 'meta-box' ),
					'interrato' => __( 'interrato', 'meta-box' ),
					'semi interrato' => __( 'semi interrato', 'meta-box' ),
					'piano terra' => __( 'piano terra', 'meta-box' ),
					'piano rialzato' => __( 'piano rialzato', 'meta-box' ),
					'1' => __( '1', 'meta-box' ),
					'2' => __( '2', 'meta-box' ),
					'3' => __( '3', 'meta-box' ),
					'4' => __( '4', 'meta-box' ),
					'5' => __( '5', 'meta-box' ),
					'6' => __( '6', 'meta-box' ),
					'7' => __( '7', 'meta-box' ),
					'8' => __( '8', 'meta-box' ),
					'9' => __( '9', 'meta-box' ),
					'10' => __( '10', 'meta-box' ),
					'piano alto' => __( 'piano alto', 'meta-box' ),
					'ultimo' => __( 'ultimo', 'meta-box' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'piano terra',
				'placeholder' => __( 'Seleziona il piano', 'meta-box' )
			),
			array(
				
				'name'  => __( 'Numero piani', 'meta-box' ),
				'id'    => "{$prefix}numeropiani",
				'type'  => 'number',
				'std'  => 1,
				'clone' => false,
				'min'  => 0,
				'step' => 1
			),
			array(
				'name'     => __( 'Stato', 'meta-box' ),
				'id'       => "{$prefix}stato",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'nuovo' => __( 'nuovo', 'meta-box' ),
					'in costruzione' => __( 'in costruzione', 'meta-box' ),
					'ristrutturato' => __( 'ristrutturato', 'meta-box' ),
					'ottimo' => __( 'ottimo', 'meta-box' ),
					'buono' => __( 'buono', 'meta-box' ),
					'discreto' => __( 'discreto', 'meta-box' ),
					'sufficiente' => __( 'sufficiente', 'meta-box' ),
					'da sistemare' => __( 'da sistemare', 'meta-box' ),
					'da ristrutturare' => __( 'da ristrutturare', 'meta-box' ),
					'abitabile' => __( 'abitabile', 'meta-box' ),
					'occupato' => __( 'occupato', 'meta-box' ),
					'edificabile' => __( 'edificabile', 'meta-box' ),
					'al grezzo' => __( 'al grezzo', 'meta-box' ),
					'in ristrutturazione' => __( 'in ristrutturazione', 'meta-box' ),
					'da completare' => __( 'da completare', 'meta-box' ),
					'rifiniture di lusso' => __( 'rifiniture di lusso', 'meta-box' ),
					'affittato' => __( 'affittato', 'meta-box' ),
					'altro' => __( 'altro', 'meta-box' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'usato',
				'placeholder' => __( 'Seleziona lo stato', 'meta-box' )
			),
      
			array(
				'name'     => __( 'Occupazione', 'meta-box' ),
				'id'       => "{$prefix}Occupazione",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'libero' => __( 'libero', 'meta-box' ),
					'occupato' => __( 'occupato', 'meta-box' ),
					'affittato' => __( 'affittato', 'meta-box' ),
					'altro' => __( 'altro', 'meta-box' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'libero',
				'placeholder' => __( 'Seleziona occupazione', 'meta-box' )
			),
      
			array(
				'name'     => __( 'Riscaldamento', 'meta-box' ),
				'id'       => "{$prefix}riscaldamento",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'autonomo' => __( 'autonomo', 'meta-box' ),
					'autonomo a pavimento' => __( 'autonomo a pavimento', 'meta-box' ),
					'centralizzato' => __( 'centralizzato', 'meta-box' ),
					'centralizzato con contacalorie' => __( 'centralizzato con contacalorie', 'meta-box' ),
					'assente' => __( 'assente', 'meta-box' ),
					'pompa di calore' => __( 'pompa di calore', 'meta-box' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'autonomo',
				'placeholder' => __( 'Seleziona il riscaldamento', 'meta-box' )
			),
			array(
				'name'     => __( 'Tipo di riscaldamento', 'meta-box' ),
				'id'       => "{$prefix}tiporiscaldamento",
				'type'     => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'  => array(
					'metano' => __( 'metano', 'meta-box' ),
					'gasolio' => __( 'gasolio', 'meta-box' ),
					'gpl' => __( 'gpl', 'meta-box' ),
					'legna' => __( 'legna', 'meta-box' ),
					'misto' => __( 'misto', 'meta-box' ),
					'elettrico' => __( 'elettrico', 'meta-box' ),
					'pompadicalore' => __( 'pompa di calore', 'meta-box' ),
				),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => 'metano',
				'placeholder' => __( 'Seleziona il tipo di riscaldamento', 'meta-box' )
			),
			
			array(
				
				'name'  => __( 'APE', 'meta-box' ),
				'id'    => "{$prefix}ape",
				'type'  => 'text',
				'clone' => false
			),
			array(
				
				'name'  => __( 'Anno di costruzione', 'meta-box' ),
				'id'    => "{$prefix}anno",
				'type'  => 'number',
				'clone' => false,
				'step' => 1
			),
			array(
				'type' => 'heading',
				'name' => __( 'Gallery', 'meta-box' ),
				'desc' => __( 'Selezione multipla della galleria delle foto dell\'immobile', '{$prefix}' ),
				'id'   => 'galleryheading'
			),
			array(
				'name'             => __( 'Galleria immagini', 'meta-box' ),
				'id'               => "{$prefix}galleria",
				'type'             => 'image_advanced'
			),
			array(
				'type' => 'heading',
				'name' => __( 'Allegati (solo PDF)', 'meta-box' ),
				'desc' => __( 'Allegati quali planimetrie, capitolati,  progetti, certificazioni e altro', '{$prefix}' ),
				'id'   => 'allegatiheading'
			),
			array(
				'name'             => __( 'File PDF da allegare', 'meta-box' ),
				'id'               => "{$prefix}allegati",
				'type'             => 'file_advanced',
				'max_file_uploads' => 5
			),
			array(
				'type' => 'heading',
				'name' => __( 'Planimetria', 'meta-box' ),
				'desc' => __( 'Allega le foto delle planimetrie', '{$prefix}' ),
				'id'   => 'planimetriaheading'
			),
			array(
				'name' => __( 'Planimetria', 'meta-box' ),
				'id'   => "{$prefix}planimetria",
				'type' => 'image_advanced'
			),
			array(
				'type' => 'heading',
				'name' => __( 'Video e Virtual Tour', 'meta-box' ),
				'desc' => __( 'Seleziona il video dopo averlo caricato su YouTube e specifica il Virtual Tour completo di link', '{$prefix}' ),
				'id'   => 'videoheading',
			),
			array(
				'name'  => __( 'Video YouTube', 'meta-box' ),
				'id'    => "{$prefix}video",
				'type'  => 'oembed',
				'size'  => 100,
				'desc'  => 'Video YouTube'
			),
			array(
				'name'  => __( 'Link Virtual Tour', 'meta-box' ),
				'id'    => "{$prefix}virtualtour",
				'type' => 'text',
			),
			array(
				'type' => 'heading',
				'name' => __( 'Mappa', 'meta-box' ),
				'desc' => __( 'Mappa ed ubicazione dell\'immobile', '{$prefix}' ),
				'id'   => 'mappaheading',
			),
			array(
				'id' => "{$prefix}address",
				'name' => __( 'Indirizzo', 'meta-box' ),
				'type' => 'text',
			),
			array(
				
				'name'  => __( 'Zona', 'meta-box' ),
				'id'    => "{$prefix}zona",
				'type'  => 'text',
				'clone' => false,
				'min'  => 0,
				'step' => 1,
			),
			array(
				'name' => __( 'Geolocalizzazione', 'meta-box' ),
				'id'    => "{$prefix}loc",
				'style' => 'width: 500px; height: 500px',
				'type'  => $tipomappa,
				'api_key'       => get_option('immobiliare_google_api_key'),
				'address_field' => "{$prefix}address" 
			),
		)
	);
	return $meta_boxes;
}
