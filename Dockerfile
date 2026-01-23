FROM dunglas/frankenphp:1.11-builder-php8.5-alpine

RUN install-php-extensions \
	apcu \
	gd \
	intl \
	pdo_sqlite \
	protobuf \
	opcache \
    zip

