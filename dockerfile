FROM php:7.4.4-apache

#Install git
RUN apt-get update && apt-get install -y git
RUN docker-php-ext-install pdo pdo_mysql mysqli

#enable Ubuntu module 'URL rewrite'
RUN a2enmod rewrite

#Install Composer
RUN echo "PHP version to follow:\n" && php -v
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin/ --filename=composer

#Install php testing package
RUN composer install --no-dev

COPY src/ /var/www/html/
expose 80
