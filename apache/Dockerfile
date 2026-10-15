FROM php:7.2.34-fpm-alpine3.12

RUN set -eux; \
    apk add --no-cache \
        bash \
        curl \
        git \
        unzip \
        zip \
        icu-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        oniguruma-dev \
        libxml2-dev \
        netcat-openbsd \
        mysql-client \
        tzdata \
        shadow \
        $PHPIZE_DEPS; \
    docker-php-ext-configure gd \
        --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/; \
    docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
        mysqli \
        pdo \
        pdo_mysql \
        zip \
        gd \
        mbstring \
        xml \
        opcache \
        intl; \
    apk del --no-network $PHPIZE_DEPS; \
    rm -rf /tmp/* /var/cache/apk/*

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
COPY php.ini /usr/local/etc/php/php.ini
COPY entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

WORKDIR /var/www/html

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-F"]