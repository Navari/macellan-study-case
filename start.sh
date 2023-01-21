#!/usr/bin/env bash

docker-compose up -d;

DOMAIN="macellan-case.test"

if ! grep -q "$DOMAIN" /etc/hosts; then
    echo "Your system password is needed to add an entry to /etc/hosts..."
    echo "127.0.0.1 ::1 $DOMAIN" | sudo tee -a /etc/hosts
fi

cd ./application && composer install && php artisan migrate && php artisan test && cd ../;