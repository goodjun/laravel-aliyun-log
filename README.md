Laravel Aliyun Log
==============================

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

## Installation

Require this package with composer.

``` bash
composer require goodjun/laravel-aliyun-log
```

### Laravel without auto-discovery:

If you don't use auto-discovery, add the ServiceProvider to the providers array in `config/app.php`

``` php
Goodjun\AliyunLog\AliyunLogProvider::class,
```

#### Copy the package config to your local config with the publish command:

``` bash
php artisan vendor:publish  --provider="Goodjun\AliyunLog\AliyunLogProvider"
```

## Configuration

Add your Aliyun Access Key, Key Secret, Endpoint, Project Name and Store Name to your `.env`:

```dotenv
ALIYUN_LOG_ACCESS_KEY_ID= # access key id
ALIYUN_LOG_ACCESS_KEY_SECRET= # access key secret
ALIYUN_LOG_ENDPOINT= # endpoint, reference https://help.aliyun.com/document_detail/29008.html
ALIYUN_LOG_PROJECT= # project name
ALIYUN_LOG_LOG_STORE= # store name
```

## Usage

### Laravel <= 5.5

Copy code in the `bootstrap/app.php`:

```php
$app->configureMonologUsing(function (Monolog\Logger $monolog) {
    $handler = new Goodjun\AliyunHandler();
    $monolog->pushHandler($handler);
});
```

[ico-version]: https://img.shields.io/packagist/v/goodjun/laravel-aliyun-log.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/goodjun/laravel-aliyun-log.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/goodjun/laravel-aliyun-log
[link-downloads]: https://packagist.org/packages/goodjun/laravel-aliyun-log
[link-author]: https://github.com/goodjun
[link-contributors]: ../../contributors