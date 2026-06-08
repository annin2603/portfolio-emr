FROM php:8.4-cli

# Nodeも入れる（重要）
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql

# Node.jsインストール
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# 依存関係だけ先にコピー（キャッシュ効率UP）
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# frontend
COPY package.json package-lock.json ./
RUN npm install

# 残りコピー
COPY . .

RUN npm run build

ENV APP_URL=https://portfolio-emr.onrender.com

CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000"]
