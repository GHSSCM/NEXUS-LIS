@echo off
setlocal

echo ==============WELCOME TO THE LIS INSTALLATION ================
echo Please wait for the installation to complete....
REM Define the lis directory
set "lis_dir=C:\lis"

set "lis_dir_two=C:\lis\core"

set "lis_dir_three=C:\lis\components"


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
        echo Failed to create directory "%lis_dir_four%
        exit /b 1
    )
)

call lis_uz.bat ".\www.zip" "C:\lis\core" 

copy .\lis_st.bat "C:\lis\LIS.bat"  

echo Installation Completed Successfully....

pause
