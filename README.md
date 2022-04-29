## Gifts app
It is simple app for showing, storing and deleting reservations.
It is protected by laravel sanctum, so we need to be registered and logged in to use app functionalities.

In GUI you can register, log in/out, restart password etc. Also you can add nev reservation, check all reservations and delete them.

## Gifts API endpoints 
GET|HEAD  api/bookings .................. bookings.index › Api\BookingController@index 

POST      api/bookings ........................... bookings.store › Api\BookingController@store

DELETE    api/bookings/{booking} ....... bookings.destroy › Api\BookingController@destroy

GET|HEAD  api/rooms ....................... rooms.index › Api\RoomController@index

POST      api/rooms ................................ rooms.store › Api\RoomController@store

More info in postman collection.

## How to run

Copy the .env file and run in project root path command:

_sh setup.sh_

What this script do?
1. Starts 3 docker containers (app, mysql, phpmyadmin)
2. Runs composer install
3. Runs npm install
4. Compiles assets with npm run dev
5. Setting up DB with php artisan migrate

After that app is available at:

[http://localhost:8000/](http://localhost:8000/)