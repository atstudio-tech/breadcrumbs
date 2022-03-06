# Laravel Breadcrumbs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/atstudio-tech/breadcrumbs.svg?style=flat-square)](https://packagist.org/packages/atstudio-tech/breadcrumbs)
[![Total Downloads](https://img.shields.io/packagist/dt/atstudio-tech/breadcrumbs.svg?style=flat-square)](https://packagist.org/packages/atstudio-tech/breadcrumbs)

A complete rework of an older Laravel's package that lets build breadcrumbs with quickly and easy.

```php
public function show(Post $post) {
    crumbs('Posts', '/posts')->add('Show Post #3', 'posts.show', 3);
}
```

```html
<section>
    @crumbs
</section>

<main>Main Content</main>
```

## Installation

You can install the package by running this command in your console:

```shell
composer require atstudio-tech/breadcrumbs
```

The Service Provider will be automatically discovered so there is no need to add it manually to your `/config/app.php` file.

### Vendor Files

You can publish both the configuration and views files with these commands:

```shell
php artisan vendor:publish --tag="breadcrumbs-config"
```
```shell
php artisan vendor:publish --tag="breadcrumbs-views"
```

## Usage

There are two different places to populate a breadcrumbs list:
1. In your routes file, e.g. `web.php`.
2. Directly in your route's action, e.g. closure or controller.

### Routes File

```php
use ATStudio\Breadcrumbs\Breadcrumbs;

Route::get('posts', [PostController::class, 'index'])->crumbs(function (Breadcrumbs $crumbs) {
    $crumbs->add('Posts', '/posts'); // Here we are using a hard-coded URL
});
```

With this method you can get breadcrumbs declaration out of the way, however we don't have access to route parameters. That's a case where we can put breadcrumbs declaration in our controller.

> This route macro has the same signature as the `crumbs` helper function.

### Controller

```php
public function show(Post $post) {
    crumbs('Posts', '/posts')->add('Show Post #3', 'posts.show', [3]); // The third parameter can also be a primitive: `add(..., ..., 3)`
}
```

This way you can use route parameters to build your breadcrumbs, such as showing a resource's ID.

### Notations

There are are also three different ways of building a breadcrumbs list:

#### Breadcrumbs Class

```php
use ATStudio\Breadcrumbs\Breadcrumbs;

public function show(Post $post, Breadcrumbs $crumbs) {
    $crumbs->add('Show Post #3', 'posts.show', [3]);
}
```

or

```php
use ATStudio\Breadcrumbs\Breadcrumbs;

public function show(Post $post) {
    Breadcrumbs::instance()->add('Show Post #3', 'posts.show', [3]);
}
```

#### Crumbs Façade

```php
use ATStudio\Breadcrumbs\Facades\Crumbs;

public function show(Post $post) {
    Crumbs::add('Show Post #3', 'posts.show', [3]);
}
```

#### Helper Function

This is the one we have used so far

```php
public function show(Post $post) {
    crumbs()->add('Show Post #3', 'posts.show', [3]);
}
```

If no parameters are passed, the function will return an instance of the main `Breadcrumbs` class.

### Rendering

You can render the breadcrumbs list by calling `crumbs()->render()` inside a Blade view or using a custom directive:

```html
<section>
    {{ crumbs()->render() }}
</section>

<!-- or -->

<section>
    @crumbs
</section>
```

Both notations accept an optional parameter `$view`:
- `crumbs()->render('breadcrumbs::custom-view')`
- `@crumbs(breadcrumbs::custom-view)`

You can either customize already existing views that come with the package by running:

```shell
php artisan vendor:publish --tag="breadcrumbs-views"
```

Or specify a custom view inside `config('breadcrumbs.view')`.

#### View Customization

Let's say we want to create a completely new view for our breadcrumbs. We start by creating a new Blade file inside `resources/views/vendor/breadcrumbs/custom-theme.blade.php` (I prefer to put even custom views inside the `vendor` folder, but feel free to put them anywhere you like as long as it's inside `resources/views` folder).

Let's take a look the default view file (`resources/views/vendor/breadcrumbs/plain.blade.php`):

```html
<nav aria-label="Breadcrumb">
    <ol role="list" style="display: flex; align-items: center; gap: 1rem">
        @foreach ($breadcrumbs as $breadcrumb)
            @if (!$loop->first)
                <li>/</li>
            @endif
    
            @if ($breadcrumb->active)
                <li>{{ $breadcrumb->title }}</li>
            @else
                <a href="{{ $breadcrumb->path }}">
                    {{ $breadcrumb->title }}
                </a>
            @endif
        @endforeach
    </ol>
</nav>
```

A few things to note here:
- `$breadcrumbs` is automatically passed to the view. This is the instance of `Breadcrumbs` class. You can also call `$breadcrumbs->all()` which is the same thing.
- `$breadcrumb->active` is a computed property that simply returns `true` in case the breadcrumb's path is the same as current URL.

## API

### `Breadcrumbs::add(string|array $title, ?string $path = null, mixed $params = null)`

A breadcrumb requires a title. 

If `$path` is not provided, current URL will be used instead. `$path` can either be relative URL that will be converted to an absolute link or a route name. In case of a route name, you can also use the third parameter `$params`.

`$title` accepts both a string and an array. If it's an array, it must contain these keys:
```php
[
    'title' => '',
    'path' => '',
    'params' => [], // optional
]
```

### `crumbs(string|array|callable|null $title = null, ?string $path = null, mixed $params = null)`

If you call this helper function without any parameter, it will simply return an instance of `Breadcrumbs` as mentioned above. Otherwise it accepts the same parameters as `Breadcrumbs::add()`.

Exclusively to this function, the `$title` parameter also accepts a closure (the same goes for the `Route::crumbs()` macro as shown in the example above):

```php
use ATStudio\Breadcrumbs\Breadcrumbs;

public function show(Post $post) {
    crumbs(function (Breadcrumbs $crumbs) {
        $crumbs->add('All Posts', 'posts.index');
        $crumbs->add('Show Post #1', 'posts.show', 1);
    });
}
```

### Breadcrumb Item

A single breadcrumb item has `title`, `path` and `active` properties. 

## Changelog

The [CHANGELOG](CHANGELOG.md) file will tell you about all changes to this package.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Alex Torscho](https://github.com/atorscho)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
