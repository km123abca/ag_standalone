set /p hin=Enter file name:
setlocal ENABLEDELAYEDEXPANSION
set COUNT=0
echo off
for /f   %%v in ('dir /b /a-d /od "%hin%"') do (
  set /A COUNT=!COUNT! + 1
  ren %hin%\%%v fil!COUNT!.jpg
  
)

pause="complete"