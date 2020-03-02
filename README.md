## DEVELOPMENT ENVIRONMENT
<ul>
    <li>PHP 7.2.20</li>
    <li>MYSQL 5.0.12</li>
    <li>Symfony 5 </li>
    <li>Webpack </li> 
    <li>MAMP environment **local**</li>
</ul>

## PROJECT INSTALLATION

* Clone Repo to your ```htodcs``` if you are using MAMP. 
```genericsql
git clone https://github.com/HtunHtunHtet/pomelopay.git
```

* Change directory to the file and update database credential from .env file I am using port 8889 for database. ``APP_ENV=dev`` for development build and ``APP_ENV=prod`` for production build
```.dotenv
APP_ENV=dev
APP_SECRET=c6a89ef3f65c346ebc93aca6908e8a62
DATABASE_URL=mysql://root:root@127.0.0.1:8889/pomelopay?serverVersion=5.7
```


* install composer
```composer log
composer install
```

* install yarn 
```yarn
yarn install
```

* build yarn

```
yarn watch <= (development build) 
yarn build <= (porduction build) 
```

* build database 

````
php bin/console doctrine:database:create
````

* build schema

```
php bin/console doctrine:schema:create
```

* if you want to update schema , use
```
php bin/console doctrine:schema:update --force

```

* Generate Fixtures.It will pre-load the data. 

```genericsql
php bin/console doctrine:fixtures:load
```

* you can setup the symfony local webserver by following this 
[steps](https://symfony.com/doc/current/setup/symfony_server.html) if you are willning to use build in symfony server.

* For my particular preference, I register my symfony application inside Mamp/conf/httpd.conf as follow :

```genericsql
# This is the configuration for POMELOPAY project
Listen *:8706
<VirtualHost *:8706>
    DocumentRoot /Applications/MAMP/htdocs/pomelopay/public
    DirectoryIndex index.php
    <Directory "/Applications/MAMP/htdocs/pomelopay/public">
        FallbackResource /index.php
        AllowOverride All
        Allow from All
				SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1
    </Directory>
</VirtualHost>
#END OF POMELOPAY
```

* head over to ``http://localhost:8706/`` to start using apps.

* Login credentials are as follow. You can check the credentials inside ``src/DataFixtures/UserFixtuers.php`` as well.

```genericsql
username: ryanhhh91@gmail.com
password: ryan123

username :simon@pomelopay.com
password : simon123
```


##PHP UINT TESTING

3) phpunit test =>  ./bin/phpunit


http://pomelo.htunhtunhtet.me