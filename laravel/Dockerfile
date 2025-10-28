FROM php:8.4-fpm

# Instala dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    zip unzip git curl \
    && docker-php-ext-install pdo pdo_sqlite mbstring

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Diretório de trabalho
WORKDIR /var/www/html

# Copia todos os arquivos do Laravel
COPY . .

# Instala dependências do Laravel
RUN composer install --no-interaction --optimize-autoloader

# Exponha porta para o servidor interno do PHP
EXPOSE 8000

# Comando padrão para rodar Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
