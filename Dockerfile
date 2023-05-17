FROM debian:bullseye-slim

# Set environment variable to avoid interactive prompts
ENV DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    php8.0-fpm \
    php8.0-mysql \
    php8.0-xml

# Copy Nginx configuration file
COPY nginx.conf /etc/nginx/sites-enabled/

# Copy Laravel application
COPY . /var/www/html

# Change ownership of the application
RUN chown -R www-data:www-data /var/www/html

# Copy the .env.example file and rename it to .env
COPY .env.example /var/www/html/.env

# Generate application key
RUN php /var/www/html/artisan key:generate --env=/var/www/html/.env

# Run database migrations
RUN php /var/www/html/artisan migrate --env=/var/www/html/.env

# Clear cache
RUN php /var/www/html/artisan config:cache

# Remove default Nginx configuration file
RUN rm /etc/nginx/sites-enabled/default

# Expose port 80
EXPOSE 80

# Start Nginx and PHP-FPM services
CMD service php8.0-fpm start && nginx -g "daemon off;"
