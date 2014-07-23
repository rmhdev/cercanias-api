# Cercanias API

Access Renfe's Cercanias information through a HTTP REST API.

[![Build Status](https://travis-ci.org/rmhdev/cercanias-api.svg?branch=master)](https://travis-ci.org/rmhdev/cercanias-api)

## Requirements

The `cercanias-api` project is built using [Silex][], and has the following requirements:

- `PHP 5.3+`
- A `HTTP` server. `Silex` has more information about [how to configure the server][].

## Installation

The easiest way to install it is to clone the repository:

```
git clone https://github.com/rmhdev/cercanias-api
```

After that you'll need to install [Composer][]:

```bash
curl -sS https://getcomposer.org/installer | php
```

Finally, you'll be able to retrieve all the dependencies:

```bash
php ./composer.phar install
```

If you are installing this project in a public server, make sure that:

- the document root points to the `cercanias-api/web/` directory.
- `cercanias-api/web/index_dev.php` is deleted.
- folders in `cercanias-api/var/` must be writable by the web server.

## Play with the API

If you are using PHP 5.4+, it's built-in webserver will help you to play with this project. Just type:

```bash
php -S localhost:8080 -t web web/index.php
```

Easy, right? Just open a browser and enter `http://localhost:8080`

## API requests

```
GET -> http://localhost:8080
GET -> http://localhost:8080/route
GET -> http://localhost:8080/route/{routeId}
GET -> http://localhost:8080/timetable/{routeId}/{departureId}/{destinationId}/{date}
```

## API responses

Index url: `GET -> http://localhost:8080`

```json
{
    "routes_url": "http://localhost:8080/route",
    "route_url": "http://localhost:8080/route/{routeId}",
    "timetable_url": "http://localhost:8080/timetable/{routeId}/{departureId}/{destinationId}/{date}"
}
```

Routes url: `GET -> http://localhost:8080/route`

```json
{
    "routes": [
        {
            "id": 20,
            "name": "Asturias",
            "route_url": "http://localhost:8080/route/20"
        },
        ...
    ]
}
```

Route url: `GET -> http://localhost:8080/route/61`

```json
{
    "id": "61",
    "name": "San Sebastián",
    "url": "http://localhost:8080/route/61",
    "stations": [
        {
            "id": "11409",
            "name": "Alegia de Oria",
            "route_id": "61"
        },
        ...
    ]
}
```

Timetable url: `GET -> http://localhost:8080/timetable/61/11305/11600/2014-07-23`

```json
{
    "departure": {
        "id": "11305",
        "name": "Brincola",
        "route_id": "61"
    },
    "destination": {
        "id": "11600",
        "name": "Irun",
        "route_id": "61"
    },
    "transfer": [],
    "trips": [
        {
            "line": "c1",
            "departure": "2014-07-23T05:53:00+02:00",
            "arrival": "2014-07-23T07:23:00+02:00",
            "transfers": []
        },
        ...
    ],
    "date": "2014-07-23T00:00:00+02:00",
    "return_url": "http://localhost:8080/timetable/61/11600/11305/2014-07-23",
    "route_url": "http://localhost:8080/route/61"
}
```

[Silex]: http://silex.sensiolabs.org/
[how to configure the server]: http://silex.sensiolabs.org/doc/web_servers.html
[Composer]: https://getcomposer.org/
