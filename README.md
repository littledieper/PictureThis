# PictureThis Apache Configuration

This tutorial is loosely based on DigitalOcean's tutorial which you can find [here](https://www.digitalocean.com/community/tutorials/how-to-deploy-a-symfony-application-to-production-on-ubuntu-14-04), but is updated to modern versions and is tailored for this project. It will have a lot of steps, so be patient.

## Prerequisites
* A server with a fresh installation of Ubuntu (or other linux-based server). I tested on Ubuntu Server 16.04.
* A non-root user and a user with sudo privileges.

### Setting up the LAMP stack
If you already have the LAMP stack setup (Linux, Apache2, MySQL, and PHP) setup, you can skip to [installation](#installation). Run ```sudo apt-get update``` to get an updated list of available packages.

Install components for Apache2.
```sudo apt-get install apache2 libapache-mod-php7.0```

We will need to change the way Apache handles files to put PHP first.
Run ```sudo nano /etc/apache2/mods-enabled/dir.conf ```
Edit the contents of the file to look like this:
```
<IfModule mod_dir.c>
    DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm
</IfModule>
```


Install components for MySQL. Run ```sudo apt-get install mysql-server php7.0-mysql```. 
You will be asked to set the password for the root user.

Install components for PHP. We will need the cli, curl, and xml PHP packages for Symfony installation.
Run ```sudo apt-get install php7.0 php7.0-cli php7.0-curl php7.0-xml```.


## Setting up the Application
We will need to install packages to be able to install the application. We use git to recieve the code from GitHub, acl to control file privleges, and composer to install the necessary bundles from Symfony. Run ```sudo apt-get install git acl composer```.

Again, we will need to configure some items. This time we will configure our MySQL database to handle UTF8 unicode characters. Run ```sudo nano /etc/mysql/my.cnf```.
Navigate to the [mysqld] block (create it if it's not there) and add the collation-server and character-set-server options.
```
[mysqld]
collation-server     = utf8mb4_general_ci # Replaces utf8_general_ci
character-set-server = utf8mb4            # Replaces utf8
```
Restart MySQL by running ```sudo service mysql restart```.

### Create a MySQL user
Access the MySQL server using the root password by running ```mysql -u root -p``` and entering in the password.

* Create the database by running ```mysql > create database picturethis;```
* Create the user by running (change the password...) ``` mysql > create user 'picturethis-user'@'localhost' identified by 'password';```
* Grant privileges to the user by running ``` mysql > GRANT ALL PRIVILEGES ON picturethis.* TO 'picturethis-user'@'localhost'; ```
* Flush privileges by running ```mysql > flush privileges;``` and quit by typing in ```mysql > quit```.

You can test to see if it works by logging into the user by running ```mysql -u picturethis-user -p``` and running ```mysql > show databases;```. If picturethis shows up, everything works. Type ```mysql > quit``` to exit.

### Getting the application code.
First, create the directory in which the application will be stored. Run ```sudo mkdir -p /var/www/picturethis```.

We will need to give file permissions to the user that you are on right now. Replace "default" with your username. Run ```sudo chown default:default /var/www/picturethis```. 

Move to the parent directory and clone the application. Please note: this may take awhile as we are also grabbing base database photos and data.
```
cd /var/www
git clone https://github.com/littledieper/picturethis.git --branch apache
```

### Fixing folder permissions with ACL
The webserver will also need to read and write to the files located in the project directory, so we will be adding permissions using ACL.
We will give read and execute permissions on the entire project directory. Run ```sudo setfacl -R -m u:www-data:rX picturethis```.

We will need to give read, write, and execute permissions on the log and cache directories and any files that it will need to create.  Run
```
sudo setfacl -R -m u:www-data:rwX picturethis/var/cache picturethis/var/logs
sudo setfacl -dR -m u:www-data:rwX picturethis/var/cache picturethis/var/logs
```

You can check if you did it correctly by running ``` getfacl picturethis/var/cache```. The output should look similar to this:
```
# file: picturethis/var/cache
# owner: default
# group: default
user::rwx
user:www-data:rwx
group::rwx
mask::rwx
other::r-x
default:user::rwx
default:user:www-data:rwx
default:group::rwx
default:mask::rwx
default:other::r-x
```

### Actually setting up the application.
Because we are running on a full web-server and not PHP's built-in webserver, we will need to edit some environment variables that tells Symfony we're running on a production environment.
Run ``` export SYMFONY_ENV=prod```

Now, we will need to install the bundles in our Symfony project. We will do this through Composer. Run:
```
cd picturethis
composer install --no-dev --optimize-autoloader
```
During installation, you will be asked to setup your MySQL server. You should have set up these values when you set up the MySQL server earlier. It should look something like this:
```
Creating the "app/config/parameters.yml" file
Some parameters are missing. Please provide them.
database_host (127.0.0.1): 
database_port (null): 
database_name (symfony): picturethis
database_user (root): picturethis-user
database_password (null): password
. . .
```

You can check to see if everything is OK by running ``` php bin/console doctrine:schema:validate```. 
```
Output
[Mapping]  OK - The mapping files are correct.
[Database] FAIL - The database schema is not in sync with the current mapping file.
```
This is OK. We will create update the database using Doctrine. Run ```php bin/console doctrine:schema:create```.
```
Output
ATTENTION: This operation should not be executed in a production environment.

Creating database schema...
Database schema created successfully!
```
Although it isn't the best way, we can now fill our database with the default values we grabbed from GitHub. Run:
```
mysql -u picturethis-user -p picturethis < /var/www/picturethis/sql/data.sql
```

Clear the cache by running ```php bin/console cache:clear --env=prod --no-debug```.

### Setting up Apache2 (last step!)
We will need to set the time zone for our application. Run ```sudo nano /etc/php/7.0/apache2/php.ini```.

Find the [Date] block and change the time zone to your area. 
```
[Date]
; Defines the default timezone used by the date functions
; http://php.net/date.timezone
date.timezone = America/Los_Angeles
```

Next, we will need to setup the website configuration. First, we will back up the original one and create a new one. Run:
```
cd /etc/apache2/sites-available
sudo mv 000-default.conf default-bkp.conf
sudo nano /etc/apache2/sites-available/000-default.conf
```
Paste the following code into the new ```000-default.conf``` file.
```
<VirtualHost *:80>

   		DocumentRoot /var/www/picturethis/web
   		<Directory /var/www/picturethis/web>
        		AllowOverride All
        		Require all granted
        		Allow from All

        		<IfModule mod_rewrite.c>
            			Options -MultiViews
            			RewriteEngine On
            			RewriteCond %{REQUEST_FILENAME} !-f
            			RewriteRule ^(.*)$ app.php [QSA,L]
       			</IfModule>
    		</Directory>

    		ErrorLog /var/log/apache2/symfony_error.log
    		CustomLog /var/log/apache2/symfony_access.log combined
</VirtualHost>
```

If you're using a domain name to access your server instead of just the IP address, you can optionally define the ServerName and ServerAlias values, as shown below. If not, you can omit them.
```
<VirtualHost *:80>
    ServerName example.com
    ServerAlias www.example.com

    DocumentRoot /var/www/picturethis/web
. . .
```

Lastly, enable the rewrite module for Apache by running ```sudo a2enmod rewrite``` and restart the Apache server to apply changes by running ```sudo service apache2 restart```.

# Done!
You can access your application by going to ```http://your_server_ip``` in your browser.
