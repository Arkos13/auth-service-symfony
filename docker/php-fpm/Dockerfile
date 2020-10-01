FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libpq-dev libpng-dev git libssh-dev \
	libjpeg-dev libfreetype6-dev wget ffmpeg unzip libicu-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure bcmath --enable-bcmath \
    && docker-php-ext-install pgsql pdo_pgsql sockets \
    && docker-php-ext-install -j$(nproc) bcmath \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
	&& composer --version

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get install -y librabbitmq-dev \
	&& pecl install amqp \
    && docker-php-ext-enable amqp

ADD ./php.ini /usr/local/etc/php/php.ini

WORKDIR /app

RUN groupadd --gid 1000 app \
	&& useradd --uid 1000 --gid app --shell /bin/bash --create-home app
USER app
