# Cercanias API

Access Renfe's Cercanias information through a HTTP REST API.

[![Build Status](https://travis-ci.org/rmhdev/cercanias-api.svg?branch=master)](https://travis-ci.org/rmhdev/cercanias-api)

## Requirements

The `cercanias-api` project has the following requirements:

- `PHP 5.3+`
- A `HTTP` server (Apache, nginx, ...)

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

### Configure the server

This project is built using [Silex][].
The official docs will give you more information about [how to configure your server][].

If you are installing this project in a public server, make sure that:

- the **document root** points to the `cercanias-api/web/` directory.
- folders in `cercanias-api/var/` must be **writable** by the web server.

## Play with the API

If you are using PHP 5.4+, its built-in web server will help you to play with this project:

```bash
php -S localhost:8080 -t web web/index.php
```

Easy, right? Just open a browser and enter `http://localhost:8080`

## API requests

Index urls:

```
GET -> http://localhost:8080
```

Retrieve all the routes:

```
GET -> http://localhost:8080/route
```

Retrieve the stations from a route:

```
GET -> http://localhost:8080/route/{routeId}
```

Retrieve the timetable for a query:

```
GET -> http://localhost:8080/timetable/{routeId}/{departureId}/{destinationId}/{date}
```

**Information about the parameters:**

- `{routeId}`: (string) route id. For example, Madrid is `10`.
- `{departureId}` and `{destinationId}`: (string) station id. For example, Oviedo is `15211`.
- `{date}`: (string). Read more about [accepted date formats][]. For example, `2014-07-25`, `today`, `tomorrow`, etc.

## API responses

### Index url

```
GET -> http://localhost:8080
```

```json
{
    "routes_url": "http://localhost:8080/route",
    "route_url": "http://localhost:8080/route/{routeId}",
    "timetable_url": "http://localhost:8080/timetable/{routeId}/{fromId}/{toId}/{date}"
}
```

### Routes url

```
GET -> http://localhost:8080/route
```

```json
{
    "routes": [
        {
            "id": 20,
            "name": "Asturias",
            "route_url": "http://localhost:8080/route/20"
        },
        // ...
    ]
}
```

### Route url

```
GET -> http://localhost:8080/route/61
```

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
        // ...
    ]
}
```

### Timetable url

```
GET -> http://localhost:8080/timetable/61/11305/11600/2014-07-23
```

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
    "transfer": false,
    "trips": [
        {
            "line": "c1",
            "departure": "2014-07-23T05:53:00+02:00",
            "arrival": "2014-07-23T07:23:00+02:00",
            "transfers": []
        },
        // ...
    ],
    "date": "2014-07-23T00:00:00+02:00",
    "return_url": "http://localhost:8080/timetable/61/11600/11305/2014-07-23",
    "route_url": "http://localhost:8080/route/61"
}
```

Similar response, but with transfer trains:

```
GET -> http://localhost:8080/timetable/50/79600/71802/2014-07-23
```

```json
{
    "departure": {
        "id": "79600",
        "name": "Arenys de Mar",
        "route_id": "50"
    },
    "destination": {
        "id": "71802",
        "name": "Barcelona-Passeig de Gràcia",
        "route_id": "50"
    },
    "transfer": {
        "id": "",
        "name": "Barcelona-El Clot-Aragò",
        "route_id": "50"
    },
    "trips": [
        {
            "line": "r1",
            "departure": "2014-07-23T05:59:00+02:00",
            "arrival": "2014-07-23T06:49:00+02:00",
            "transfers": [
                {
                    "line": "r2",
                    "departure": "2014-07-23T06:56:00+02:00",
                    "arrival": "2014-07-23T07:01:00+02:00"
                },
                {
                    "line": "r2",
                    "departure": "2014-07-23T07:10:00+02:00",
                    "arrival": "2014-07-23T07:15:00+02:00"
                }
            ]
        },
        // ...
    ], 
    "date": "2014-07-23T00:00:00+02:00", 
    "return_url": "http://localhost:8080/timetable/50/71802/79600/2014-07-23", 
    "route_url": "http://localhost:8080/route/50"
}
```

[Silex]: http://silex.sensiolabs.org/
[how to configure your server]: http://silex.sensiolabs.org/doc/web_servers.html
[Composer]: https://getcomposer.org/
[accepted date formats]: http://php.net/manual/en/datetime.formats.date.php
