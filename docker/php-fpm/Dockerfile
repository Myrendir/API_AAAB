FROM php:7.4-fpm

# Install selected extensions and other stuff
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        dos2unix \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        zip \
        zlib1g-dev \
        unzip \
        libnss3-dev \
        gconf-service libasound2 libatk1.0-0 libc6 \
	      libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgcc1 \
	      libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 \
	      libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 \
	      libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 \
	      libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates \
        chromium \
	      fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils wget 

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions gd xdebug soap pdo_mysql zip pcov apcu

# Install Composer
RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

EXPOSE 9000

ADD entrypoint.dev.sh /docker-entrypoint.sh
RUN dos2unix /docker-entrypoint.sh
RUN chmod a+x /docker-entrypoint.sh
ENTRYPOINT ["/docker-entrypoint.sh"]

WORKDIR "/var/www/web"
