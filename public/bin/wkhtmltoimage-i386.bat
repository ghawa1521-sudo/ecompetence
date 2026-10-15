@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/h4cc/wkhtmltoimage-i386/bin/wkhtmltoimage-i386
php "%BIN_TARGET%" %*
