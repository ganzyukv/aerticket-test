FROM php:7.3-fpm

ENV PATH=/app:/app/vendor/bin:/root/.composer/vendor/bin:$PATH \
    VERSION_PRESTISSIMO_PLUGIN=^0.3.10

RUN apt-get update \
    && apt-get install -y zlib1g-dev \
    libzip-dev \
    libicu-dev g++ \
	git \
    curl \
    wget \
    && pecl install xdebug \
    && docker-php-ext-install mysqli \
       	pdo \
       	pdo_mysql \
       	zip \
       	intl \
    && docker-php-ext-enable xdebug \
    && apt-get -y autoclean

# Install composer
RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer clear-cache

# Install composer plugins
RUN composer global require --optimize-autoloader \
        "hirak/prestissimo:${VERSION_PRESTISSIMO_PLUGIN}" \
        && composer global dumpautoload --optimize \
        && composer clear-cache