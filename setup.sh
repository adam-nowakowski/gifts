#!/bin/bash

docker-compose up --build -d

docker exec -it gifts_app composer install
docker exec -it gifts_app npm install
#npm hook
docker exec -it gifts_app chown root -R .
docker exec -it gifts_app npm run dev
docker exec -it gifts_app chown www-data:www-data -R .
docker exec -it gifts_app php artisan migrate:fresh --seed
sudo chown anowakowski -R .
