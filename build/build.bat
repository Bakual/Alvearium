REM This will generate the zipfiles for Allrounder in /build/packages
REM This needs the zip binaries from Info-Zip installed. An installer can be found http://gnuwin32.sourceforge.net/packages/zip.htm
setlocal
SET PATH=%PATH%;C:\Program Files (x86)\GnuWin32\bin
rmdir /q /s packages
mkdir packages
REM Component
cd ../com_alvearium/
zip -r ../build/packages/com_alvearium.zip *
REM Module
cd ../mod_alvearium/
zip -r ../build/packages/mod_alvearium.zip *
REM Plugins
cd ../plg_content_alvearium/
zip -r ../build/packages/plg_content_alvearium.zip *
cd ../plg_editors_xtd_alvearium/
zip -r ../build/packages/plg_editors_xtd_alvearium.zip *
REM Package
cd ../build/packages/
copy ..\..\pkg_alvearium.xml
zip pkg_alvearium.zip *
del pkg_alvearium.xml
