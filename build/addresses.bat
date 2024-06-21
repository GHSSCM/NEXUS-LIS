@echo off
setlocal enabledelayedexpansion

REM Get the IP addresses
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /i "IPv4"') do (
    set "ip=%%a"
    set "ip=!ip:~1!"
    echo http://!ip!
)

endlocal
pause
