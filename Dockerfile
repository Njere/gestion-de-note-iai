# Utiliser une image PHP avec Apache
FROM php:7.4-apache

# Installer PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copier le code source
COPY . /var/www/html/

# Configuration Apache
EXPOSE 80
