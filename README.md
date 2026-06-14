# WatchIT 🎬

**WatchIT** è una web application premium orientata allo streaming e al tracciamento di Film e Serie TV, progettata per offrire un'esperienza utente moderna e coinvolgente.
La piattaforma integra un catalogo dinamico che consente agli utenti di recensire contenuti, gestire le proprie watchlist personalizzate (pubbliche o private) e tenere traccia delle visualizzazioni.

La gestione amministrativa è completamente integrata tramite un pannello di controllo premium che consente l'importazione automatica di metadati tramite API di TMDB, l'inserimento manuale e la moderazione degli utenti (compreso un sistema di ban automatico a tempo).

---

## 🚀 Caratteristiche Principali

- **Design Premium con Glassmorphism**: Interfaccia futuristica scura con sfocature in tempo reale (`backdrop-blur`), bordi luminosi ed effetti di transizione fluidi alimentati da Tailwind CSS.
- **Gestione Contenuti Asincrona (AJAX)**: Operazioni di creazione, modifica ed importazione gestite tramite overlay in sovrimpressione con precompilazione dinamica dei dati, per evitare reindirizzamenti continui e garantire fluidità di utilizzo.
- **Integrazione TMDB API**: Ricerca e importazione automatica di Film e Serie TV direttamente dal database globale TMDB, importando sinossi, generi, trailer YouTube, cast principale ed episodi (divisi per stagioni).
- **Calcolo Intelligente delle Valutazioni**: Il sistema calcola la valutazione media ponderata di ogni contenuto unendo la valutazione di partenza di TMDB (o inserita dall'amministratore) con i voti effettivi delle recensioni rilasciate dagli utenti, impedendo che una singola recensione annulli il voto storico.
- **Watchlist Dinamiche**: Creazione di watchlist personalizzate con copertine adattive progressive generate automaticamente dall'unione delle copertine dei contenuti salvati.
- **Sistema di Moderazione Premium**: Gestione del ban temporaneo automatizzato. Un cronjob/sistema di controllo rileva la scadenza del ban e riabilita automaticamente l'utente all'accesso in modo asincrono.

---

## 🛠️ Architettura Tecnologica

- **Backend**: PHP 8.x con architettura MVC (Model-View-Controller).
- **Database & ORM**: MySQL / MariaDB gestito tramite **Doctrine ORM** per la persistenza ad oggetti e le relazioni complesse (Many-to-Many Join Tables).
- **Frontend**: Template Engine **Smarty** per la compilazione dei template lato server, abbinato a **Tailwind CSS** per lo styling e JavaScript ES6 asincrono (Fetch API) per la gestione del DOM.

---

## 📋 Requisiti di Sistema

Prima di procedere all'installazione, assicurati di avere installato sul tuo computer:

1. **XAMPP** (o un server locale equivalente con PHP >= 8.1 e MySQL).
2. **Composer** (il gestore delle dipendenze di PHP).
3. Una connessione internet attiva (necessaria per l'importazione da TMDB).

---

## ⚙️ Istruzioni di Installazione (Locale - XAMPP)

Segui questi passaggi per configurare ed eseguire il progetto sul tuo computer locale:

### 1. Clonazione del Progetto

Copia o scarica la cartella del progetto all'interno della directory `htdocs` della tua installazione di XAMPP:

- Su Windows: `C:\xampp\htdocs\WatchIT`
- Su macOS: `/Applications/XAMPP/htdocs/WatchIT`

### 2. Installazione delle Dipendenze PHP

Apri il terminale (o Prompt dei comandi) nella cartella del progetto (`C:\xampp\htdocs\WatchIT`) ed esegui il comando:

```bash
composer install
```

Questo scaricherà ed installerà tutte le librerie necessarie (Doctrine ORM, Smarty, ecc.).

### 3. Creazione del Database

1. Avvia i moduli **Apache** e **MySQL** dal pannello di controllo di XAMPP.
2. Apri il tuo browser all'indirizzo [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Crea un nuovo database vuoto denominato **`watchit`** con codifica `utf8mb4_general_ci` o `utf8mb4_unicode_ci`.

### 4. Generazione dello Schema e delle Tabelle

La struttura delle tabelle viene generata in modo automatico da Doctrine leggendo le classi del modello (Entity).
Sempre nella cartella del progetto da terminale, esegui il comando:

```bash
php bin/doctrine.php orm:schema-tool:create
```

*(Nota: se hai già una struttura e desideri resettarla ed aggiornarla, puoi lanciare `php bin/doctrine.php orm:schema-tool:drop --force` seguito dal comando di create sopra indicato).*

### 5. Popolamento dei Dati Iniziali (Seeder)

Per popolare il database con dati di test (utenti amministratori, utenti standard, film, serie TV, episodi e recensioni preimpostate), esegui:

```bash
php bin/seeder.php
```

### 6. Avvio dell'Applicazione

Ora puoi accedere alla piattaforma aprendo il browser sul link:
👉 **[http://localhost/WatchIT](http://localhost/WatchIT)**

---

## ☁️ Configurazione in Produzione (Altervista)

Il progetto è pre-configurato per riconoscere in modo dinamico se l'applicazione sta girando su server Altervista.
Nel file `foundation/bootstrap.php` è presente la logica di rilevamento dell'host:

```php
$hostName = $_SERVER['HTTP_HOST'] ?? 'localhost';
$isAltervista = (strpos($hostName, 'altervista.org') !== false);
```

Se la piattaforma rileva di trovarsi su Altervista, configurerà automaticamente i parametri del database associando come nome del DB `my_nomeutente` e come utente `nomeutente` con password vuota, rendendo il deploy in produzione istantaneo e senza modifiche manuali al codice.

---

## 📁 Struttura del Progetto

```text
WatchIT/
├── bin/                  # Script CLI (doctrine.php, seeder.php)
├── controller/           # I Controller del pattern MVC (CAdmin, CContenuto, CUtente...)
├── foundation/           # Layer di persistenza (bootstrap, FEntityManager, classi Foundation...)
├── model/                # Classi Entity del modello (EContenuto, EFilm, ESerie, EUtente...)
├── view/                 # Viste PHP (VAdmin, VView...)
│   ├── js/               # Script JS (cerca.js, modali...)
│   └── templates/        # Template Smarty suddivisi in cartelle (admin, components...)
├── index.php             # Front Controller dell'applicazione
└── composer.json         # Configurazione delle dipendenze Composer
```
