FROM docker.io/devilbox/php-fpm:8.1-prod

WORKDIR /var/www/default
COPY . /var/www/default

RUN curl "https://www.7-zip.org/a/7z2201-linux-x64.tar.xz" --output "here.tar.xz" \
    && tar xf here.tar.xz \
    && mv 7zz /usr/local/bin

RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
    && mv php.ini /usr/local/etc/php/php.ini \
    && mv www.conf /usr/local/etc/php-fpm.d/www.conf \
    && find /var/www -type f -exec chmod 664 {} \; \
    && find /var/www -type d -exec chmod 775 {} \; \
    && chgrp -R www-data storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

CMD ["/usr/local/sbin/php-fpm"]

EXPOSE 9000