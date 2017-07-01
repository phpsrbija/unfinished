#!/usr/bin/env bash

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

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Create DB tables and populate it with fake data
────────────────────────────────────────────────────────────────────────────────────────────────────────"
vendor/bin/phinx migrate -c data/phinx/phinx.php
vendor/bin/phinx seed:run  -c data/phinx/phinx.php
