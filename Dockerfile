FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    libmemcached-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    lua-zlib-dev \
    nginx \
    librabbitmq-dev \
    wget \
    libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl gd sockets pdo_pgsql soap intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y supervisor

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www

RUN composer install --prefer-dist --no-dev

RUN php artisan l5-swagger:generate

EXPOSE 9000

CMD ["php-fpm"]
