# Backend part

It's an application created with PHP Laravel 9 framework as Backend part of the project. 

[Frontend part](https://github.com/BrigitaGrybaiteBartke/FE.git) of the project is created with JavaScript React library. 

To run the project Frontend and Backend parts of the projects must be started.

#### Project is created with:
* React library as frontent part
* Laravel 9 framework as backend part
* MySQL

#### Functionality
* User registration and login
* Registered users can create, update and delete content: posts
* Image upload is available
* Registered users can comment a post
* Each logged-in user has their own dashboard, where post management is available
* Page content preview does not require user login

## Project launch steps
* Clone repository:
```
git clone https://github.com/BrigitaGrybaiteBartke/BE.git
```
* Run XAMPP and Mysql database
* Open XAMPP htdocs folder - clone application code to this folder
* Install Composer locally in the current directory
* Create schema named **laravel** in MySQL Workbench
* Once opened cloned app folder with source-code editor run this command in terminal: 
```
php composer.phar install
```
* Change .envexample name to .env
* Run migrations and seeders:
```
php artisan migrate
php artisan db:seed
```
* To start the project
```
php artisan serve
```
