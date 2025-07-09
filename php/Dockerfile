# Build stage
FROM php:8.2-fpm-alpine AS builder

# Install build dependencies
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    bash \
    build-base \
    autoconf \
    g++ \
    gcc \
    make \
    git \
    linux-headers \
    pkgconfig \
    libtool \
    imagemagick-dev \
    libmemcached-dev \
    libzip-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    zlib-dev \
    openssl-dev \
    ca-certificates \
    libssh-dev \
    libstdc++ \
    libc++ \
    curl-dev

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        zip \
        pdo \
        pdo_mysql \
        mysqli \
        gd \
        opcache \
    && pecl install redis-5.3.7 \
    && pecl install memcached-3.2.0 \
    && pecl install imagick \
    # && pecl install grpc \
    && docker-php-ext-enable \
        redis \
        memcached \
        imagick\
        opcache 
        # grpc


        # Install runtime dependencies in final stage
        RUN apk add --no-cache \
            imagemagick \
            libmemcached \
            libzip \
            libjpeg-turbo \
            libpng \
            libwebp \
            zlib \
            openssl \
            bzip2 \
            enchant2 \
            gmp \
            icu \
            krb5 \
            libxml2 \
            libxslt \
            libldap \
            net-snmp \
            postgresql \
            tidyhtml \
            unixodbc \
            freetds


    
        # Extract PHP source and install all available extensions
        RUN cd /usr/src \
            && tar -xf php.tar.xz \
            && cd php-8.2.* \
            && for ext in ext/*; do \
                if [ -d "$ext" ]; then \
                    ext_name=$(basename $ext); \
                    if [ "$ext_name" != "opcache" ] && [ "$ext_name" != "test" ]; then \
                        if docker-php-ext-install -j$(nproc) $ext_name > /dev/null 2>&1; then \
                            echo "Installed $ext_name"; \
                        fi; \
                    fi; \
                fi; \
            done 
            # && rm -rf /usr/src/php*
    
# Clear up build dependencies
RUN apk del .build-deps


# Final stage
FROM php:8.2-fpm-alpine

# Copy built extensions from builder
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Install runtime dependencies
RUN apk add --no-cache \
    imagemagick \
    libmemcached \
    libzip \
    libjpeg-turbo \
    libpng \
    libwebp \
    zlib \
    openssl



    RUN apk add --no-cache \
    freetype \
    libpng \
    libjpeg-turbo \
    libwebp \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd \
    && php -r 'var_dump(gd_info());' | grep -i 'jpeg\|jpg' \
    && apk del freetype-dev libpng-dev libjpeg-turbo-dev libwebp-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/
