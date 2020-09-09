# Ow Interactive API
API responsible for applying the intelligence and business rules of the Ow Interactive project.

## Installation

### Clone

Execute the following command to get the latest version of the project:

```terminal
$ git clone --recursive https://github.com/phelipemomesso/desafio-backend.git owinteractive
```

### Set permissions

Execute the following commands to set the write permission on the cache folder:

```terminal
$ cd owinteractive
$ sudo chmod -R 777 storage bootstrap/cache
```

## Docker

### Create and start containers

```terminal
$ docker-compose up --build -d
```

### Go to the workspace

Enter the Workspace container, to execute commands like (Artisan, Composer, PHPUnit, …):

```terminal
$ docker exec -it ow-interactive-php-fpm bash
```

### Install and configure the project

```terminal
/var/www$ composer install
/var/www$ cp .env.example .env
/var/www$ php artisan key:generate
/var/www$ php artisan migrate
/var/www$ php artisan module:seed User
/var/www$ php artisan module:seed Transaction
/var/www$ php artisan passport:install
```

### Default User created

```terminal
id: 1
email: phelipe.momesso@gmail.com
password: 12345678
```

Exit the workspace

```terminal
/var/www$ exit
```

## Host

This host where the project run

```terminal
http://localhost:8888/
```

## Unit Test

Enter the Workspace container, to execute commands like (Artisan, Composer, PHPUnit, …):

```terminal
$ docker exec -it ow-interactive-php-fpm bash
$ ./vendor/bin/phpunit
```

## Postman

Get a collection file Ow.postman_collection.json and import in your Postman to execute de requests.

## Routes of project

```terminal
http://localhost:8888/routes
```
