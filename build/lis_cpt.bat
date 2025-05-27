@echo off

REM Define the path to the batch file
set "target=C:\HealthBridge\HealthBridge.bat"

REM Get the desktop path for the current user
set "desktop=%USERPROFILE%\Desktop"

REM Define the shortcut path
set "shortcut=%desktop%\HealthBridge.lnk"

REM Use PowerShell to create the shortcut
powershell -command ^
    "$ws = New-Object -ComObject WScript.Shell; ^
    $s = $ws.CreateShortcut('%shortcut%'); ^
    $s.TargetPath = '%target%'; ^
    $s.Save()"

echo Shortcut created on the desktop.

