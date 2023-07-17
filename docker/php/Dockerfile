FROM php:8.2-fpm-alpine3.16
RUN apk --no-cache add --update \
        $PHPIZE_DEPS \
        bash \
        linux-headers \
        icu \
        libzip-dev \
        freetype-dev

ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions opcache gd intl mysqli pdo_mysql xdebug zip

RUN docker-php-source delete && rm -rf /var/cache/apk/* && apk del $PHPIZE_DEPS

WORKDIR /var/www/project/