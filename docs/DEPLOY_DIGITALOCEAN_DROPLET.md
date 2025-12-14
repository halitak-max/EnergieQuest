# Deployment auf DigitalOcean Droplet (Nginx + PHP-FPM)

Plain-VM Deployment der Laravel-Anwendung auf einem DigitalOcean Droplet (Ubuntu 22.04), Nginx, PHP-FPM. Assets werden im GitHub Actions Workflow gebaut, anschließend per rsync übertragen.

## Voraussetzungen
- Droplet (Ubuntu 22.04) mit sudo-Zugang.
- DNS A/AAAA auf die Droplet-IP (z. B. `app.example.com`).
- SSH-Key des Deploy-Users liegt in `~/.ssh/authorized_keys`.
- Secrets: DB-Name/User/Pass/Host, `APP_KEY`, Mail, optional Redis.

## Server Setup (einmalig)
```bash
sudo apt update && sudo apt upgrade -y
sudo timedatectl set-timezone Europe/Berlin
sudo apt install -y nginx redis-server certbot python3-certbot-nginx \
  php8.2 php8.2-fpm php8.2-{bcmath,cli,common,curl,gd,intl,mbstring,mysql,pgsql,redis,xml,zip} \
  composer git unzip
# Optional: Node nur wenn Builds auf dem Server laufen sollen
sudo apt install -y nodejs npm
```

Deploy-User anlegen und Pfade vorbereiten:
```bash
sudo adduser --disabled-password --gecos "" deploy
sudo mkdir -p /home/deploy/.ssh && sudo chmod 700 /home/deploy/.ssh
sudo sh -c 'echo "ssh-ed25519 AAAA...PUBLICKEY" >> /home/deploy/.ssh/authorized_keys'
sudo chmod 600 /home/deploy/.ssh/authorized_keys
sudo chown -R deploy:deploy /home/deploy/.ssh

sudo mkdir -p /var/www/energiequest
sudo chown -R deploy:www-data /var/www/energiequest
```

Optional sudo ohne Passwort nur fürs Reload:
```bash
echo "deploy ALL=NOPASSWD:/bin/systemctl reload nginx,/bin/systemctl reload php8.2-fpm" | sudo tee /etc/sudoers.d/deploy
sudo chmod 440 /etc/sudoers.d/deploy
```

## Erster Deploy (manuell)
```bash
sudo -u deploy git clone https://github.com/halitak-max/EnergieQuest.git /var/www/energiequest
cd /var/www/energiequest
cp .env.example .env
# .env anpassen: APP_ENV=production, APP_URL, DB_*, QUEUE_CONNECTION, CACHE_STORE, MAIL_*, LOG_CHANNEL

sudo -u deploy composer install --no-dev --prefer-dist --optimize-autoloader
sudo -u deploy php artisan key:generate
sudo -u deploy php artisan storage:link
sudo -u deploy php artisan config:cache route:cache view:cache

# (Falls Builds auf dem Server laufen sollen)
sudo -u deploy npm ci
sudo -u deploy npm run build
```

## Nginx vHost (Beispiel)
`/etc/nginx/sites-available/energiequest.conf`
```
server {
    listen 80;
    server_name app.example.com;
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

## SSL
```bash
sudo certbot --nginx -d app.example.com --redirect
sudo systemctl reload nginx
```

## Datenbank & Migrationen
```bash
sudo -u deploy php artisan migrate --force
# Optional Seeds
sudo -u deploy php artisan db:seed --force
```

## Hintergrundjobs & Scheduler
Systemd Queue-Worker `/etc/systemd/system/laravel-queue.service`:
```
[Unit]
Description=Laravel Queue Worker
After=network.target

[Service]
User=deploy
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

Cron für Scheduler:
```
* * * * * /usr/bin/php /var/www/energiequest/artisan schedule:run >> /var/log/laravel-schedule.log 2>&1
```

## CI/CD mit GitHub Actions
Workflow: `.github/workflows/deploy.yml`

Build läuft auf dem Runner, danach rsync auf das Droplet. Laravel-Migrationen/Optimize laufen remote, anschließend Reload von PHP-FPM/Nginx.

### Secrets (Repository)
- `SSH_HOST` – Droplet IP/Hostname
- `SSH_PORT` – optional, Standard 22
- `SSH_USER` – z. B. `deploy`
- `SSH_KEY` – Private Key passend zu `authorized_keys`
- `APP_PATH` – z. B. `/var/www/energiequest`
- `PHP_FPM_SERVICE` – z. B. `php8.2-fpm` (leer lassen, wenn nicht reloadet)

### Trigger
- Push auf `main`
- Manuelles `workflow_dispatch`

## Updates / Redeploy (manuell)
```bash
cd /var/www/energiequest
sudo -u deploy git pull origin main
sudo -u deploy composer install --no-dev --prefer-dist --optimize-autoloader
sudo -u deploy npm ci && sudo -u deploy npm run build   # falls Builds auf dem Server
sudo -u deploy php artisan migrate --force
sudo -u deploy php artisan optimize
sudo systemctl reload php8.2-fpm
sudo systemctl reload nginx
```

