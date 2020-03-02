## DEVELOPMENT ENVIRONMENT
<ul>
    <li>PHP 7.2.20</li>
    <li>MYSQL 5.0.12</li>
    <li>Symfony 5 </li>
    <li>Webpack </li> 
    <li>MAMP environment **local**</li>
</ul>

## PROJECT INSTALLATION

Clone Repo to your ```htodcs``` if you are using MAMP. 
```genericsql
git clone https://github.com/HtunHtunHtet/pomelopay.git
```

Change directory to the file and update database credential from .env file I am using port 8889 for database. ``APP_ENV=dev`` for development build and ``APP_ENV=prod`` for production build
```.dotenv
APP_ENV=dev
APP_SECRET=c6a89ef3f65c346ebc93aca6908e8a62
DATABASE_URL=mysql://root:root@127.0.0.1:8889/pomelopay?serverVersion=5.7
```


install composer
```composer log
composer install
```

install yarn 
```yarn
yarn install
```

5) 


3) phpunit test =>  ./bin/phpunit


http://pomelo.htunhtunhtet.me