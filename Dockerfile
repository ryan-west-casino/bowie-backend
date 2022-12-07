FROM docker.io/devilbox/php-fpm:8.1-prod

WORKDIR /var/www

RUN rm -rf /var/www/html \
  && apt-get update -y \
  && apt-get install -y \
  unzip \
  wget \
  zip \
  supervisor \
  && apt autoremove -y \
  && apt clean \
  && pecl install redis \
  && docker-php-ext-install \
  bcmath \
  opcache \
  pdo_pgsql \
  pgsql \
  zip \
  && curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer

EXPOSE 9000
