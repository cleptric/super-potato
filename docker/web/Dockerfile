FROM ubuntu:22.04

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update

RUN apt-get install -y \
    apache2 \
    curl \
    supervisor \
    software-properties-common

RUN apt-get install -y \
    php8.1 \
    php8.1-curl \
    php8.1-fpm \
    php8.1-intl \
    php8.1-mbstring \
    php8.1-mysql \
    php8.1-sqlite3 \
    php8.1-xml \
    php8.1-zip \
    php8.1-zmq

RUN rm /etc/apache2/sites-available/*.conf
COPY apache/super-potato.conf /etc/apache2/sites-available/super-potato.conf

RUN \
    a2ensite super-potato && \
    a2enmod rewrite && \
    a2enmod headers && \
    a2enmod proxy_fcgi && \
    a2enmod setenvif && \
    a2enconf php8.1-fpm && \
    # Disable dirctory Indexes
    sed -i 's/Options Indexes FollowSymLinks/Options FollowSymLinks/g' /etc/apache2/apache2.conf && \
    sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf && \
    # Enable stack-trace args
    sed -i 's/zend.exception_ignore_args = On/zend.exception_ignore_args = Off/g' /etc/php/8.1/cli/php.ini && \
    sed -i 's/zend.exception_ignore_args = On/zend.exception_ignore_args = Off/g' /etc/php/8.1/fpm/php.ini

WORKDIR /var/www/super-potato

COPY run.sh /run.sh
RUN chmod 755 /*.sh

# Keep Docker machine alive (replace with run.sh -> supervisor)
ENTRYPOINT /run.sh
