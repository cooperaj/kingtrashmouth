#-- setup base php server image
FROM docker.io/dunglas/frankenphp:latest-php8.3-alpine as base

ENV SERVER_NAME=:80

RUN install-php-extensions gd


#-- production assets
FROM docker.io/node:18-alpine as build-production-assets

RUN apk add --no-cache libstdc++ libgcc

COPY ./package.json ./package-lock.json ./vite.config.js /app/

WORKDIR /app

RUN npm ci

COPY ./resources /app/resources

RUN npm run build


#-- production dependencies
FROM base as build-production-dependencies

COPY --from=docker.io/composer:latest /usr/bin/composer /usr/bin/composer
COPY ./ /app

RUN mkdir vendor/ && \
    chown www-data bootstrap/cache/ vendor/

USER www-data

RUN composer install --no-dev --optimize-autoloader


#-- development image
FROM base as build-development

RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN apk add --no-cache libstdc++ libgcc

COPY --from=docker.io/composer:latest /usr/bin/composer /usr/bin/composer

COPY --from=build-production-assets /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=build-production-assets /usr/local/include/node /usr/local/include/node
COPY --from=build-production-assets /usr/local/share/man/man1/node.1 /usr/local/share/man/man1/node.1
COPY --from=build-production-assets /usr/local/share/doc/node /usr/local/share/doc/node
COPY --from=build-production-assets /usr/local/bin/node /usr/local/bin/node
COPY --from=build-production-assets /opt/ /opt/

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm
RUN ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx
RUN ln -s /opt/yarn-$(ls /opt/ | grep yarn | sed 's/yarn-//')/bin/yarn /usr/local/bin/yarn
RUN ln -s /opt/yarn-$(ls /opt/ | grep yarn | sed 's/yarn-//')/bin/yarnpkg /usr/local/bin/yarnpkg


#-- production image
FROM base as build-production

ENV ENV=PRODUCTION

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY ./ /app/
COPY --from=build-production-assets /app/public/build /app/public/build
COPY --from=build-production-dependencies --chown=0:0 /app/vendor /app/vendor

RUN ./artisan migrate --force && \
    chown www-data:www-data /app/database /app/database/database.sqlite && \
    chown -R www-data:www-data /app/storage/*
    
USER www-data