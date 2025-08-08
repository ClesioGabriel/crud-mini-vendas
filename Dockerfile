FROM php:8.3-fpm-alpine

# Atualiza e instala dependências Alpine e ferramentas de build
RUN apk update && apk upgrade --no-cache \
    && apk add --no-cache \
        bash \
        autoconf \
        gcc \
        g++ \
        make \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        oniguruma-dev \
        libxml2-dev \
        zip \
        unzip \
        curl \
        git \
        nano \
        libzip-dev \
        postgresql-dev \
        libressl-dev \
        nodejs \
        npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala pcov e habilita
RUN pecl install pcov && docker-php-ext-enable pcov

WORKDIR /var/www

COPY . .

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

EXPOSE 9000

CMD ["php-fpm"]

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache
