#!/usr/bin/env bash

echo "────────────────────────────────────────────────────────────────────────────────────────────────────────
 __________  ___ _____________    _________           ___     __                       __            _
 \______   \/   |   \______   \  /   _____/ __________\_ |__ |__|____    _______ __ __|  | ________ | |
  |     ___/    ~    \     ___/  \_____  \ / __ \_  __ \ __ \|  \__  \   \_  __ \  |  \  | \___   / | |
  |    |   \    Y    /    |      /        \  ___/|  | \/ \_\ \  |/ __ \_  |  | \/  |  /  |__/    /   \|
  |____|    \___|_  /|____|     /_______  /\___  |__|  |___  /__(____  /  |__|  |____/|____/_____ \  __
                  \/                    \/     \/          \/        \/                          \/  \/"
echo "────────────────────────────────────────────────────────────────────────────────────────────────────────"

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Start provisioning.. Adding new version of PHP and update...
────────────────────────────────────────────────────────────────────────────────────────────────────────"
sudo apt-get -y install python-software-properties >> /dev/null
sudo add-apt-repository ppa:ondrej/php >> /dev/null
sudo apt-get update

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Installing MySql 5.6
────────────────────────────────────────────────────────────────────────────────────────────────────────"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password password 12345"
sudo debconf-set-selections <<< "mysql-server mysql-server/root_password_again password 12345"

sudo apt-get install -y mysql-common mysql-server-5.6 mysql-client-5.6
mysql -u root -p12345  -e "CREATE DATABASE unfinished;"

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Install packages
────────────────────────────────────────────────────────────────────────────────────────────────────────"
sudo apt-get install -y nginx >> /dev/null
sudo apt-get -y install curl php7.0-zip php7.0-fpm php7.0-mcrypt php7.0-curl php7.0-cli php7.0-mysql php7.0-gd php7.0-intl php7.0-xsl php7.0-xdebug php7.0-mbstring

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Create apropriate config
────────────────────────────────────────────────────────────────────────────────────────────────────────"
if [ ! -f /var/www/unfinished/data/phinx/phinx.php ]; then
    cp /var/www/unfinished/data/phinx/phinx.php.dist /var/www/unfinished/data/phinx/phinx.php
fi

if [ ! -f /var/www/unfinished/config/autoload/local.php ]; then
    cp /var/www/unfinished/config/autoload/local.php.dist /var/www/unfinished/config/autoload/local.php
fi

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Phinx migrate
────────────────────────────────────────────────────────────────────────────────────────────────────────"
#cd /var/www/unfinished/data/phinx && /var/www/unfinished/vendor/bin/phinx migrate

###############################################################################
### During development log every query in /tmp/mysql.log .. thanks me later
###############################################################################
echo "

general_log = on
general_log_file=/tmp/mysql.log
" >> /etc/mysql/my.cnf

# mysql doesnt need to use that much ram for dev environment
sudo sed -i '/\[mysqld\]/a table_definition_cache=200' /etc/mysql/my.cnf

sudo service mysql restart

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Setup nginx Vhost and change config
────────────────────────────────────────────────────────────────────────────────────────────────────────"
sudo php -r '$f = file_get_contents("/etc/nginx/nginx.conf"); $new_f = str_replace("sendfile on;", "sendfile off; client_max_body_size 12M;", $f);  file_put_contents("/etc/nginx/nginx.conf", $new_f);'
sudo touch /etc/nginx/sites-available/unfinished.dev

sudo bash -c "echo 'server {
    listen 80;
    listen [::]:80;
    root /var/www/unfinished/public;
    index index.php index.html index.htm;
    server_name unfinished.dev;
    location / {
        root /var/www/unfinished/public;
        index  index.html index.htm index.php;
        try_files \$uri \$uri/ /index.php?\$args;
    }

    error_page 404 /404.html;
    error_page 500 502 503 504 /50x.html;
    location = /50x.html {
        root /usr/share/nginx/html;
    }

    location ~ \.php$ {
        try_files \$uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}' > /etc/nginx/sites-available/unfinished.dev"

sudo cp /etc/nginx/sites-available/unfinished.dev /etc/nginx/sites-enabled/
sudo service nginx restart
sudo service php7.0-fpm restart

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   change php.ini config
────────────────────────────────────────────────────────────────────────────────────────────────────────"
echo "
error_reporting = E_ALL
display_errors = On
log_errors = On
html_errors = On
error_log = /tmp/php_errors.log
" >> /etc/php/7.0/fpm/php.ini
sudo service nginx restart
sudo service php7.0-fpm restart

echo "
────────────────────────────────────────────────────────────────────────────────────────────────────────
   Almost done,
   In your /etc/hosts file add line
   192.168.33.3 unfinished.dev
────────────────────────────────────────────────────────────────────────────────────────────────────────"