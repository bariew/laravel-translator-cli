# Laravel-Translator

> Laravel command that interactively helps you find missing keys.

## Installation

Run:

```bash
composer require bariew/laravel-trasnlator-cli
```

Add the service provider into your Laravel app (`app/config/app.php`):

```php
'providers' => array(
    ...
    'Bariew\Translator\TranslatorServiceProvider'
    ...
)
```

That's it!

## Usage

```bash
php artisan translator:generate
```

> **Warning:** Saving translation changes to disk will overwrite all lang files.

### Features

The Laravel Translator command allows you to:

 - Check for missing translation lines.
 - Save changes to disk.
