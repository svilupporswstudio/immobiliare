# Plugin Immobiliare per WordPress (v7.2.0)

[![WordPress Tested Up To](https://img.shields.io/badge/WordPress-7.1%2B-blue.svg)](https://wordpress.org/plugins/immobiliare/)
[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777bb4.svg)](https://www.php.net)
[![Plugin Dependency](https://img.shields.io/badge/Requires%20Plugin-Meta%20Box-emerald.svg)](https://wordpress.org/plugins/meta-box/)
[![License](https://img.shields.io/badge/License-GPLv2-green.svg)](http://www.gnu.org/licenses/gpl-2.0.html)

Plugin professionale per la gestione di immobili per agenzie immobiliari, imprese edili e costruttori su WordPress.

**Sito Ufficiale e Documentazione:**  
👉 [https://www.matteotestoni.it/servizi/programmatore-esperto-wordpress/plugin-immobiliare-wordpress/](https://www.matteotestoni.it/servizi/programmatore-esperto-wordpress/plugin-immobiliare-wordpress/)

---

## 🚀 Caratteristiche Principali

- **Gestione Immobili Dedicata:** Custom Post Type `immobili` con supporto per stanze, metrature, prezzi, planimetrie, capitolati allegati (PDF) e gallerie fotografiche.
- **Anteprima Foto in Bacheca:** Colonna dedicata con l'anteprima dell'immagine in evidenza come prima colonna nell'elenco immobili admin.
- **Tassonomie Avanzate:** Tipologia (gerarchica), Categoria (residenziale, commerciale), Località/Comuni, Contratti (vendita/affitto) e Tag.
- **Filtri di Ricerca:** Widget e shortcode con filtri per comune, prezzo, superficie, stanze e tipologia.
- **Integrazione Google Maps & OpenStreetMap:** Supporto per visualizzazione geolocalizzata moderna con supporto async/defer e fallback automatico OpenStreetMap.
- **Plugin Dependencies Nativo (WP 6.5+):** Gestione automatica e integrata della dipendenza con il plugin **Meta Box** senza script di terze parti o librerie TGMPA obsolete.
- **Compatibilità Totale:** Testato e ottimizzato per **WordPress 7.1** e **PHP 8.3**.

---

## 📋 Requisiti di Sistema

| Requisito | Versione Minima | Dettaglio |
| :--- | :--- | :--- |
| **WordPress** | **7.1+** | `Requires at least: 7.1` / `Tested up to: 7.1` |
| **PHP** | **8.3+** | Conforme alle strict rules e zero deprecation notice |
| **Dipendenze** | **Meta Box** | Gestito nativamente via `Requires Plugins: meta-box` |

---

## 📦 Installazione

### Metodo 1 (Da Bacheca WordPress)
1. Scarica il file `immobiliare.zip` dalle [Releases](https://github.com/svilupporswstudio/immobiliare/releases).
2. Vai su **Plugin > Aggiungi nuovo > Carica plugin**.
3. Seleziona l'archivio ZIP e clicca **Installa adesso**, quindi **Attiva plugin**.
4. WordPress 6.5+ rileverà automaticamente la dipendenza e ti permetterà di installare ed attivare **Meta Box** con un singolo click.

### Metodo 2 (Via Git / Clone)
```bash
cd wp-content/plugins/
git clone https://github.com/svilupporswstudio/immobiliare.git
```

---

## 🛠️ Novità della Versione 7.2.0

- 🖼️ **Colonna Immagine in Evidenza nell'Admin**: Aggiunta la colonna con miniatura dell'immobile come prima colonna visibile nell'elenco admin di WordPress (`manage_immobili_posts_columns`), con badge di fallback "No foto" e link rapido alla schermata di modifica.
- 🌍 **Internazionalizzazione 100% Conforme**: Tutte le stringhe di traduzione sono state uniformate con il text domain `'immobiliare'`, garantendo piena compatibilità con WordPress.org Polyglots e file `.po`/`.mo`.
- 🛡️ **Protezione Accesso Diretto ai File**: Aggiunta la clausola di sicurezza `defined( 'ABSPATH' ) || exit;` su tutti i file PHP del plugin e creati file sentinella `index.php` ("Silence is golden") nella radice e in ogni sottocartella (`css/`, `img/`, `lang/`).
- 🗺️ **Mappe Google di Ultima Generazione**: Aggiornate le opzioni JavaScript (`gestureHandling: 'cooperative'`, controlli moderni, altezza ottimizzata) e implementato caricamento asincrono (`async defer`) oltre a un fallback automatico OpenStreetMap nel frontend.

## 🛠️ Versioni Precedenti

### Novità della Versione 7.1.0
- ⚡ **Plugin Dependencies Nativo (WP 6.5+)**: Aggiunta la direttiva `Requires Plugins: meta-box`. Rimossa definitivamente la libreria TGMPA (`class-tgm-plugin-activation.php`) e i controlli manuali (-101 KB di codice legacy rimosso).
- 🔒 **Aggiornamento Requisiti**: Minimo WordPress 7.1 e PHP 8.3.
- 🎯 **Versione Stabile**: Allineata a WordPress 7.1 (`Tested up to: 7.1`, `Stable tag: 7.1`).
- 🌐 **URL Ufficiale**: Aggiornato su [https://www.matteotestoni.it/servizi/programmatore-esperto-wordpress/plugin-immobiliare-wordpress/](https://www.matteotestoni.it/servizi/programmatore-esperto-wordpress/plugin-immobiliare-wordpress/).
- 🧹 **Bonifica Completa Codice Deprecato**: Hook `current_screen`, rimossi markup `.icon32`, sintassi `get_terms()` moderna.

---

## 📄 Licenza

Rilasciato sotto licenza [GPLv2 o successiva](http://www.gnu.org/licenses/gpl-2.0.html).  
Copyright (c) Matteo Testoni - RSW Studio.
