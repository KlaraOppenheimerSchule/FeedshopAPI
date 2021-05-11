FROM php:7.4-fpm

RUN apt-get update && \
     apt-get install -y sudo && \
     apt-get install -y curl nano && \
     apt-get install -y git-all && \
     apt-get install -y libonig-dev
     
RUN apt-get install -y --no-install-recommends libpq-dev && \
    docker-php-ext-install mbstring && \
	docker-php-ext-install mysqli pdo_pgsql pdo_mysql && \
	apt-get install -q -y

