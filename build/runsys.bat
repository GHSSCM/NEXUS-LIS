@echo off
setlocal

REM Get the current directory
set "current_dir=%cd%"

REM Define the relative paths to the PHP and MySQL directories
set "php_dir=%current_dir%\..\php"
set "mysql_dir=%current_dir%\..\mysql"



REM Define the custom MySQL data directory
set "mysql_data_dir=C:\lisdata"


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


REM Create the custom data directory if it does not exist
if not exist "%mysql_data_dir%" (
    mkdir "%mysql_data_dir%"
    if errorlevel 1 (
        echo Failed to create directory %mysql_data_dir%
        exit /b 1
    )
)


REM Add the PHP directory to the PATH
set "PATH=%php_dir%;%PATH%"

REM Start the MySQL server with the custom data directory
start "" "%mysql_dir%\bin\mysqld.exe" --datadir="%mysql_data_dir%"

REM Give MySQL a few seconds to start up
timeout /t 5 /nobreak > nul

REM Launch the PHP built-in server
php -S 0.0.0.0:80

REM End local settings
endlocal