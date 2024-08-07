# Laravel Speculation Rules API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/innoge/laravel-speculation-rules-api.svg?style=flat-square)](https://packagist.org/packages/innoge/laravel-speculation-rules-api)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/innoge/laravel-speculation-rules-api/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/innoge/laravel-speculation-rules-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/innoge/laravel-speculation-rules-api/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/innoge/laravel-speculation-rules-api/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/innoge/laravel-speculation-rules-api.svg?style=flat-square)](https://packagist.org/packages/innoge/laravel-speculation-rules-api)

This Laravel package provides a streamlined solution to utilize the speculation rules api, allowing you to speed up your website performance significantly.

> [!NOTE]
> The Speculation Rules API is a experimental technology. Further information can be found at the [MDN Web Docs](https://developer.mozilla.org/en-US/docs/Web/API/Speculation_Rules_API).

## Installation

You can install the package via composer:

```bash
composer require innoge/laravel-speculation-rules-api
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-speculation-rules-api-config"
```

This is the contents of the published config file:

```php
return [
    'prerender' => [
        //
    ],
    'prefetch' => [
        //
    ],
];

```

## Setup

Add the following Blade directive before the end `body` tag in your template.

```php
<html>
...
<body>
    ...
    @speculationRulesApi
</body>
</html>
```

## Usage

To prerender or prefetch a route, simply add the `prerender` or `prefetch` method to the route definition.

```php
// prerender a route
Route::get('/page-1', function () {
    return view('some-view');
})->prerender();

// prefetch a route
Route::get('/page-1', function () {
    return view('some-view');
})->prefetch();
```

The level of `eagerness` can be passed as a parameter to the `prerender` and `prefetch` method, e.g.:

```php
Route::get('/page-1', function () {
    return view('some-view');
})->prerender('eager');
```

### Eagerness Levels (available as of Chrome 122)

- `eager` Loads the corresponding url immediately.
- `moderate` Loads the corresponding url when the user hovers a link that points to the corresponding route.
- `conservative` Loads the corresponding url when the user clicks a link that points to the corresponding route.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Daniel Seuffer](https://github.com/authanram)
- [All Contributors](../../contributors) &nbsp;❤️

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
