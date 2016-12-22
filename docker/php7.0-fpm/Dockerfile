FROM phpdockerio/php7-fpm
#COPY ./www.conf /etc/php5/fpm/pool.d/www.conf

WORKDIR /var/www/unfinished

# Install dependencies
RUN apt-get update && \
    apt-get -y install curl \
    vim \
    php7.0-xdebug \
    php7.0-mysql \
    php7.0-mbstring && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN sed -i 's/;daemonize = yes/daemonize = no/g' /etc/php/7.0/fpm/php-fpm.conf

#CMD ["/usr/sbin/php7.0-fpm"]
