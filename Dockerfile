# Dockerfile
FROM php:8.4-fpm

# نصب ابزارهای پایه
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath

# نصب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تنظیم پوشه کار
WORKDIR /var/www

# کپی پروژه
COPY . .

# نصب پکیج‌ها
RUN composer install

# تنظیم دسترسی‌ها
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

EXPOSE 9000
CMD ["php-fpm"]
