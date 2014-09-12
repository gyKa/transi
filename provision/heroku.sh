#!/usr/bin/env bash

# Create environment file.
touch .env

# Prepare environment variables.
printf "DB_ADAPTER=mysql\n" > .env
printf "DB_PORT=3306\n" >> .env
printf "DB_NAME=\n" >> .env
printf "DB_USER=\n" >> .env
printf "DB_PASS=\n" >> .env
printf "DB_HOST=\n" >> .env
printf "APP_ENV=production\n" >> .env
