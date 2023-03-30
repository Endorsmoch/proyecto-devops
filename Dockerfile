FROM ubuntu:20.04

# Set environment variable to avoid interactive prompts
ENV DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update && apt-get install -y \
    software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y \
    nginx \
    php8.2-fpm \
    php8.2-mysql \
    php8.2-xml \
    mysql-server

# Configure MySQL
RUN service mysql start \
    && mysql -e "CREATE DATABASE devops;" \
    && mysql -e "CREATE USER 'root'@'127.0.0.1' IDENTIFIED BY '';" \
    && mysql -e "ALTER USER 'root'@'127.0.0.1' IDENTIFIED WITH mysql_native_password BY '';" \
    && mysql -e "GRANT ALL PRIVILEGES ON devops.* TO 'root'@'127.0.0.1' WITH GRANT OPTION;" \
    && mysql -e "FLUSH PRIVILEGES;"

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

# Clear cache
RUN php /var/www/html/artisan config:cache

# Remove default Nginx configuration file
RUN rm /etc/nginx/sites-enabled/default

# Expose port 80
EXPOSE 80

# Copy MySQL startup script
COPY start-mysql.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/start-mysql.sh

# Run MySQL startup script and Laravel migration
CMD start-mysql.sh && php /var/www/html/artisan migrate --force && service php8.2-fpm start && nginx -g "daemon off;"
