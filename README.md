# Tata Steel Sailing Club Website

## About

This is a Laminas MVC website built for the Tata Steel Sailing Club, which comes with a database, web server, and phpmyadmin.

The website makes external API calls to [ReCaptcha](http://www.google.com/recaptcha/about), [WeatherApi](http://www.weatherapi.com), and [Google Maps](http://developers.google.com/maps/documentation/javascript/get-api-key). API keys will need to be obtained for these services.

## Installing with Docker

The easiest way to build the project and ensure all dependencies are taken care of is to use [Docker](https://www.docker.com/).

A `docker-compose.yaml` file is provided for use with
[docker-compose](https://docs.docker.com/compose/); it
uses the provided `Dockerfile` to build a docker image 
for the `tata_web` container created with `docker-compose`.

Build and start the image and container using:

```bash
$ git clone https://github.com/RhydianJenkins/MVCWebsite.git path/to/install
$ cd path/to/install
$ docker-compose --env-file ./.env up -d --build
```

At this point, you can visit http://localhost:80 to see the site running.

`docker-compose` will also install a [phpmyadmin](https://www.phpmyadmin.net/) client and host it at http://localhost:8080, a mySQL database, and a mailing server.

Environment variables such as usernames, passwords, and container names can be customised in the provided `.env` file.

You can also run commands such as `composer` in the container.  The container 
environment is named "tata_web" so you will pass that value to 
`docker-compose run`:

```bash
$ docker-compose run tata_web composer install
```

## Installing with Composer

The project can be built using [Composer](https://getcomposer.org/). If you don't have it already installed, then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

To create your new project:

```bash
$ composer create-project -sdev tata-website/tata-steel-sailing path/to/install
```

Once installed, you can test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/install
$ php -S 0.0.0.0:8080 -t public
# OR use the composer alias:
$ composer run --timeout 0 serve
```

This will start the cli-server on port 8080, and bind it to all network
interfaces. You can then visit the site at http://localhost:8080/.

**Note:** The built-in CLI server is *for development only*.

## Database Connections and API Keystores

Database adapter settings and API keystores are not version controlled, and therefore need to be manually added to the `config/autoload/global.php` configuration file. It is recommended that a new `config/autoload/local.php` file is created containing sensitive information that you do not want to version control. See the [Laminas Docs](https://docs.laminas.dev/laminas-config/intro/) for adding a new configuration file.

After the changes, the resultant project directory should look something like:

```bash
project
│   README.md
│   ...
│
└───config
│   └───autoload
│       │   global.php
│       │   local.php   # add this new file containing sensitive information
│       │   ...
```

## Apache Setup

If building from source, you may need to setup apache. To do this, setup a virtual host to point to the `public/` directory of the project and you should be ready to go! It should look something like below:

```apache
<VirtualHost *:80>
    ServerName website.localhost
    DocumentRoot /path/to/install/public
    <Directory /path/to/install/public>
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

## Credit

The project was originally built from the [Laminas Skeleton](https://github.com/laminas/laminas-mvc-skeleton).
