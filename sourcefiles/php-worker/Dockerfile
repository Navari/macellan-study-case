#
#--------------------------------------------------------------------------
# Image Setup
#--------------------------------------------------------------------------
#

FROM php:8.2-alpine

RUN apk --update add wget \
  curl \
  git \
  build-base \
  libmcrypt-dev \
  libxml2-dev \
  linux-headers \
  pcre-dev \
  zlib-dev \
  autoconf \
  cyrus-sasl-dev \
  libgsasl-dev \
  oniguruma-dev \
  supervisor; \
  if [ $(php -r "echo PHP_VERSION_ID - PHP_RELEASE_VERSION;") = "50600" ] || \
     [ $(php -r "echo PHP_VERSION_ID - PHP_RELEASE_VERSION;") = "70000" ]; then \
    apk --update add libressl libressl-dev; \
  else \
    apk --update add openssl-dev; \
  fi


RUN pecl channel-update pecl.php.net; \
  docker-php-ext-install mysqli mbstring pdo pdo_mysql xml pcntl redis; \
  if [ $(php -r "echo PHP_VERSION_ID - PHP_RELEASE_VERSION;") = "80100" ] || \
     [ $(php -r "echo PHP_VERSION_ID - PHP_RELEASE_VERSION;") = "80200" ]; then \
    php -m | grep -oiE '^tokenizer$'; \
  else \
    docker-php-ext-install tokenizer; \
  fi


# Install PostgreSQL drivers:
ARG INSTALL_PGSQL=false
RUN if [ ${INSTALL_PGSQL} = true ]; then \
  apk --update add postgresql-dev \
  && docker-php-ext-install pdo_pgsql \
  ;fi

# Install Redis package:
ARG INSTALL_REDIS=false
RUN if [ ${INSTALL_REDIS} = true ]; then \
  # Install Redis Extension
  if [ $(php -r "echo PHP_MAJOR_VERSION;") = "5" ]; then \
  printf "\n" | pecl install -o -f redis-4.3.0; \
  else \
  printf "\n" | pecl install -o -f redis; \
  fi; \
  rm -rf /tmp/pear; \
  docker-php-ext-enable redis \
  ;fi

#
#--------------------------------------------------------------------------
# Optional Supervisord Configuration
#--------------------------------------------------------------------------
#
# Modify the ./supervisor.conf file to match your App's requirements.
# Make sure you rebuild your container with every change.
#

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

#
#--------------------------------------------------------------------------
# Optional Software's Installation
#--------------------------------------------------------------------------
#
# If you need to modify this image, feel free to do it right here.
#
# -- Your awesome modifications go here -- #

#
#--------------------------------------------------------------------------
# Check PHP version
#--------------------------------------------------------------------------
#

RUN php -v | head -n 1 | grep -q "PHP ${PHP_VERSION}."

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

# Clean up
RUN rm /var/cache/apk/* \
  && mkdir -p /var/www

WORKDIR /etc/supervisor/conf.d/
