#!/bin/sh
set -e

# Injeta a porta do Render ($PORT) na config do Nginx.
: "${PORT:=10000}"
sed "s/__PORT__/${PORT}/g" /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

cd /var/www/html

# Descobre pacotes e gera caches de produção (config em runtime, pois as
# variáveis de ambiente só existem aqui — não no build).
php artisan package:discover --ansi || true
php artisan config:cache
php artisan view:cache || true

# Roda as migrations. Falha o boot se o banco não estiver acessível.
php artisan migrate --force

# Garante permissões de escrita do Laravel.
chown -R www-data:www-data storage bootstrap/cache || true

exec supervisord -c /etc/supervisord.conf
