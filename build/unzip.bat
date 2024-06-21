@echo off
setlocal

REM Check if a file path is provided
if "%~1"=="" (
    echo Usage: %0 ^<zipfile.zip^> [^<destination_folder^>]
    exit /b 1
)

REM Set the zip file path
set "zipfile=%~1"

REM Set the destination folder to current directory if not provided
if "%~2"=="" (
    set "destfolder=%cd%"
) else (
    set "destfolder=%~2"
)

REM Unzip the file
tar -xf "%zipfile%" -C "%destfolder%"

REM Check if the command succeeded
if %errorlevel% neq 0 (
    echo Unzipping failed!
    exit /b 1
)

echo Unzipping completed successfully.
exit /b 0
