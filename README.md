# PictureThis
PictureThis! is a group project for the CECS343 Software Engineering class at CSULB. It is a web application for image hosting and simple editing/drawing. It allows users to create and share their images with the rest of the world through the use of tags.

## Design
PictureThis! uses [Symfony3](https://symfony.com/) for its back-end and relies on img.ly's [PhotoEditorSDK](https://www.photoeditorsdk.com/) for its image processing. It uses [Twig](http://twig.sensiolabs.org/) as its templating engine in PHP with default Twitter [Bootstrap3](https://getbootstrap.com) elements. It mainly uses [Doctrine](http://www.doctrine-project.org/) to map given entities to tables in our [MySQL](https://www.mysql.com/) database. 

## Installation
This installation tutorial is to setup a development environment using PHP7's webserver. To see an installation tutorial for a production environment using Apache, click [here](https://github.com/littledieper/PictureThis/blob/apache/README.md).
### Pre-requisites
* PHP 7.0 -- Click [here](http://php.net/downloads.php) and download the suitable version for your system.
[Here](https://www.sitepoint.com/how-to-install-php-on-windows/) is a good tutorial for Windows.
* Composer -- Click [here](https://getcomposer.org/) to get Composer.
* MySQL -- Click [here](https://www.mysql.com/downloads/) to get the MySQL server.

Since we are primarily developing this software on Windows using PHP 7's built in web-server, we cannot guarantee other installation methods.

### Setup
Download the project from GitHub or clone it for yourself.
For PHP, we enabled the curl, fileinfo, gd2, mysqli, openssl, and pdo_mysql Windows extensions in the php.ini. 
For curl, we used the cacert.pem from cURL [here](https://curl.haxx.se/ca/cacert.pem).

Install the necessary libraries with Composer.
```
cd ..\path_to_project\
composer install
```
During installation with Composer, you will be asked to input database data. You may use the local database on your computer.
```
# You can find the parameters file in ...\app\config\parameters.yml	
# Example information
parameters:
    database_host: 127.0.0.1
    database_port: 3306
    database_name: picturethis
    database_user: user
    database_password: password
```

Start the built-in PHP webserver.
```
cd ..\path_to_project\
php bin/console server:run
```
Open your favorite web browser and navigate to ```localhost:8000```.
