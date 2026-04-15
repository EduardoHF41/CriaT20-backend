FROM php:8.4-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Permissões
RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]