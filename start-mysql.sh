#!/bin/bash

# Start MySQL service
service mysql start

# Wait for MySQL to start
while ! mysqladmin ping -h127.0.0.1 --silent; do
    sleep 1
done
