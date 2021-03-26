
# README.md of backend folder




## Run project at local
### Requirement
- Clone app at https://github.com/dangvannhang/backend-laravel
- Create database with database name is "db_piccine"
### Ways to run app 
- composer update
- composer require laravel/passport "~9.0"
- php artisan migrate
- php artisan passport:install
- php artisan serve


## Deploy to heroku from local project


## Deploy to heroku from git 
### Requirements
- Install heroku CLI
- Login account heroku by your teminal by enter "heroku login" in your terminal 
- In your source code git, you must have file Procfile in your main laravel directory 
  with line code "web: vendor/bin/heroku-php-apache2 public/"
### Way to deploy
- heroku create
- git push heroku master

