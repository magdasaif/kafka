FROM php:8.1.8-fpm
WORKDIR /var/www
RUN apt-get update \
    && apt install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libpq-dev \
    libzip-dev \
    openssh-client \
    default-mysql-client \
    git \
    zip \
    unzip \
    sqlite3 \
    libprotobuf-lite23 \
    libprotobuf-dev \
    protobuf-compiler \
    # docker-php-ext-install pdo pdo_mysql sockets bcmath zip pcntl posix \
    librdkafka-dev

RUN apt install -y telnet 

RUN apt-get install -y librdkafka-dev && pecl install rdkafka
RUN echo "extension=rdkafka.so" >> /usr/local/etc/php/conf.d/rdkafka.ini
RUN apt-get install -y cron
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
# RUN docker-php-ext-install pdo pdo_pgsql

# ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
# RUN install-php-extensions rdkafka  librdkafka-dev docker-php-ext-enable rdkafka librdkafka-dev

# RUN apt-get update\
#     && apt-get install librdkafka-dev\
#     && apt-get install rdkafka 

# RUN apk add --update --no-cache pcre-dev && \
# pecl install rdkafka && 


# Install ext-rdkafka
# RUN pecl install rdkafka && echo "extension=rdkafka.so" > /usr/local/etc/php/conf.d/rdkafka.ini



COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN apt clean \
    && rm -rf /var/lib/apt/lists/*  \
    && chown -R www-data:www-data .
USER root