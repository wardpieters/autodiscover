FROM caddy:2.8.4-alpine AS caddy

FROM php:8.3-fpm-alpine

RUN apk update && apk add supervisor

COPY --from=caddy /usr/bin/caddy /usr/bin/caddy

# Configure supervisor
RUN mkdir -p /etc/supervisor.d/
COPY ./docker/supervisord.ini /etc/supervisor.d/supervisord.ini

# Configure Caddy web server
COPY ./docker/Caddyfile /etc/caddy/Caddyfile

# Configure PHP-FPM
RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

WORKDIR /src
COPY ./src /var/www/html

EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor.d/supervisord.ini"]