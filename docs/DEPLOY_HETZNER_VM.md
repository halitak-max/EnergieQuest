# Hetzner Cloud VM Deployment (Nginx + PHP-FPM)

Plain-VM Deployment-Anleitung für `EnergieQuest` auf einer Hetzner Cloud VM mit Ubuntu 22.04, Nginx und PHP-FPM – ohne Docker oder CI/CD.

## Voraussetzungen
- Hetzner Cloud VM (z. B. CX/CPX, Ubuntu 22.04) mit sudo-Zugang.
- DNS: A/AAAA-Record auf die VM für `example.com` / `www.example.com`.
- Secrets: DB-Name/User/Pass/Host, `APP_KEY`, Mail-Settings, optional Redis.
- Pakete: `curl`, `git`, `unzip`, `ufw`, `fail2ban` empfohlen.

## Server-Grundsetup
```bash
sudo apt update && sudo apt upgrade -y
sudo timedatectl set-timezone Europe/Berlin
sudo apt install -y nginx redis-server certbot python3-certbot-nginx \
  php8.2 php8.2-fpm php8.2-{bcmath,cli,common,curl,gd,intl,mbstring,mysql,pgsql,redis,xml,zip} \
  composer git unzip
# Optional: Node für Asset-Builds
sudo apt install -y nodejs npm

# App-User anlegen (optional)
sudo adduser --system --ingroup www-data --home /var/www/energiequest energiequest
```

## Code aus GitHub holen
```bash
sudo mkdir -p /var/www && sudo chown energiequest:www-data /var/www
sudo -u energiequest git clone https://github.com/halitak-max/EnergieQuest.git /var/www/energiequest
cd /var/www/energiequest
cp .env.example .env
# .env anpassen: APP_NAME, APP_ENV=production, APP_URL=https://example.com,
# DB_* (Host/User/Pass/Name), QUEUE_CONNECTION=database|redis, CACHE_STORE, MAIL_*, LOG_CHANNEL=stack

sudo -u energiequest composer install --no-dev --prefer-dist --optimize-autoloader
sudo -u energiequest php artisan key:generate
sudo -u energiequest php artisan storage:link
sudo -u energiequest php artisan config:cache route:cache view:cache

# Falls Assets auf der VM gebaut werden
sudo -u energiequest npm ci
sudo -u energiequest npm run build
```

## Nginx vHost (Beispiel)
Datei `/etc/nginx/sites-available/energiequest.conf`:
```
server {
    listen 80;
    server_name example.com www.example.com;
    root /var/www/energiequest/public;

    index index.php;
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~* \.(jpg|jpeg|png|gif|css|js|ico|webp|svg)$ {
        expires 7d;
        access_log off;
    }
}
```
```bash
sudo ln -s /etc/nginx/sites-available/energiequest.conf /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

## PHP-FPM Pool (optional, eigener User)
Datei `/etc/php/8.2/fpm/pool.d/energiequest.conf`:
```
[energiequest]
user = energiequest
group = www-data
listen = /run/php/php8.2-fpm-energiequest.sock
pm = dynamic
pm.max_children = 8
pm.start_servers = 2
pm.min_spare_servers = 2
pm.max_spare_servers = 4
php_admin_value[error_log] = /var/log/php8.2-fpm-energiequest.log
```
Nginx dann mit `fastcgi_pass unix:/run/php/php8.2-fpm-energiequest.sock;` konfigurieren.

## SSL aktivieren
```bash
sudo certbot --nginx -d example.com -d www.example.com --redirect
sudo systemctl reload nginx
```

## Datenbank & Migrationen
```bash
# DB-User/DB anlegen (MariaDB/PostgreSQL je nach Wahl)
sudo -u energiequest php artisan migrate --force
# Optional Seeds
sudo -u energiequest php artisan db:seed --force
```

## Hintergrundjobs & Scheduler
Systemd Service `/etc/systemd/system/laravel-queue.service`:
```
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=energiequest
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/energiequest/artisan queue:work --sleep=3 --tries=3 --max-time=3600

[Install]
WantedBy=multi-user.target
```
```bash
sudo systemctl daemon-reload
sudo systemctl enable --now laravel-queue.service
```

Cron für Scheduler (`crontab -u energiequest -e`):
```
* * * * * /usr/bin/php /var/www/energiequest/artisan schedule:run >> /var/log/laravel-schedule.log 2>&1
```

## Updates / Redeploy
```bash
cd /var/www/energiequest
sudo -u energiequest git pull origin main
sudo -u energiequest composer install --no-dev --prefer-dist --optimize-autoloader
sudo -u energiequest npm ci && sudo -u energiequest npm run build   # falls Assets hier gebaut werden
sudo -u energiequest php artisan migrate --force
sudo -u energiequest php artisan optimize
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx
```

## Backups & Monitoring
- DB-Dumps per Cron (z. B. `mysqldump --single-transaction > /backups/$(date +%F).sql.gz`).
- Hetzner Volume/Snapshot für Files, `.env` und Keys separat sichern.
- Fail2ban/ufw aktivieren, PHP-FPM slow log prüfen, externes Uptime-Monitoring (z. B. UptimeRobot) auf `/health`-Route.

## CI/CD (GitHub Actions → Hetzner VM)
Workflow: `.github/workflows/deploy.yml`

### Secrets (GitHub Repository)
- `SSH_HOST` – VM IP/Hostname
- `SSH_USER` – z. B. `root` oder `energiequest`
- `SSH_KEY` – Private SSH Key (passt zu authorized_keys auf der VM)
- `APP_PATH` – z. B. `/var/www/energiequest`
- `PHP_FPM_SERVICE` – z. B. `php8.2-fpm` (leer lassen, falls nicht reloaden)

### Ablauf
1) Build auf Runner: `composer install --no-dev`, `npm ci`, `npm run build`
2) Rsync auf die VM nach `${APP_PATH}` (ohne `.env`, ohne Storage-Userdaten)
3) Remote: `php artisan migrate --force`, `php artisan optimize`, `queue:restart`, reload PHP-FPM/Nginx

### VM-Anforderungen
- PHP 8.2 + Composer + Node optional (nicht zwingend für Deploy, da Build auf Runner)
- `.env` muss bereits auf der VM liegen (nicht Teil des Deployments)
- Rechte: `${SSH_USER}` muss Schreibrechte auf `${APP_PATH}` haben; sudo für `systemctl reload` falls genutzt.

### Trigger
- Push auf `main`
- Manuell via „Run workflow“

