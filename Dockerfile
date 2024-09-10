# Используем официальный образ PHP
FROM php:8.1-fpm

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql zip opcache \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создаем рабочую директорию
WORKDIR /var/www

# Копируем существующий код в контейнер
COPY . .

# Устанавливаем зависимости Laravel
RUN composer install

# Копируем конфигурацию для PHP
COPY ./php.ini /usr/local/etc/php/

# Запускаем приложение
CMD ["php-fpm"]

# Открываем порт 9000
EXPOSE 9000
