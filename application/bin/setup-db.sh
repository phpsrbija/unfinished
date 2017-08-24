#!/usr/bin/env bash

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Create appropriate app config: /config/autoload/local.php - change it for local needs
────────────────────────────────────────────────────────────────────────────────────────────────────────"
APP_ROOT=$1
APP_DIR="application"

if [ "" == "${APP_ROOT}" ]; then
    APP_ROOT=$(pwd)
    APP_ROOT="${APP_ROOT/\/${APP_DIR}/}"
    APP_ROOT="${APP_ROOT/\/bin/}"
fi

APP_PATH="${APP_ROOT}/${APP_DIR}"

CONFIG_FILES_EXISTS="true"

if [ ! -f "${APP_PATH}/data/phinx/phinx.php" ]; then
    cp "${APP_PATH}/data/phinx/phinx.php.dist" "${APP_PATH}/data/phinx/phinx.php"
    CONFIG_FILES_EXISTS="false"
fi

if [ ! -f "${APP_PATH}/config/autoload/local.php" ]; then
    cp "${APP_PATH}/config/autoload/local.php.dist" "${APP_PATH}/config/autoload/local.php"
    CONFIG_FILES_EXISTS="false"
fi


echo "CF: ${CONFIG_FILES_EXISTS}"

if [ "false" == "${CONFIG_FILES_EXISTS}" ]; then


echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Write your database credentials into config files

   ${APP_PATH}/data/phinx/phinx.php
   ${APP_PATH}/config/autoload/local.php
────────────────────────────────────────────────────────────────────────────────────────────────────────

Press any key to continue..."
read -n 1

fi

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Create DB tables and populate it with fake data
────────────────────────────────────────────────────────────────────────────────────────────────────────"
(${APP_PATH}/vendor/bin/phinx migrate -c ${APP_PATH}/data/phinx/phinx.php)
(${APP_PATH}/vendor/bin/phinx seed:run -c ${APP_PATH}/data/phinx/phinx.php)
