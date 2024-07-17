FROM php:7.4-apache

RUN apt-get update
RUN apt-get install -y libzip-dev libpq-dev ssl-cert wget libicu-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-configure intl
RUN docker-php-ext-install zip pdo pdo_pgsql pgsql intl
RUN echo 'memory_limit=-1' > /usr/local/etc/php/conf.d/memory-limit.ini
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf
RUN a2enmod rewrite
#RUN a2enmod ssl
#RUN a2ensite default-ssl.conf
RUN curl -sL https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_10.x  | bash -
RUN pt-get -y install nodejs
RUN npm install --global yarn

ENTRYPOINT ["./installInContainer.sh"]
