FROM nginx:latest

ADD site.conf /etc/nginx/conf.d/default.conf

ADD ./public /var/www/wacorner

RUN chown -R www-data:www-data /var/www/wacorner && \
    chmod -R 755 /var/www/wacorner