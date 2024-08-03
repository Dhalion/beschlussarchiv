# Verwenden Sie das Basis-Image
FROM dunglas/frankenphp

# Installieren Sie zusätzliche PHP-Erweiterungen
RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache
