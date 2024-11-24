FROM php:8.3-fpm-alpine

ARG UID
ARG GID

RUN apk update; \
    apk add --no-cache nginx sqlite php-sqlite3 supervisor v4l-utils ffmpeg npm;
#  motion

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