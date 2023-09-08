<h1 align="center">OpenWallet</h1>

<p align="center">
    <a href="https://laravel.com/"><img src="https://img.shields.io/badge/Laravel-10-FF2D20.svg?style=flat-square&logo=laravel" alt="Laravel 10"/></a>
    <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-^8.1-777BB4.svg?style=flat-square&logo=php" alt="PHP ^8.1"/></a>
    <a href="https://www.docker.com/"><img src="https://img.shields.io/badge/docker-3-2496ED.svg?style=flat-square&logo=docker" alt="Docker"/></a>
</p>

## Project Structure

### Src

`src` is for "Source". Here we put all our code base being as independent as possible of any implementation (except `infrastructure` sub-folder).

The main idea is to use this as our **pure** code, with no vendor, just domain logic.

### Bounded Contexts

**UserAccess:** Where the main functionality is implemented for the User Access scope. Registration, authentication, authorization etc...

**Shared:** Where the shared domain and application logic is implemented. Also contains support classes to infrastructure.

```bash
$ tree -L 2 src

src
├── Shared
│   ├── Domain
│   ├── Infrastructure
│   └── Interface
└── UserAccess
    ├── Application
    ├── Domain
    ├── Infrastructure
    └── Interface
```

### Repository Pattern

In current implementation, our repositories try to be as simple as possible.

### CQRS

`Symfony Messenger` has been used to implement commands, queries and domain events.

### Functional Programming

`phunctional` has been used for some HoF in the bus implementation.

## Installation

```bash
$ git clone git@github.com:erayaydin/open-wallet.git
$ docker run --rm \
    --pull=always \
    -v "$(pwd)":/opt \
    -w /opt \
    laravelsail/php82-composer:latest \
    bash -c "composer install"
$ sail up -d
$ sail artisan key:generate
$ sail artisan migrate
```
