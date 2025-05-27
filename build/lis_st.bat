@echo off
setlocal

REM Get the current directory
set "current_dir=%cd%"

REM Define the relative paths to the PHP and MySQL directories
set "php_dir=C:\xampp\php"
set "mysql_dir=C:\xampp\mysql"



REM Check if the PHP executable exists
if not exist "%php_dir%\php.exe" (
    echo PHP executable not found in %php_dir%
    exit /b 1
)

REM Check if the MySQL executable exists
if not exist "%mysql_dir%\bin\mysqld.exe" (
    echo MySQL executable not found in %mysql_dir%\bin
    exit /b 1
)


REM Add the PHP directory to the PATH
set "PATH=%php_dir%;%PATH%"

REM Start the MySQL server with the custom data directory --datadir="%mysql_data_dir%"
start "" "%mysql_dir%\bin\mysqld.exe" 

REM Give MySQL a few seconds to start up

echo Starting, please wait...

timeout /t 10 /nobreak > nul


REM MySQL credentials
set "mysql_user=root"
@REM set "mysql_password=yourpassword"
set "mysql_host=localhost"
set "mysql_port=3306"

REM Database name
set "database_name=ghsscm_lis"

REM Command to create the database
set "create_db_cmd=CREATE DATABASE IF NOT EXISTS %database_name%;"

REM Execute the MySQL command to create the database
echo %create_db_cmd% | C:\xampp\mysql\bin\mysql -u%mysql_user% -h%mysql_host% -P%mysql_port%


echo ================================================
echo USE THE FOLLOWING LINKS ON ANY BROWSER:

setlocal enabledelayedexpansion

REM Get the IP addresses
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "IPv4"') do (
    set "ip=%%a"
    set "ip=!ip:~1!"
    echo http://!ip!
)

endlocal


echo =================================================

REM Launch the PHP built-in server

cd core

copy  localenv  .env

REM set "env_raw=%current_dir%\core\localenv"
REM set "env_true=%current_dir%\core\.env"



php artisan migrate --force

php -S 0.0.0.0:80 router.php

REM End local settings

endlocal