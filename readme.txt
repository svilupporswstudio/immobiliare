=== Immobiliare ===
Contributors: Matteo Testoni
Donate link: https://www.matteotestoni.it
Tags: immobiliare, agenzia immobiliare, agenzie immobiliari, impresa edile, imprese edili, annunci immobiliari, real estate, realestate, apartment, real estate directory, realtor, properties
Requires at least: 7.1
Tested up to: 7.1
Requires PHP: 8.3
Requires Plugins: meta-box
Stable tag: 7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin per la gestione di immobili per agenzie immobiliari e imprese edili.

== Description ==

ENG
Plugin for the management of real estate: real estate agents, builders and construction companies, real estate franchising and small owners.
Allows the inclusion of real estate for sale or rent going to specify the various types such as apartments, villas, cottages etc.
It also allows the inclusion of galleries, floor plans, attached pdf for specifications and more.

ITA
Plugin per la gestione di immobili per agenzie immobiliari, costruttori e imprese edili, franchising immobiliari e piccoli proprietari.
Permette l'inserimento degli immobili in vendita o in affitto andando a specificare le varie tipologie come appartamenti, ville, villette ecc.
Consente inoltre l'inserimento di gallerie, planimetrie, allegati pdf per capitolati e molto altro.

### Plugin all'indirizzo https://www.matteotestoni.it/servizi/programmatore-esperto-wordpress/plugin-immobiliare-wordpress/

### Immobiliare Plugin by https://www.matteotestoni.it

== Installation ==

= ENG =
1. Upload the 'immobiliare' directory to the '/wp-content/plugins/' directory.
2. Ensure 'Meta Box' is installed (WordPress 6.5+ automatically prompts via Plugin Dependencies).
3. Activate the plugin through the 'Plugins' menu in WordPress.

= ITA =
1. Carica la cartella 'immobiliare' su '/wp-content/plugins/' (o installa via file ZIP da Bacheca > Plugin > Aggiungi nuovo).
2. Assicurati che 'Meta Box' sia installato (gestito nativamente da WordPress 6.5+ tramite Plugin Dependencies).
3. Attiva il plugin attraverso la sezione 'Plugin' nel pannello di amministrazione WordPress.

== Frequently Asked Questions ==

= Quali sono i requisiti minimi? =
Il plugin richiede WordPress 7.1 o superiore, PHP 8.3 o superiore e il plugin dipendente "Meta Box".

= Come vengono gestite le dipendenze? =
A partire da WordPress 6.5, il plugin sfrutta la funzionalità nativa "Plugin Dependencies" con l'header `Requires Plugins: meta-box`, rimuovendo qualsiasi script o avviso manuale di terze parti.

== Screenshots ==
1. screenshot-1.jpg
2. screenshot-2.jpg

== Changelog ==

= 7.2.0 =
* Aggiunta colonna con l'anteprima dell'immagine in evidenza (Foto) come prima colonna nell'elenco immobili in bacheca WordPress (admin), con link diretto alla modifica e badge di fallback.
* Verifica e armonizzazione completa dell'internazionalizzazione: 100% delle funzioni di traduzione (__ , _e, esc_html__, esc_attr__, _x) utilizzano il text domain 'immobiliare'.
* Protezione dell'accesso diretto ai file: inserito blocco 'defined( 'ABSPATH' ) || exit;' in tutti i file PHP e file sentinella 'index.php' nella radice e in tutte le sottocartelle (css/, img/, lang/).
* Modernizzazione dell'integrazione Google Maps: aggiornate le opzioni JavaScript della mappa (gestureHandling, controlli avanzati, caricamento con attributi async/defer) e integrato fallback nativo OpenStreetMap in assenza di API key Google.

= 7.1.0 =
* Aggiunto supporto nativo a WordPress 6.5+ Plugin Dependencies (`Requires Plugins: meta-box`).
* Rimossi controlli manuali e libreria TGMPA (`class-tgm-plugin-activation.php` e `immobiliare_pluginaggiuntivi.php`).
* Aggiornato requisito minimo a WordPress 7.1 e PHP 8.3 (`Requires at least: 7.1`, `Requires PHP: 8.3`).
* Aggiornata versione testata e stabile a WordPress 7.1 (`Tested up to: 7.1`, `Stable tag: 7.1`).
* Aggiornato link di riferimento del plugin all'indirizzo ufficiale: https://www.matteotestoni.it/servizi/programmatore-esperto-wordpress/plugin-immobiliare-wordpress/
* Rimozione di tutto il codice deprecato WordPress:
  - Sostituito l'hook deprecato `contextual_help` (deprecato da WP 3.3) con `current_screen` e `$screen->add_help_tab()`.
  - Rimossi i tag e markup grafici legacy `.icon32` / `#icon-tools` (deprecati da WP 3.8).
  - Modernizzata la chiamata a `get_terms()` sostituendo la vecchia sintassi `$taxonomy, $args` (deprecata da WP 4.5) con `get_terms( array( 'taxonomy' => ... ) )`.
  - Corretti i text domain per internazionalizzazione con `_x()` e `__()` usando `'immobiliare'`.
  - Sistemate verifiche sicure su parametri `$_GET` e compatibilità con PHP 8.3 (nessun warning per array key non definita o count() su non-array).
  - Corretto l'operatore di confronto SQL `'compare' => '>='` nella ricerca per superficie.

= 2.8.0 =
* Versione precedente con supporto iniziale per opzioni avanzate.

= 2.6.0 =
* Compatibilità Metabox 5.5.1.
* Compatibilità WordPress 5.9.0.
* Tolta l'opzione googleplus, aggiunta opzione instagram.
