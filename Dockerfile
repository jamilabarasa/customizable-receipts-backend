FROM php:7.1-apache
RUN apt-get update && docker-php-ext-install pdo_mysql
COPY api/ /var/www/html/

# CMD [ "php", "./users.php" ]
    
