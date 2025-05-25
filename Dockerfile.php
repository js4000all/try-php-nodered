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
        default-mysql-client \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && useradd -m -s /bin/bash app

WORKDIR /tmp
RUN set -x \
    && curl -L https://dl.influxdata.com/influxdb/releases/influxdb2-client-2.7.5-linux-amd64.tar.gz -O \
    && tar xvzf ./influxdb2-client-2.7.5-linux-amd64.tar.gz \
    && mv ./influx /usr/local/bin/ \
    && rm -rf influxdb2-client-2.7.5-linux-amd64.tar.gz

COPY ./profile.d /etc/profile.d

WORKDIR /var/www/html
RUN chown -R app:app /var/www/html
USER app

CMD ["php-fpm"]
