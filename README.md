# EnergieQuest

Laravel-Anwendung für Energie-Quest. Dieses Repository enthält das Backend (PHP 8.2) und das Frontend-Build (Vite/Tailwind).

## Voraussetzungen
- PHP 8.2, Composer
- Node 18+ und npm (für Asset-Builds)
- MySQL/MariaDB oder PostgreSQL, Redis optional

## Lokale Entwicklung
```bash
cp .env.example .env
composer install
npm install
php artisan key:generate
npm run dev   # oder: npm run build
php artisan serve
```

## Tests
```bash
php artisan test
```

## Deployment auf Hetzner Cloud (Plain VM)
- Deployment-Workflow: Nginx + PHP-FPM auf einer Hetzner Cloud VM, ohne Docker/CI.
- Anleitung: siehe `docs/DEPLOY_HETZNER_VM.md`.
- CI/CD: GitHub Actions Workflow in `.github/workflows/deploy.yml` deployt nach Hetzner (Rsync + SSH, Laravel Migrate/Optimize).

## Deployment auf DigitalOcean Droplet
- Anleitung: `docs/DEPLOY_DIGITALOCEAN_DROPLET.md` (Nginx + PHP-FPM).
- CI/CD: `.github/workflows/deploy.yml` (Build auf Runner, rsync auf Droplet, `migrate/optimize`, Service-Reload).
