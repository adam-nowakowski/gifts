#!/bin/bash

docker-compose up --build -d

docker exec -it gifts_app composer install
docker exec -it gifts_app npm install
docker exec -it gifts_app npm run dev
docker exec -it gifts_app php artisan migrate --seed
