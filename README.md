# Modus Create Development Assignment
*Created by Romario Ramirez.*

## Prerequisites
Created with:
* **PHP 7.2.11**
* **Laravel 5.7**

## Installation & Running
*In order to correctly install and run this project, type the following on the terminal.*
* git clone https://github.com/romrz/modus-create-development-assignment.git
* cd modus-create-development-assignment
* composer install
* cp .env.example .env
* php artisan key:generate
* php artisan serve --host=localhost --port=8080 *(Starts the server on the url: http://localhost:8080)*

## Important Files
The only relevant files to this particular assignment are the following:
* app/Http/Controllers/**VehiclesController.php**. This takes care of responding to the request and providing the appropiate response.
* app/Transformers/**VehicleTransformer.php**. This is used to transform the data coming from the external API into the appropiate format for this particular assignment.
* app/**VehicleClient.php**. This is the API client used to communicate and retrieve the information from the external API.
* tests/Feature/**VehiclesTest.php**. This is where all the tests for this project reside.

## Testing
Once the project is cloned and configured. Just run **phpunit** from the root of the project to run all the tests.

## External Packages
* **GuzzleHttp**. This is used for performing request to external APIs.