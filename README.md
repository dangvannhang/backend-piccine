# Run project at local

## Requirement

-   Clone app at https://github.com/dangvannhang/backend-piccine
-   Create database with database name is "db_piccine"

## Ways to run app in local

-   composer update
-   composer require laravel/passport "~9.0"
-   php artisan migrate
-   php artisan passport:install --forcce
-   php artisan db:seed
-   php artisan serve

# Deploy to heroku from local project

## Requirements

-   Install heroku CLI
-   Login account heroku by your teminal by enter "heroku login" in your terminal
-   In your source code git, you must have file Procfile in your main laravel directory
    with line code "web: vendor/bin/heroku-php-apache2 public/"
-   Exists source code laravel project

## Way to deploy

-   Open termial

*   git init
*   git add .
*   git commit -m "Initial release"
*   heroku create project-name
*   git push heroku master

-   Vào settings, chọn Reveal Config Vars
    -- APP_NAME -> Laravel
    -- APP_ENV -> production
    -- APP_KEY -> app_key
    -- APP_DEBUG -> true
    -- APP_URL -> link_of_app

## Config database

-   Vào phần Add-ons, tìm kiếm "Heroku Postgres", chọn cái đầu tiên, hiện lên một form, rồi xác nhận.

*

# Deploy to heroku from git

## Requirements

-   Install heroku CLI
-   Login account heroku by your teminal by enter "heroku login" in your terminal
-   In your source code git, you must have file Procfile in your main laravel directory
    with line code "web: vendor/bin/heroku-php-apache2 public/"

## Way to deploy

-   Open terminal

*   heroku create project-name
*   git push heroku master
    -- Vào settings, chọn Reveal Config Vars
    --- APP_NAME -> Laravel
    --- APP_ENV -> production
    --- APP_KEY -> app_key
    --- APP_DEBUG -> true
    --- APP_URL -> link_of_app

## Config database

-   Vào phần Add-ons, tìm kiếm "Heroku Postgres", chọn cái đầu tiên, hiện lên một form, rồi xác nhận.

*   heroku pg:credentials:url

-   Bắt đầu config các thông tin database
    -- heroku config:add DB_CONNECTION=pgsql
    -- heroku config:add DB_HOST= ....com
    -- heroku config:add DB_PORT=...
    -- heroku config:add DB_DATABASE= ...dbname
    -- heroku config:add DB_USERNAME= ...user
    -- heroku config:add DB_PASSWORD= ...password

*   heroku run composer update
*   heroku run php artisan db:wipe // delete all tables in project
*   heroku run composer require laravel/passport "~9.0"
*   heroku run php artisan migrate
*   heroku run php artisan passport:install --force
*   heroku run php artisan db:seed
