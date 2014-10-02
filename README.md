# Assets Manager for Laravel 5

A simple [Laravel 5](http://laravel.com/) assets manager

## Installation

The Assets Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`rdehnhardt/assets` package in your project's `composer.json`.

```json
{
    "require": {
        "rdehnhardt/assets": "dev-master"
    }
}
```

Then run a composer update
```sh
php composer.phar update
```

Find the `providers` key in your `app/config/app.php` and register the Assets Service Provider.

```php
    'providers' => [
        // ...
        'Rdehnhardt\Assets\Providers\AssetsServiceProvider',
    ],
```

Find the `aliases` key in your `app/config/app.php` and register the Assets Service Provider.

```php
    'aliases' => [
        'Assets' => 'Rdehnhardt\Assets\Facades\Assets',
    ] 
```

## Usage
Enter the code "{!! Assets::styles () !!}" and "{!! Assets::scripts () !!}" in your layout file.

The files must be separated into folders based on their extensions, as in the example below.

```php
    resources
        assets
            css
                file1.css
                file2.css
                file3.css
            jpg
                image1.jpg
                image2.jpg
                image3.jpg
            gif
                image1.gif
                image2.gif
                image3.gif
            js
                file1.js
                file2.js
                file3.js

```

If you need a mapper, you can create a file "map.php" inside each folder.

```php
return [
    'imports/*',
    'libs/*',
    'app/*',
];
```

These settings should generate something like:

```html
<link rel='stylesheet' href='http://www.yoursite.com/assets-9e107d9d372bb6826bd81d3542a419d6.css' type='text/css' media='all' />
```

and

```html
<script scr='http://www.yoursite.com/assets-9e107d9d372bb6826bd81d3542a419d6.js'></script>
```