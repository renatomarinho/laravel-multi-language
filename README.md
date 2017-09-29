# Laravel Scan-Language-Text

[![Laravel 5.4](https://img.shields.io/badge/Laravel-5.4-brightgreen.svg?style=flat-square)](http://laravel.com)
[![Laravel 5.5](https://img.shields.io/badge/Laravel-5.5-brightgreen.svg?style=flat-square)](http://laravel.com)
[![License](https://poser.pugx.org/renatomarinho/laravel-multi-language/license)](https://packagist.org/packages/renatomarinho/laravel-multi-language)
[![StyleCI](https://styleci.io/repos/88404078/shield?branch=master)](https://styleci.io/repos/88404078)
[![Latest Stable Version](https://poser.pugx.org/renatomarinho/laravel-multi-language/v/stable)](https://packagist.org/packages/renatomarinho/laravel-multi-language)
[![Total Downloads](https://poser.pugx.org/renatomarinho/laravel-multi-language/downloads)](https://packagist.org/packages/renatomarinho/laravel-multi-language)


Laravel Scan-Language-Text detect all language texts on application and update on language file to translations.

### Instalation 

Laravel Scan-Language-Text requires PHP 7.

Require this package with composer using the following command:

```bash
$ composer require renatomarinho/laravel-multi-language
```

Go to your `config/app.php` and add the service provider:

```php
// 'providers' => [
    RenatoMarinho\LaravelMultiLanguage\MultiLanguageServiceProvider::class
// ],
   ```

### Usage

Just call the artisan command:

`php artisan multi-language:update`


### License

Laravel Multi-Language is licensed under the [MIT license](https://opensource.org/licenses/MIT).
