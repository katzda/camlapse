FROM php:8.3-fpm-alpine AS base

ARG UID
ARG GID

RUN apk update && apk add --no-cache \
    nginx \
    sqlite \
    supervisor \
    v4l-utils \
    ffmpeg \
    php-redis \
    php-cli \
    build-base \
    linux-headers \
    autoconf && \
    docker-php-ext-install pcntl && \
    docker-php-ext-enable pcntl

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && apk add --no-cache redis \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

RUN apk add --no-cache shadow
RUN usermod -u $UID www-data
RUN groupmod -g $GID www-data

# Download and install gosu
RUN set -eux; \
    apk add --no-cache --virtual .gosu-deps wget gnupg; \
    GOSU_VERSION=1.14; \
    wget -O /usr/local/bin/gosu "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-amd64"; \
    chmod +x /usr/local/bin/gosu; \
    gosu nobody true; \
    apk del .gosu-deps

RUN mkdir -p /srv /etc/supervisor.d

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisor.ini /etc/supervisor.d
COPY docker/supervisord.conf /etc/
COPY docker/entrypoint.sh /bin

WORKDIR /srv
EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]


FROM base AS dev
RUN apk update && apk add --no-cache npm
RUN curl -s https://getcomposer.org/installer | php; \
    mv composer.phar /bin/composer


FROM dev AS build
COPY . /srv
RUN composer install
RUN npm install
RUN npm run dev

FROM build as prod
COPY --from=build /srv /srv
