# Private Jet Booking API

Develop a RESTful API using PHP and Laravel that allows users to book, view, and cancel Private Jet Booking. The API should interact with a MySQL database to store and retrieve data.

## Installation

First clone this repository, install the dependencies, and setup your .env file.

```
git clone https://github.com/yogesh-vakhre/Private-Jet-Booking-API.git
cd Private-Jet-Booking-API/
composer install
cp .env.example .env
```

Setup database configuration in .env file on root directory.

```
DB_DATABASE=private_jet_booking
DB_USERNAME=root
DB_PASSWORD=
```

And run the initial run your application.

```
php artisan key:generate
php artisan migrate --seed
php artisan cache:clear
php artisan config:clear
```

And run the your laravel application. 

```
php artisan serve
```

Open  bewlow your localhost server in broweser
```
http://127.0.0.1:8000/
```

Now you can login with following credential:

```
Email: admin@gmail.com
Password: admin@123
```

if you face permissioan realated issue  in the your laravel application on Ubuntu or Centos oprating systeme then do this.

```
sudo chown -R deployer:www-data /var/www/html/Private-Jet-Booking-API/;
find /var/www/html/Private-Jet-Booking-API -type f -exec chmod 664 {} \;
find /var/www/html/Private-Jet-Booking-API -type d -exec chmod 775 {} \;
chgrp -R www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache
```

Please find below demo video Url for your refrence. 
```
https://drive.google.com/file/d/1v3KVLPn2HH6blP3kobiuy-1hPzksWOcr/view?usp=drivesdk
```
