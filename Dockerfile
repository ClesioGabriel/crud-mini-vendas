FROM php:8.3-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    libzip-dev \
    libpq-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia arquivos do projeto (será sobrescrito por volumes em desenvolvimento)
COPY . .

# Permissões corretas (opcionalmente, você pode configurar no host para evitar conflitos)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Expõe a porta do PHP-FPM (usada internamente no container)
EXPOSE 9000

CMD ["php-fpm"]
