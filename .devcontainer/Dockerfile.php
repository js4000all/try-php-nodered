FROM php:8.2-fpm

RUN set -x \
    && apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y \
        curl \
        vim \
        git \
        less \
        zip \
        unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && adduser --disabled-password --home /home/app --shell /bin/bash app

COPY ./profile.d /etc/profile.d

WORKDIR /var/www/html
RUN chown -R app:app /var/www/html
USER app

CMD ["php-fpm"]
