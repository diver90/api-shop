## Follow the next steps to deploy the application:

1. Clone it into your project directory from GitHub repository:

```sh
git clone https://github.com/diver90/api-shop.git
```

2. Go in the project directory. Edit _.env_ file, if you need bind another ports or change other variable, and run docker-compose:

```sh
docker-compose --env-file .env -f ./docker/docker-compose.yml build
```

3. After successful installation run docker containers:

```sh
docker-compose --env-file .env -f ./docker/docker-compose.yml up -d
```

4. Then you have to go in php-fpm container console:

```sh
docker exec -it docker-php-fpm bash
```
5. Inside container run composer install and apply migrations:
```sh
composer install
php bin/console doctrine:migrations:migrate
```

That's all, now you can go to http://localhost:8888/api and see api documentation 