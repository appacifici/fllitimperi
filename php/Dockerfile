FROM php:7.2-fpm  

RUN apt-get update && apt-get install -y \
	libxml2-dev \
	libcurl4-openssl-dev \
	libicu-dev \
	default-mysql-client \
	zlib1g-dev \
	libzip-dev \
	zip \
	unzip \
	nano \
	iputils-ping \
	wget \	
	npm

RUN docker-php-ext-install simplexml curl pdo pdo_mysql zip intl sockets

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - 
RUN apt-get install -y nodejs

RUN npm install --global globalthis gulp gulp-cli sass gulp-sass gulp-debug
ENV NODE_PATH=/usr/local/lib/node_modules


#RUN pecl install ast && docker-php-ext-enable ast
#RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list
RUN apt-get update && apt-get install -y symfony-cli

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

#Creazione utente necessario per dare i necessari permessi a nginx di lettura
RUN groupadd -g 1000 devuser
RUN useradd -d /home/devuser -s /bin/bash -u 1000 -g 1000 devuser
RUN mkdir /home/devuser
RUN chown -R devuser:devuser /home/devuser

USER devuser
COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker-php-ram-limit.ini /usr/local/etc/php/conf.d/docker-php-ram-limit.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

USER root
COPY entrypoint.sh /entrypoint.sh
RUN chmod a+x /entrypoint.sh
ENTRYPOINT [ "/entrypoint.sh" ]
CMD [ "init" ]