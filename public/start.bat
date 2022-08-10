@echo off
if %1% == session_end (
    start chrome --full-screen --incognito --kiosk http:://photata.com
)
if %1% == session_start (
    taskkill /IM chrome.exe /F
)
exit
