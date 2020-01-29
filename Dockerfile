FROM php:7.1-apache
MAINTAINER Caitlyn Osborne <acaeris@gmail.com>

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
  curl \
  rsync

COPY . /home/sites/scheduler-list

WORKDIR /home/sites/scheduler-list

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer install && composer clear-cache

RUN rm /etc/apache2/sites-enabled/000-default.conf
COPY schedluer.conf /etc/apache2/sites-enabled/scheduler.conf

RUN a2enmod rewrite dir

EXPOSE 80
EXPOSE 82
EXPOSE 444
EXPOSE 8080
