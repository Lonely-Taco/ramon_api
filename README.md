# Ramon_api for movies, games and books.

Finding the correlation between generes within the 3 given objects.
the goal is to visualize data and create crud methods to mutate and validate data.

## Requirements 

* PHP 8.1.^
* Compser

# Installation

install composer 

https://getcomposer.org/download/

laravel also has a decent guide for installing.

`composer global require laravel/installer`

# Import project

`git clone https://github.com/Lonely-Taco/ramon_api.git`


## To begin 

create a new database called ramon_api

copy the .env.example contents into a new .env file

with proper database username and password

## Run app

in the root folder of the project:

`npm install`

`composer install`

`php artisan migrate:fresh`

### troubleshooting

for windows its possible to require and extension to be enabled on the php.ini

uncomment `extension=gd`


to insert the data into the database run: 

`php artisan insert:data`

serve the application;

`php artisan serve`

# Documentation and API

its possible to try the API using the Swagger UI although it its alot slower when fetching large collections.

the GET list method usually takes a couple of minutes.

All testing was done with Postman.

if there are no swagger docs generate docs: 

The documetation is in

ramon_api/storage/api_docs/api-docs.json

` php artisan l5-swagger:generate `


http://127.0.0.1:8000/api/documentation 

http://127.0.0.1:8000/api/{{endpoint}}


## Making a request
specify in the header whether to accept application/xml or /json
![image](https://user-images.githubusercontent.com/47434636/160114907-e5bdc359-915f-4c36-b65f-fa8c961cc351.png)

## Post request

as shown below, i use the form-data to send post request in the body
![image](https://user-images.githubusercontent.com/47434636/160150769-cb8d8f44-d14a-4f0b-97e8-bc795350d2d6.png)

## Patch request
Fill the parameters in the params edit an object
![image](https://user-images.githubusercontent.com/47434636/160123244-0d27de04-0e6f-4cc5-99cd-83dd8f679a73.png)

## deleting any object place the id in the path
![image](https://user-images.githubusercontent.com/47434636/160123338-084023a9-0b6a-4e49-9d36-6ba0eb447da6.png)

 
## Object examples

### json:

`{
    "data": {
        "id": 2,
        "name": "game name",
        "release_date": "2020-05-18",
        "categories": "single player",
        "genres": "action",
        "positive_ratings": "33",
        "negative_ratings": "33",
        "created_at": "2022-03-23T21:42:02.000000Z",
        "updated_at": "2022-03-25T12:21:12.000000Z"
    }
}`

`{
    "id": 555,
    "title": "Absent in the Spring and Other Novels",
    "authors": "Mary Westmacott;Agatha Christie",
    "average_rating": 4.19,
    "ratings_count": 88,
    "publication_date": 1970,
    "created_at": "2022-03-23T21:41:52.000000Z",
    "updated_at": "2022-03-23T21:41:52.000000Z"
}`

`{
    "id": 55,
    "title": "Willy Wonka & the Chocolate Factory",
    "year": 1971,
    "iMDb": 7.8,
    "runtime": 100,
    "created_at": "2022-03-23T21:43:36.000000Z",
    "updated_at": "2022-03-23T21:43:36.000000Z"
}`

### xml:

`<?xml version="1.0" encoding="utf-8"?>
<root>
    <Game>
        <id>2</id>
        <name>game name</name>
        <release_date>2020-05-18</release_date>
        <categories>single player</categories>
        <genres>action</genres>
        <positive_ratings>33</positive_ratings>
        <negative_ratings>33</negative_ratings>
        <created_at>2022-03-23T21:42:02.000000Z</created_at>
        <updated_at>2022-03-25T12:21:12.000000Z</updated_at>
    </Game>
</root>`

`<?xml version="1.0" encoding="utf-8"?>
<root>
    <Movie>
        <id>5</id>
        <title>movie title</title>
        <year>2020</year>
        <iMDb>8.2</iMDb>
        <runtime>125</runtime>
        <created_at>2022-03-23T21:43:35.000000Z</created_at>
        <updated_at>2022-03-25T12:41:31.000000Z</updated_at>
    </Movie>
</root>`

`<?xml version="1.0" encoding="utf-8"?>
<root>
    <message>The data has been inserted.</message>
    <Book>
        <id>5</id>
        <title>book</title>
        <authors>book authour,another authpr</authors>
        <average_rating>8.2</average_rating>
        <ratings_count>125</ratings_count>
        <publication_date>2022</publication_date>
        <created_at>2022-03-23T21:41:51.000000Z</created_at>
        <updated_at>2022-03-25T11:41:20.000000Z</updated_at>
    </Book>
</root>`


