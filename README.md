HealthBridge Nexus

HealthBridge Nexus is an offline-first Health Information System (HIS) for facility-level operations — patient registration, laboratory, billing, pharmacy, and blood bank — built on a Nuxt 3 frontend with a Laravel 11 backend and MySQL database.

⸻

Table of Contents

* System Overview
* Windows Installation
* Linux / macOS Installation
* Building from Source (Developers)
* Accessing the Application
* Troubleshooting
* License

⸻

System Overview

Component	Technology
Frontend	Nuxt 3 (statically generated)
Backend	Laravel 11 (PHP 8.2+)
Database	MySQL 8
Application Server	PHP built-in server
Optional Web Servers	Apache or Nginx

HealthBridge Nexus runs using PHP’s built-in web server and MySQL. No separate web server is required. Advanced deployments may place the application behind Apache or Nginx if desired.

⸻

Windows Installation

Requirements

* Windows 10 or Windows 11
* PHP 8.2+
* MySQL 8+
* Administrator rights (recommended)

Installation

1. Extract build.zip to a temporary directory.
2. Extract www.zip from the archive into the desired installation directory, for example:

C:\HealthBridge

3. Open Command Prompt and navigate to the application directory:

cd C:\HealthBridge

4. Copy the environment file:

copy localenv .env

5. Edit .env and configure the database connection:

APP_URL=http://localhost:8000
DB_HOST=127.0.0.1
DB_DATABASE=hb_db
DB_USERNAME=root
DB_PASSWORD=

6. Create the database:

mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS hb_db;"

7. Run database migrations:

php artisan migrate --force

8. Start the application:

php artisan serve --host=0.0.0.0 --port=8000

9. Open:

http://localhost:8000

⸻

Linux / macOS Installation

Install Dependencies

* PHP 8.2+
* MySQL 8+
* Composer

Deploy the Application

Extract www.zip into your deployment directory:

mkdir -p /opt/healthbridge
unzip www.zip -d /opt/healthbridge
cd /opt/healthbridge

Install PHP dependencies:

composer install --no-dev --optimize-autoloader

Create the environment file:

cp localenv .env

Update the database settings:

APP_URL=http://localhost:8000
DB_HOST=127.0.0.1
DB_DATABASE=hb_db
DB_USERNAME=root
DB_PASSWORD=

Create the database and run migrations:

mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS hb_db;"
php artisan migrate --force

Set permissions:

chmod -R 775 storage bootstrap/cache

Start the Server

php artisan serve --host=0.0.0.0 --port=8000

Open:

http://localhost:8000

Optional Apache / Nginx Deployment

HealthBridge Nexus does not require Apache or Nginx. However, administrators may deploy the application behind Apache or Nginx for production environments if desired. In such cases, configure the web server to serve the Laravel public/ directory.

⸻

Building from Source (Developers)

Prerequisites

Tool	Version
Node.js	18+
npm	9+
PHP	8.2+
Composer	2+
MySQL	8+

Install dependencies:

npm install
cd lis-backend && composer install && cd ..

Build the application:

./build.sh

Output:

build/www.zip
build/build.zip

⸻

Accessing the Application

Scenario	URL
Local machine	http://localhost:8000
LAN access	http://:8000

To determine the local IP address:

Windows:

ipconfig

Linux:

hostname -I

macOS:

ifconfig

⸻

Troubleshooting

Port Already In Use

Choose another port:

php artisan serve --port=8080

Then access:

http://localhost:8080

Database Connection Errors

Verify the database settings in .env and ensure MySQL is running.

Migration Errors

Run:

php artisan migrate --force

after correcting database credentials.

Blank Page or 500 Error

Check:

storage/logs/laravel.log

and ensure write permissions exist for:

storage/
bootstrap/cache/

LAN Devices Cannot Connect

Ensure the firewall allows incoming connections on the chosen port (8000 by default).

⸻

License

HealthBridge Nexus is released under the BSD 2-Clause / FreeBSD License.
