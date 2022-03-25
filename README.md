# Ramon_api for movies, games and books.

Finding the correlation between generes within the 3 given objects.
the goal is to visualize data and create crud methods to mutate and validate data.

## Requirements 

*PHP 8.^

# Instllation

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

## Api http://127.0.0.1:8000/api/{endpoint}


## Making a request
specify in the header whether to accept application/xml or /json
![image](https://user-images.githubusercontent.com/47434636/160114907-e5bdc359-915f-4c36-b65f-fa8c961cc351.png)

## Patch request
Fill the parameters in the params edit an object
![image](https://user-images.githubusercontent.com/47434636/160123244-0d27de04-0e6f-4cc5-99cd-83dd8f679a73.png)

## deleting any object place the id in the path
![image](https://user-images.githubusercontent.com/47434636/160115503-6fb0bd79-493f-4818-95b9-465490781336.png)



