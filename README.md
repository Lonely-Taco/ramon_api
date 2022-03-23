# Ramon_api for movies, games and books.

Finding the correlation between generes within the 3 given objects.
the goal is to visualize data and create crud methods to mutate and validate data.

## Requirements 

*PHP 8.^

# Inatllation

install composer 

https://getcomposer.org/download/

laravel also has a decent guide for installing.

`composer global require laravel/installer`


### troubleshooting

for windows its possible to require and extension to be enabled on the php.ini

uncomment `extension=gd`



## to begin 

create a new database called ramon_api

copy the .env.example contents into a new .env file

run:

`php artisan migrate:fresh`


to insert the data into the database run: 

`php artisan insert:data`

serve the application;

`php artisan serve`


