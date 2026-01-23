FROM dunglas/frankenphp:1.11-builder-php8.5-alpine

ARG USER=appuser

RUN apk add --no-cache protobuf-dev libcap

RUN install-php-extensions \
	apcu \
	brotli \
	gd \
	intl \
	pdo_sqlite \
	protobuf \
	opcache \
    zip

RUN addgroup -g 1000 -S ${USER} && \
    adduser -u 1000 -S ${USER} -G ${USER}

RUN \
    setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp; \
    chown -R ${USER}:${USER} /config/caddy /data/caddy

USER ${USER}
