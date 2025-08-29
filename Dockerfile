# Dockerfile para GEPEA (PHP + Apache)
FROM php:8.2-apache

# Instala extensões comuns do PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia o código para o container
COPY back-end/anonimo/ /var/www/html/
# Corrige permissões dos arquivos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Permite sobrescrever configurações do Apache/PHP se necessário
# COPY ./config/php.ini /usr/local/etc/php/
# COPY ./config/000-default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
