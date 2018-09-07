setlocal ENABLEDELAYEDEXPANSION
set COUNT=0
echo off
set source=source
set /p num="Number of files:"

if "%~1" neq "" set source=%~1
for /f   %%v in ('dir /b /a-d /od "%source%"') do (
  set /A COUNT=!COUNT! + 1
  
  
)
set /A COUNT=!COUNT! -!num!+1 
set COUNTt=0
for /f   %%v in ('dir /b /a-d /od "source"') do (
  set /A COUNTt=!COUNTt! + 1
  if !COUNTt! geq !COUNT! (
  copy "source\%%v" "dest\")
  
)

pause="complete"