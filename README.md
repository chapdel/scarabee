# Laravel Free Ray debugger alternative.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/chapdel/scarabee.svg?style=flat-square)](https://packagist.org/packages/chapdel/scarabee)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/chapdel/scarabee/run-tests?label=tests)](https://github.com/chapdel/scarabee/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/chapdel/scarabee/Check%20&%20fix%20styling?label=code%20style)](https://github.com/chapdel/scarabee/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/chapdel/scarabee.svg?style=flat-square)](https://packagist.org/packages/chapdel/scarabee)

## Installation

You can install the package via composer:

```bash
composer require chapdel/scarabee
```

To publish the config file, run:

```bash
php artisan vendor:publish --provider="Chapdel\Scarabee\ScarabeeServiceProvider" --tag="scarabee-config"
```

This is the contents of the published config file:

```php
return [
    'enable' => env('SCARABEE_ENABLE', true),
    'port' => env('SCARABEE_PORT', 5050),
    'url' => env('SCARABEE_URL', 'http://localhost'),
];
```

## Usage

```php
// Dump a variable
scarabee(["name" => "chapdel"]);

// Dump models
scarabee()->model(User::find(1));

// Start dump queries
scarabee()->showQueries();

// Stop dump queries
scarabee()->stopShowingQueries();

// Dump mails
scarabee()->mail(new TestMail());
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Chapdel KAMGA](https://github.com/chapdel)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
