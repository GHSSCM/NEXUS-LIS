@echo off
setlocal


echo Initial testing...

REM Check if port 80 is in use
netstat -an | find ":80 " | find "LISTENING" >nul

REM Check the error level to determine if port 80 is in use
if %errorlevel% equ 0 (
    echo Port 80 is in use. Exiting with error.
    pause
    exit /b 1
) else (
    echo Port 80 is not in use. Continuing...
)

echo ==============WELCOME TO THE LIS INSTALLATION ================
echo Please wait for the installation to complete....
REM Define the lis directory
set "lis_dir=C:\HealthBridge"

set "lis_dir_two=C:\HealthBridge\core"

set "lis_dir_three=C:\HealthBridge\components"


set "lis_dir_four=C:\xampp"


REM Create the custom data directory if it does not exist
if not exist "%lis_dir%" (
    mkdir "%lis_dir%"
    if errorlevel 1 (
        echo Failed to create directory "%lis_dir%
        exit /b 1
    )
)



if not exist "%lis_dir_two%" (
    mkdir "%lis_dir_two%"
    if errorlevel 1 (
        echo Failed to create directory "%lis_dir_two%
        exit /b 1
    )
)




if not exist "%lis_dir_three%" (
    mkdir "%lis_dir_three%"
    if errorlevel 1 (
        echo Failed to create directory "%lis_dir_three%
        exit /b 1
    )
)




if not exist "%lis_dir_four%" (
    mkdir "%lis_dir_four%"
    call lis_uz.bat ".\components.zip" "C:\xampp" 
    if errorlevel 1 (
        echo Failed to create directory "%lis_dir_four%"
        exit /b 1
    )
) else (
    @REM Update the ini
    @REM rd /s /q "%lis_dir_four%"
    @REM call lis_uz.bat ".\components.zip" "C:\xampp" 
    copy .\php.ini "C:\xampp\php\php.ini" 
)

call lis_uz.bat ".\www.zip" "C:\HealthBridge\core" 

copy .\lis_st.bat "C:\HealthBridge\HealthBridge.bat"  

echo Installation Completed Successfully....

pause
