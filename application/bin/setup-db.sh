#!/usr/bin/env bash
MODE=$1;
if [ "$MODE" != "docker" ]; then
MODE="vagrant"
fi

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Create appropriate app config: /config/autoload/local.php - change it for local needs
────────────────────────────────────────────────────────────────────────────────────────────────────────"
if [ ! -f /var/www/unfinished/data/phinx/phinx.php ]; then
    cp /var/www/unfinished/data/phinx/phinx.php.dist /var/www/unfinished/data/phinx/phinx.php
fi

if [ ! -f /var/www/unfinished/config/autoload/local.php ]; then
    cp /var/www/unfinished/config/autoload/local.php.dist /var/www/unfinished/config/autoload/local.php
fi
if [ "$MODE" = "docker" ]; then
sed -i -e 's/localhost/mysql/g' /var/www/unfinished/data/phinx/phinx.php
sed -i -e 's/root/unfinished/g' /var/www/unfinished/data/phinx/phinx.php

sed -i -e 's/host=localhost/host=mysql/g' /var/www/unfinished/config/autoload/local.php
sed -i -e "s/'username' => 'root'/'username' => 'unfinished'/g" /var/www/unfinished/config/autoload/local.php
fi

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Create DB tables and populate it with fake data
────────────────────────────────────────────────────────────────────────────────────────────────────────"
vendor/bin/phinx migrate -c data/phinx/phinx.php
vendor/bin/phinx seed:run  -c data/phinx/phinx.php
