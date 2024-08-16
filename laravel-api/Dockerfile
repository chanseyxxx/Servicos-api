# Use a imagem base oficial do PHP com FPM
FROM php:8.1-fpm

# Instale dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Instale extensões PHP necessárias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Defina o diretório de trabalho
WORKDIR /app

# Copie os arquivos do projeto para o diretório de trabalho
COPY . /app

# Instale as dependências do PHP
RUN composer install

# Otimize a aplicação Laravel
RUN php artisan optimize \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force

# Exponha a porta que o servidor irá usar
EXPOSE 8000

# Comando para iniciar o servidor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
