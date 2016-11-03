# PictureThis
CECS343 Project - web application for image hosting and simple editing/drawing

## Installation
Feel free to fork the repository if you'd like to work with us.

### Pre-requisites
* PHP 7.0 -- Click [here](http://php.net/downloads.php) and download the suitable version for your system.
[Here](https://www.sitepoint.com/how-to-install-php-on-windows/) is a good tutorial for Windows.
* Composer -- Click [here](https://getcomposer.org/) to get Composer.
* MySQL -- Click [here](https://www.mysql.com/downloads/) to get the MySQL server.

### Setup
Install the necessary libraries with Composer.
```
cd ..\path_to_project\
composer install
```

Configure your MySQL database and start it.
```yml
# ..\app\config\parameters.yml
# Example configuration
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
