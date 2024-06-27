# ./docker/php/Dockerfile
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y --no-install-recommends
RUN apt-get install -y vim unzip git curl libzip-dev
RUN curl -sL https://deb.nodesource.com/setup_20.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install -y nodejs
RUN docker-php-ext-install zip opcache
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN rm -rf /tmp/*

WORKDIR /usr/src/app

COPY . /usr/src/app

COPY ./docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT [ "/entrypoint.sh" ]