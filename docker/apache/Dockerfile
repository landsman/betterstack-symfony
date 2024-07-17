FROM httpd:alpine

RUN apk update

RUN mkdir -p /usr/local/apache2/conf/vhosts
RUN mkdir -p /var/www/html

RUN echo "IncludeOptional conf/vhosts/*.conf" >> /usr/local/apache2/conf/httpd.conf
