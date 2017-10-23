# ZFAPP

## Introduction

Application requires Apache, PHP and MySQL to be installed on the system.

Zend Framework 3 i18n module used by the application requires PHP-intl extension. To enable the extension:

1. Go to /your/php/installation/path/
2. Edit php.ini
3. Uncomment ;extension=php_intl.dll by removing preceeding semicolon.

## Installation of database

The repository contains zfapp.sql which is required to be imported into zfapp database for the applcation to run;

To import zfapp.sql using MySQL console tools:

1. Go to /your/installation/path/to/mysql/bin/
2. Execute command (replacing [user], [password], [database] with your real database credentials):
mysql --user=[user] --password=[password] [database] < zfapp.sql
3. Navigate to /zfapp/config/autoload/global.php for application database configuration and make changes if necessary

## Cloning the repository using GIT
1. Go to your Apache document root folder 
2. Execute:
git clone https://github.com/codeapply/zfapp.git

This will create zfapp folder and clone the repository.

## Installation of Zend Framework dependencies using Composer

Go to youd document root /zfapp/ 
To install all Zend Framework dependencies and dump autoload configuration run in console:

```bash
$ composer install
```

Once installed, you can test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/install
$ php -S 0.0.0.0:8080 -t public/ public/index.php
# OR use the composer alias:
$ composer serve
```

Open web browser and go to http://localhost:8080

## Web server setup

### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

```apache
<VirtualHost *:80>
    ServerName zfapp.localhost
    DocumentRoot /path/to/zfapp/public
    <Directory /path/to/zfapp/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_authz_core.c>
        Require all granted
        </IfModule>
    </Directory>
</VirtualHost>
```
