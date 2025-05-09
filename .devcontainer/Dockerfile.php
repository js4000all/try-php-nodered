FROM php:8.2-fpm

WORKDIR /var/www/html

# 必要に応じて追加の拡張モジュールをインストール
# RUN docker-php-ext-install pdo_mysql

CMD ["php-fpm"]
