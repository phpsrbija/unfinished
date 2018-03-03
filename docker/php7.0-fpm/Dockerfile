FROM phpdockerio/php7-fpm

RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections

# Install dependencies
RUN apt-get update \
    && \
    apt-get install -y -o Dpkg::Options::=--force-confdef \
    vim \
    php7.0-mysql \
    php7.0-xdebug \
    php7.0-mbstring \
    && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN sed -i 's/;daemonize = yes/daemonize = no/g' /etc/php/7.0/fpm/php-fpm.conf