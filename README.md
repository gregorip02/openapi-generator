# Laravel openapi generator 📘

[![Latest Stable Version](https://poser.pugx.org/gregorip02/openapi-generator/v)](//packagist.org/packages/gregorip02/openapi-generator)
[![License](https://poser.pugx.org/gregorip02/openapi-generator/license)](//packagist.org/packages/gregorip02/openapi-generator)
[![Total Downloads](https://poser.pugx.org/gregorip02/openapi-generator/downloads)](//packagist.org/packages/gregorip02/openapi-generator)
[![Tests](https://github.com/gregorip02/openapi-generator/actions/workflows/tests.yml/badge.svg)](https://github.com/gregorip02/openapi-generator/actions)

This package helps you with the automatic generation of the file with the .yml extension that contains the OpenAPI specification of your registered routes.

## Installation

You can install the package via composer:

```bash
composer require gregorip02/openapi-generator
```

## Usage

Publish the package configuration file.

``` php
php artisan vendor:publish --provider="OpenapiGenerator\OpenapiGeneratorServiceProvider"
```

Generate your `openapi.yaml` file.

```bash
php artisan openapi:generate
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email gregori.pineres02@gmail.com instead of using the issue tracker.

## Credits

- [Gregori Piñeres](https://github.com/gregorip02)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
