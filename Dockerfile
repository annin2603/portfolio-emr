FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

ENV APP_URL=https://portfolio-emr.onrender.com

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
