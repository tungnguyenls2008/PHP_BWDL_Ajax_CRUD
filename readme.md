# AJAX CRUD for Laravel 5.4

Asynchronous actions on a Laravel resource controller. Based on works by jeanquark (http://www.jmkleger.com/post/ajax-crud-for-laravel-5-4).

## Installation

Clone the repo


Move to the newly created folder and install all dependencies:
```
cd ajax-crud
composer install
```

Create a new database, for example with phpMyAdmin. Then open the .env.example file, edit it to match your database name, username and password and save it as .env file. Once done, build tables with the following command:
```
php artisan migrate
```

Now fill the tables:
```
php artisan db:seed
```

Finally, generate the application key 
```
php artisan key:generate
```

Open your favorite browser and visit the newly created app.

## Features
1. Create a new post
2. Show a post
3. Edit a post
4. Delete a post
5. Mark a post as published/unpublished
