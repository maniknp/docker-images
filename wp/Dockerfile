FROM maniknp/php:1.4-php8.2-alpine


# update the root user id to 1000
# RUN deluser www-data \
#     && addgroup -g 1000 www-data \
#     && adduser -u 1000 -G www-data -H -D www-data

RUN deluser www-data \
    && addgroup -g 33 www-data \
    && adduser -u 33 -G www-data -H -D www-data


# Set environment variables
ENV PHP_OPCACHE_ENABLE=0
ENV PHP_OPCACHE_ENABLE_CLI=0
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
ENV PHP_OPCACHE_REVALIDATE_FREQ=0

USER root
# make user home directory writable by www-data
RUN mkdir -p /home/www-data \
    && chown -R www-data:www-data /home/www-data

# www-data can write in `/var/log/php-fpm`
RUN mkdir -p /var/log/php-fpm \
    && chown -R www-data:www-data /var/log/php-fpm

# Create PHP-FPM log directories with proper permissions
RUN mkdir -p /var/log/php-fpm \
    && touch /var/log/php-fpm/www.access.log \
    && touch /var/log/php-fpm/www.error.log \
    && chown -R www-data:www-data /var/log/php-fpm \
    && chmod -R 775 /var/log/php-fpm

# composer install
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 

#  install wp-cli
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp


RUN sed -i 's/listen = 127.0.0.1:9000/listen = 9000/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;pm = dynamic/pm = dynamic/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;pm.max_children = 5/pm.max_children = 50/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;pm.start_servers = 2/pm.start_servers = 5/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;pm.min_spare_servers = 1/pm.min_spare_servers = 4/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;pm.max_spare_servers = 3/pm.max_spare_servers = 6/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;access.format = .*/access.format = "%R - %u %t \"%m %r\" %s"/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;ping.path = .*/ping.path = \/ping/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;ping.response = .*/ping.response = pong/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/;pm.status_path = .*/pm.status_path = \/status/' /usr/local/etc/php-fpm.d/www.conf\
    && sed -i 's/;access.log = .*/access.log = \/var\/log\/php-fpm\/\$pool.access.log/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's|;access.log = log/$pool.access.log|access.log = /var/log/php-fpm/www.access.log|' /usr/local/etc/php-fpm.d/www.conf



# COPY ./php.ini-dev /usr/local/etc/php/php.ini

# Set group www-data as the owner of the /var/www folder
RUN chown -R www-data:www-data /var/www

#  Install Python 

USER www-data
WORKDIR /var/www/
