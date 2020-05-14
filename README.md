# Manage menus, breadcrums, and other navigational elements in Laravel apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-navigation.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-navigation)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-navigation/run-tests?label=tests)](https://github.com/spatie/laravel-navigation/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-navigation.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-navigation)

*Work in progress!*

Laravel Navigation is meant to be the spiritual successor of [Laravel Menu](https://github.com/spatie/laravel-menu). Laravel Menu will still be actively maintained, but there are a few principal differences between the two packages.

The main goal of Laravel Menu is to build HTML menus from PHP. Laravel Navigation describes an application's navigation tree, which can be used as a base to create navigational elements like menus and breadcrumbs. Laravel Menu has a rich API for HTML generation. Laravel Navigation doesn't do any HTML generation (although we might ship some Blade files in the future). Instead, Laravel Navigation should give you the flexibility to build your own UI without worrying about the complexity of navigation trees and active state. Think of it as a [renderless component](https://adamwathan.me/renderless-components-in-vuejs/).

```php
app(Navigation::class)
    ->add('Home', route('home'))
    ->add('Blog', route('blog.index'), function (Section $section) {
        $section
            ->add('All posts', route('blog.index'))
            ->add('Topics', route('blog.topics.index'));
    })
    ->addIf(Auth::user()->isAdmin(), function (Navigation $navigation) {
        $navigation->add('Admin', route('admin.index'));
    });
```

A navigation object can be rendered to a tree, or to breadcrumbs.

Some examples when visiting `/blog/topics/laravel`:

```php
// Render to tree
app(Navigation::class)->tree();
```

```json
[
    { "title": "Home", "url": "/", "active": false, "children": [] },
    {
        "title": "Blog",
        "url": "/blog",
        "active": false,
        "children": [
            { "title": "All posts", "url": "/blog", "active": false, "children": [] },
            { "title": "Topics", "url": "/blog/topics", "active": true, "children": [] }
        ],
    },
    { "title": "Admin", "url": "/admin", "active": false, "children": [] }
]
```

```php
// Append additional pages in your controller
app(Navigation::class)->activeSection()->add($topic->name, route('blog.topics.show', $topic));

// Render to breadcrumbs
app(Navigation::class)->breadcrumbs();
```

```json
[
    { "title": "Blog", "url": "/blog" },
    { "title": "Topics", "url": "/blog/topics" },
    { "title": "Laravel", "url": "/blog/topics/laravel" }
]
```

## Support us

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-navigation
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
