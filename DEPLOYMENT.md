# Deployment-Guide für energiequest.de (Hetzner Webhosting)

Diese Anleitung führt dich durch den Prozess, deine Laravel-Anwendung auf deinem Hetzner Webhosting live zu schalten (ohne SFTP-Treiber, Standard-Hosting).

## Voraussetzungen

1.  **FTP/SFTP Zugang** (für den Datei-Upload)
2.  **Datenbank-Zugangsdaten** (bereits in `.env.production` eingetragen).
3.  **SSH Zugang** (Optional, aber empfohlen).

---

## Schritt 1: Build Prozess Lokal

1.  **Produktions-Abhängigkeiten installieren:**
    Falls du `vendor` hochladen musst (kein SSH/Composer auf Server), führe dies lokal aus:
    ```bash
    composer install --optimize-autoloader --no-dev
    ```

2.  **Frontend Assets bauen:**
    ```bash
    npm run build
    ```

---

## Schritt 2: Ordnerstruktur & Upload

**WICHTIG:** Hetzner erlaubt oft nicht, Ordner außerhalb von `public_html` zu nutzen (Sandbox). Deshalb laden wir den `energiequest` Ordner **IN** `public_html` hoch und schützen ihn per `.htaccess`.

1.  **Ordner erstellen:**
    Erstelle **innerhalb** von `public_html` einen Ordner namens `energiequest`.
    
    Struktur auf dem Server:
    ```
    /public_html/
    ├── index.php       (Aus deinem lokalen 'public' Ordner)
    ├── .htaccess       (Aus deinem lokalen 'public' Ordner)
    ├── assets/         (Aus deinem lokalen 'public' Ordner)
    ├── build/          (Aus deinem lokalen 'public' Ordner)
    └── energiequest/   (Hier kommt der gesamte Rest deines Projekts rein)
          ├── app/
          ├── bootstrap/
          ├── config/
          ├── vendor/
          ├── .env      (Wichtig!)
          └── ...
    ```

2.  **Dateien hochladen:**
    *   Lade den **gesamten Inhalt** deines lokalen Projektordners in den neuen Ordner `public_html/energiequest` – **AUSSER** den Ordner `public`!
    *   Lade den **Inhalt** des lokalen Ordners `public` direkt in den Hauptordner `public_html`.

---

## Schritt 3: `index.php` anpassen

Damit Laravel weiß, wo der Code liegt, müssen wir die `index.php` im Hauptverzeichnis anpassen.

Öffne `public_html/index.php` auf dem Server und ändere die Pfade (wir entfernen `../`, da der Ordner jetzt im gleichen Verzeichnis liegt):

```php
// Alt:
// require __DIR__.'/../vendor/autoload.php';
// $app = require_once __DIR__.'/../bootstrap/app.php';

// Neu (Code liegt in ./energiequest):
require __DIR__.'/energiequest/vendor/autoload.php';
$app = require_once __DIR__.'/energiequest/bootstrap/app.php';
```

---

## Schritt 4: Konfiguration (.env)

1.  Lade deine lokale `.env.production` Datei in den Ordner `public_html/energiequest` auf dem Server hoch und benenne sie in `.env` um.
2.  Stelle sicher, dass `APP_URL=https://energiequest.de` gesetzt ist.

---

## Schritt 5: Storage Linking (Wichtig für Uploads!)

Damit hochgeladene Dateien öffentlich erreichbar sind, muss ein Symlink erstellt werden.

**Option A: Per SSH (Empfohlen)**
1.  Verbinde dich per SSH.
2.  Gehe in den Ordner `public_html`.
3.  Führe den Befehl aus:
    ```bash
    ln -sr energiequest/storage/app/public storage
    ```

**Option B: PHP-Skript (Falls kein SSH)**
1.  Erstelle eine Datei `link.php` in `public_html` mit diesem Inhalt:
    ```php
    <?php
    // Passe den Pfad an deinen Server an!
    // Oft: /usr/www/users/DEIN_USER/public_html/energiequest/storage/app/public
    $target = __DIR__ . '/energiequest/storage/app/public'; 
    $link = __DIR__ . '/storage';
    symlink($target, $link);
    echo "Link erstellt von $target nach $link";
    ```
2.  Rufe `energiequest.de/link.php` im Browser auf.
3.  Lösche die Datei danach.

---

## Schritt 6: Sicherheit (WICHTIG!)

Da der `energiequest` Ordner nun im öffentlichen Verzeichnis liegt, müssen wir ihn schützen.
Erstelle im Ordner `public_html/energiequest` eine Datei namens `.htaccess` mit folgendem Inhalt:

```apache
Deny from all
```
Dies verhindert, dass jemand deine Systemdateien herunterladen kann.

---

## Schritt 7: Datenbank Migration

Führe die Migrationen auf dem Server aus (per SSH im `public_html/energiequest` Ordner):

```bash
php artisan migrate --force
```
