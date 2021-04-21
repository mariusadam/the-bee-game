FROM php:7.4.16-alpine

# Copy Composer from official composer image
COPY --from=composer /usr/bin/composer /usr/bin/composer

USER www-data

# Simple built in server gets the job done for local env
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/app/public/"]