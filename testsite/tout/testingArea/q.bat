:renameNoSpace  [/R]  [FolderPath]
 @echo off
setlocal disableDelayedExpansion
if /i "%~1"=="/R" (
  set "forOption=%~1 %2"
  
  set "inPath="
) else (
  set "forOption="
  if "%~1" neq "" (set "inPath=%~1\") else set "inPath="
)
echo "%inPath%* *"
pause="hello"
for %forOption% %%F in ("%inPath%* *") do (
  if /i "%~f0" neq "%%~fF" (
    set "folder=%%~dpF"
    set "file=%%~nxF"
    setlocal enableDelayedExpansion
     echo "!file!"
    pause="hello"
    echo ren "!folder!!file!" "!file: =!"
    rem ren "!folder!!file!" "!file: =!"
    endlocal
  )
)




