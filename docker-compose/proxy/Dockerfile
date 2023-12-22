# Use the base PHP 8.1 with Apache image
FROM php:8.1-apache

# Replace the shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

# Install platform dependencies
RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    default-mysql-client \
    libpspell-dev \
    freetds-dev \
    unixodbc unixodbc-dev \
    libxslt-dev \
    libxml2-dev \
    libldap2-dev \
    libmagickwand-dev --no-install-recommends \
    build-essential \
    libpq-dev \
    libbz2-dev \
    libonig-dev \
    libpng-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libgmp-dev \
    libtidy-dev \
    locales \
    zip \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    unzip \
    git \
    curl \
    apt-utils \
    systemd \
    iputils-ping \
    nano \
    traceroute \
    dnsutils \
    htop \
    zlib1g-dev \
    sqlite3

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    bz2 \
    calendar \
    bcmath \
    dba \
    gettext \
    gmp \
    zip \
    exif \
    intl \
    pcntl \
    mysqli \
    opcache \
    pspell \
    shmop \
    soap \
    sockets \
    sysvmsg \
    sysvsem \
    sysvshm \
    tidy \
    gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy your start scripts into the image
COPY ./bin/start.sh /var/src/start.sh

# Change permissions on your start scripts
RUN chmod 700 /var/src/start.sh

# Use your start script as the entry point
CMD ["/var/src/start.sh", "start"]

# Set the working directory
WORKDIR /var/www/html/
