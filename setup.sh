#!/bin/bash

docker-compose up --build -d

docker exec -it gifts_app composer install
docker exec -it gifts_app php artisan migrate --seed
docker exec -it gifts_app npm install
docker exec -it gifts_app chown root -R .
docker exec -it gifts_app chmod -R gu+w storage
docker exec -it gifts_app chmod -R guo+w storage
docker exec -it gifts_app npm run dev
sudo chown anowakowski -R .
