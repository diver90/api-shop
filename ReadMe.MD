## Overview

This project is a small REST API for e-shop core engine, builded on API Platform framework(based on Symfony).
The main idea of this engine is that it contains one database of products that can be sold
in different e-shops (for example in different countries - products will be the same,
their price without VAT is constant, but their VAT rates will be different in different countries)
that run upon our core engine and database. So basically we implemented "super" backend 
which will be contacted by those different e-shop backends.

## Example
We have products 'bread' that costs 10 and 'wine' that costs 50, we have eshop in
England (VAT rates are 7% for food and 15% for alcohol) and another eshop in France
(VAT rates are 5% for food and 12% for alcohol).
In English eshop we will find
bread for 10 + (10x7%)
wine for 50 + (50x15%)
In French eshop we will find
bread for 10 + (10x5%)
wine for 50 + (50x12%)

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
