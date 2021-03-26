FROM php:7.4-fpm
LABEL maintainer="josh@osodevops.io"

ARG BUILD_DATE

LABEL org.label-schema.build-date=$BUILD_DATE

ENV LIBRDKAFKA_VERSION v0.11.0
ENV BUILD_DEPS \
        build-essential \
        git \
        libsasl2-dev \
        libssl-dev \
        python-minimal \
        zlib1g-dev

RUN apt-get update \
    && apt-get install -y --no-install-recommends ${BUILD_DEPS} \
    && cd /tmp \
    && git clone \
        --branch ${LIBRDKAFKA_VERSION} \
        --depth 1 \
        https://github.com/edenhill/librdkafka.git \
    && cd librdkafka \
    && ./configure \
    && make \
    && make install \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka \
    && rm -rf /tmp/librdkafka \
    && apt-get purge \
        -y --auto-remove \
        -o APT::AutoRemove::RecommendsImportant=false \
        ${BUILD_DEPS}

# PHP-FPM defaults
ENV PHP_FPM_PM="ondemand"
ENV PHP_FPM_MAX_CHILDREN="10"
ENV PHP_FPM_START_SERVERS="1"
ENV PHP_FPM_MIN_SPARE_SERVERS="1"
ENV PHP_FPM_MAX_SPARE_SERVERS="10"
ENV PHP_FPM_MAX_REQUESTS="500"

# Install supervisor
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    supervisor \
  && rm -rf /var/lib/apt/lists/*

COPY ./docker/php/production/configs/supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

# Copy the Horizon configuration file
COPY ./docker/php/production/configs/supervisord.conf /etc/supervisor/conf.d/

RUN chmod a+w /etc/supervisor/conf.d

# Copy existing application directory contents
COPY --chown=www-data . /var/www/html
RUN mkdir /var/www/.config
RUN chown www-data:www-data /var/www/.config

# Switch to www-data
USER www-data

# Create Storage Link (php artisan storage:link)
RUN rm -rf /var/www/html/public/storage
RUN ln -s /var/www/html/storage/app/public /var/www/html/public/storage

# Copy the PHP-FPM configuration file
COPY ./docker/php/production/configs/www.conf /usr/local/etc/php-fpm.d/www.conf

# Install Composer (latest version).
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && ln -s $(composer config --global home) /root/composer
  
ENV PATH=$PATH:/root/composer/vendor/bin COMPOSER_ALLOW_SUPERUSER=1

# Expose port 9000
EXPOSE 9000
