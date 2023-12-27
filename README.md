# Open Source CRM and Automation tool, using Laravel and Filament.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/azzarip/teavel.svg?style=flat-square)](https://packagist.org/packages/azzarip/teavel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/azzarip/teavel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/azzarip/teavel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/azzarip/teavel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/azzarip/teavel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/azzarip/teavel.svg?style=flat-square)](https://packagist.org/packages/azzarip/teavel)



Open Source CRM and Automation Tool for handling landing page forms and contacts with possible leads and clients. 

## Installation

You can install the package via composer:

```bash
composer require azzarip/teavel
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="teavel-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="teavel-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="teavel-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$teavel = new Azzarip\Teavel();
echo $teavel->echoPhrase('Hello, Azzarip!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Paride Azzari](https://github.com/azzarip)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
