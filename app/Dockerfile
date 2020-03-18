FROM germanramos/nginx-php-fpm:v7.0.7

RUN apk update && apk add curl && \
  curl -sS https://getcomposer.org/installer | php \
  && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/

COPY . .

RUN rm -rf html

RUN chmod -R 777 storage/*

RUN ln -s public html





