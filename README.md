# HealthBridge Nexus README -- LAST UPDATE: NOVEMBER 2025

## Table of Contents

- [System Overview](#system-overview)
- [Windows Installation](#windows-installation)
- [Linux / macOS Installation](#linux--macos-installation)
- [Building from Source (Developers)](#building-from-source-developers)
- [Accessing the Application](#accessing-the-application)
- [Troubleshooting](#troubleshooting)
- [License](#license)

---

## System Overview

| Component | Technology |
|-----------|-----------|
| Frontend | Nuxt 3 (statically generated) |
| Backend | Laravel 11 (PHP 8.2+) |
| Database | MySQL 8 |
| Application Server | PHP built-in server |
| Optional Web Servers | Apache or Nginx |

HealthBridge Nexus runs using PHP and MySQL. No separate web server is required for normal operation.

Administrators may optionally deploy the application behind Apache or Nginx and configure the web root to point to Laravel's `public/` directory.

---

## Windows Installation

### Requirements

- Windows 10 or Windows 11
- PHP 8.2+
- MySQL 8+

### Installation

1. Extract `build.zip`.
2. Extract `www.zip` into your preferred installation directory.
3. Create `.env` from `localenv`.
4. Configure database settings.
5. Create the database.
6. Run migrations:

```bash
php artisan migrate --force
```

7. Start the application:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

8. Open:

```text
http://localhost:8000
```

---

## Linux / macOS Installation

Install PHP 8.2+, MySQL 8+, and Composer.

Deploy:

```bash
mkdir -p /opt/healthbridge
unzip www.zip -d /opt/healthbridge
cd /opt/healthbridge
composer install --no-dev --optimize-autoloader
cp localenv .env
```

Run:

```bash
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS hb_db;"
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8000
```

Open:

```text
http://localhost:8000
```

---

## License

HealthBridge Nexus is released under the BSD 2-Clause / FreeBSD License.
