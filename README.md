# Laravel Package for accessing the metals-api.com api

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kenzal/metals-api.svg?style=flat-square)](https://packagist.org/packages/kenzal/metals-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kenzal/metals-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kenzal/metals-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kenzal/metals-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kenzal/metals-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kenzal/metals-api.svg?style=flat-square)](https://packagist.org/packages/kenzal/metals-api)

A laravel package for accessing the api at https://metals-api.com/

## Requirements

In order to use this package, you will need an account with [Metals-API.com](https://metals-api.com/) as this is just a 
wrapper for their service. Please note that all requests count towards a monthly quota determined by your account level.


## Installation

You can install the package via composer:

```bash
composer require kenzal/metals-api
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="metals-api-config"
```

This is the contents of the published config file:

```php
return [
    'access_key' => env('METALS_API_ACCESS_KEY'),
    'host'       => env('METALS_API_HOST', 'https://metals-api.com'),
    'port'       => env('METALS_API_PORT', null),
    'base'       => env('METALS_API_BASE', 'USD'),
    'symbols'    => env('METALS_API_SYMBOLS', null),
];
```

## Usage

```php
$metalsApi = new Kenzal\MetalsApi($config);
echo $metalsApi->latest(symbols:['XAG','XAU'], base:'USD');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Kenzal Hunter](https://github.com/kenzal)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
