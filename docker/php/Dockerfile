FROM php:7.4-fpm as base

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

ENV TZ=Europe/Prague

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y openssh-client git curl procps htop tzdata wget

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN delgroup dialout

RUN addgroup --gid ${GID} app
RUN adduser --gecos "" --shell /bin/bash --gid ${GID} --uid ${UID} --disabled-password app

FROM base as ipe

RUN curl -Lo install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
    && chmod +x ./install-php-extensions

RUN ./install-php-extensions pgsql pdo_pgsql pcntl gd zip opcache

RUN rm -f install-php-extensions

FROM ipe as composer

RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

RUN mkdir -p /composer && chown -R app:app /composer

FROM ipe as phpimage

EXPOSE 9000
CMD ["php-fpm"]

FROM phpimage as xdebug

RUN pecl install xdebug-2.9.8 \
    && docker-php-ext-enable xdebug

RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_upon_error=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini # remote_autostart is necessary until xDebug version 3 (no browser extension required afterwards)

EXPOSE 9000 9003
