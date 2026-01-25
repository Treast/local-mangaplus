FROM dunglas/frankenphp:1.11-builder-php8.5-alpine AS builder

RUN apk add --no-cache protobuf-dev libcap go

COPY --from=caddy:builder /usr/bin/xcaddy /usr/bin/xcaddy

RUN CGO_ENABLED=1 \
    XCADDY_SETCAP=1 \
    XCADDY_GO_BUILD_FLAGS="-ldflags='-w -s' -tags=nobadger,nomysql,nopgx" \
    CGO_CFLAGS=$(php-config --includes) \
    CGO_LDFLAGS="$(php-config --ldflags) $(php-config --libs)" \
    xcaddy build \
        --output /usr/local/bin/frankenphp \
        --with github.com/dunglas/frankenphp=./ \
        --with github.com/dunglas/frankenphp/caddy=./caddy/ \
        --with github.com/dunglas/caddy-cbrotli \
        --with github.com/dunglas/mercure/caddy \
        --with github.com/dunglas/vulcain/caddy \
        --with github.com/baldinof/caddy-supervisor

FROM dunglas/frankenphp:1.11-php8.5-alpine AS runner

COPY --from=builder /usr/local/bin/frankenphp /usr/local/bin/frankenphp

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
