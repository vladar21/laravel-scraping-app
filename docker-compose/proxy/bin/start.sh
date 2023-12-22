#!/bin/bash

# Configure Apache
if ! grep -q "ServerName localhost" /etc/apache2/apache2.conf; then
    echo "ServerName localhost" >> /etc/apache2/apache2.conf
fi

cd /etc/apache2 &&
apache2ctl configtest &&
a2enmod headers &&
a2enmod rewrite

# Enable the appropriate Apache site based on the PHP container type
a2ensite lse

# Disable the default site
a2dissite 000-default.conf

# Configure the module for the current PHP container
module_path="/var/www/html"
if [ -d "$module_path" ]; then
  # shellcheck disable=SC2164
  cd "$module_path"

  # Run composer install to install PHP dependencies
  composer install

  php artisan config:clear

  php artisan migrate
fi

# Start Apache in the foreground
exec apache2ctl -D FOREGROUND
