###################
# BASE            #
###################
FROM ubuntu:20.04 as base

# install curl
RUN apt-get update && apt-get install -y curl gosu;
RUN ln -snf /usr/share/zoneinfo/$(curl https://ipapi.co/timezone -s) /etc/localtime;

ARG UID
ARG GID
ENV UID=$UID
ENV GID=$GID

RUN groupadd -g $GID developer; \
    useradd -u $UID -m developer -g $GID; \
    umask 002; \
    echo "umask 002" >> /home/developer/.bashrc;

#php 8.3
RUN apt-get update && apt-get install -y \
    lsb-release ca-certificates apt-transport-https software-properties-common -y; \
    add-apt-repository ppa:ondrej/php; \
    apt-get update && apt-get install -y \
    php8.3 \
    php8.3-cli \
    php8.3-curl \
    php8.3-common \
    php8.3-mbstring \
    php8.3-opcache \
    php8.3-readline \
    php8.3-xml \
    php8.3-zip \
    php8.3-pgsql \
    php8.3-sqlite3 \
    php8.3-bcmath \
    php8.3-intl \
    php8.3-memcached \
    php8.3-imap \
    php8.3-msgpack \
    php8.3-gd \
    php8.3-zmq \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*;

ARG BASE_DIR="/srv"
ARG BASE_DIR_E="\/srv"
ARG URL_PROD
ARG URL_QA
ARG URL_DEV
ARG OWNERS_EMAIL

RUN mkdir -p $BASE_DIR;

# apache2
RUN apt-get update && apt-get install -y apache2; \
    a2dissite 000-default.conf; \
    rm /etc/apache2/sites-available/*;

COPY ./docker/artifacts/apache/url.conf /etc/apache2/sites-available/$URL_PROD.conf
COPY ./docker/artifacts/apache/apache2.conf /etc/apache2/apache2.conf
RUN sed -i "s/&BASE_DIR&/$BASE_DIR_E/;s/&URL_PROD&/$URL_PROD/g;s/&URL_QA&/$URL_QA/g;s/&URL_DEV&/$URL_DEV/g;s/&OWNERS_EMAIL&/$OWNERS_EMAIL/g;" /etc/apache2/sites-available/$URL_PROD.conf; \
    sed -i -E  "s/(export APACHE_RUN_USER=)(.*$)/\1developer/;s/(export APACHE_RUN_GROUP=)(.*$)/\1developer/" /etc/apache2/envvars; \
    sed -i -E  "s/&ServerName&$/$URL_PROD/;s/&BASE_DIR&/$BASE_DIR_E/;" /etc/apache2/apache2.conf; \
    a2enmod rewrite; \
    a2enmod ssl; \
    a2ensite $URL_PROD.conf;

#supervisor
RUN apt-get update && apt-get install -y supervisor; \
    sed -i -E "s/(\[supervisord\])/\1\nuser=root/;s/(logfile=).*/\1\/var\/log\/supervisor\/supervisord.log/" /etc/supervisor/supervisord.conf; \
    mkdir -p /home/developer/supervisor;

RUN mkdir -p $BASE_DIR; \
    chown developer:developer $BASE_DIR; \
    chmod 775   $BASE_DIR;

USER root

COPY ./docker/entrypoint.sh /usr/bin/entrypoint.sh
COPY ./docker/artifacts/supervisor/apache2d.conf /etc/supervisor/conf.d/apache2d.conf
COPY ./docker/artifacts/supervisor/cron.conf /etc/supervisor/conf.d/cron.conf
RUN chmod 544 /usr/bin/entrypoint.sh;

RUN sed -i -E "s/&BASE_DIR&/$BASE_DIR_E/;" /usr/bin/entrypoint.sh; \
    sed -i -E "s/&BASE_DIR&/$BASE_DIR_E/;" /etc/supervisor/conf.d/apache2d.conf; \
    sed -i -E "s/&BASE_DIR&/$BASE_DIR_E/;" /etc/supervisor/conf.d/cron.conf;

RUN apt-get update && apt-get install -y \
    ffmpeg \
    v4l-utils \
    fswebcam; \
    apt-get -y autoremove; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*;

WORKDIR $BASE_DIR

CMD ["/usr/bin/supervisord"]

###################
# DEV             #
###################
FROM base as dev

# ARG BASE_DIR=/srv

RUN apt-get update && apt-get install -y \
    nano vim unzip iputils-ping silversearcher-ag net-tools netcat npm; \
    npm install -g n; \
    n latest;

# composer
RUN cd /home/developer; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'baf1608c33254d00611ac1705c1d9958c817a1a33bce370c0595974b342601bd80b92a3f46067da89e3b06bff421f182') \
            { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"; \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer; \
    php -r "unlink('composer-setup.php');";\
    apt-get -y autoremove; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*;

#REPEATED SECTION FROM HERE
USER root

ENV APP_DEBUG true
ENTRYPOINT ["entrypoint.sh"]
#REPEATED SECTION ENDS HERE

###################
# BUILD           #
###################
FROM dev as build

COPY web/* $BASE_DIR/

USER developer

RUN mkdir -p \
    /home/developer/apache2 \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views;

# config:clear because that breaks feature tests
# route:clear because caching causes 500 server error
RUN composer install --no-dev --no-interaction --optimize-autoloader; \
    npm install; \
    npm run dev; \
    composer dump-autoload;

########
# PROD #
########
FROM base as prod

ARG BASE_DIR=/srv
USER developer
COPY --from=build $BASE_DIR $BASE_DIR

USER root
RUN chmod 775 $BASE_DIR;

#REPEATED SECTION FROM HERE
ENV APP_DEBUG false
ENTRYPOINT ["entrypoint.sh"]
#REPEATED SECTION ENDS HERE

EXPOSE 80