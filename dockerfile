FROM php:7.4.4-apache

#Install git
RUN php -v
RUN apt-get update && apt-get install -y git
RUN apt-get install zip unzip
RUN docker-php-ext-install pdo pdo_mysql mysqli

#enable Ubuntu module 'URL rewrite'
RUN a2enmod rewrite

#Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin/ --filename=composer

#setup database secrets file
COPY db_secret.prod.php /etc/db_secret.prod.php

#Make php error log file
RUN touch /var/log/php-error.log
RUN chmod 755 /var/log/php-error.log

#copy across necessary files
COPY . /var/www/
RUN rm /var/www/db_secret.prod.php

#change root that server runs files from
RUN sed -i 's+/var/www/html+/var/www/src/html+i' /etc/apache2/sites-available/000-default.conf

#Install php testing
RUN cd .. && composer update && composer install --no-dev

#RUN cd .. && vendor/bin/doctrine orm:schema-tool:create

EXPOSE 80
