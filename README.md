
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# Manage menus, breadcrumbs, and other navigational elements in Laravel apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-navigation.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-navigation)
![run-tests](https://github.com/spatie/laravel-navigation/workflows/run-tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-navigation.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-navigation)

Laravel Navigation is meant to be the spiritual successor of [Laravel Menu](https://github.com/spatie/laravel-menu). Laravel Menu will still be actively maintained, but there are a few principal differences between the two packages.

The main goal of Laravel Menu is to build HTML menus from PHP. Laravel Navigation describes an application's navigation tree, which can be used as a base to create navigational elements like menus and breadcrumbs. Laravel Menu has a rich API for HTML generation. Laravel Navigation doesn't do any HTML generation (although we might ship some Blade files in the future). Instead, Laravel Navigation should give you the flexibility to build your own UI without worrying about the complexity of navigation trees and active state. Think of it as a [renderless component](https://adamwathan.me/renderless-components-in-vuejs/).

```php
// typically, in a service provider

Navigation::make()
    ->add('Home', route('home'))
    ->add('Blog', route('blog.index'), function (Section $section) {
        $section
            ->add('All posts', route('blog.index'))
            ->add('Topics', route('blog.topics.index'));
    })
    ->addIf(
        Auth::user()->isAdmin(),
        'Admin',
        route('admin.index'),
        function (Section $section) {
            $section->add('Create post', route('blog.create'));
        }
    );
```

A navigation object can be rendered to a tree, or to breadcrumbs.

Some examples when visiting `/blog/topics/laravel`:

```php
// Render to tree
Navigation::make()->tree();
```

```json
[
    { "title": "Home", "url": "/", "active": false, "attributes": [], "children": [], "depth": 0 },
    {
        "title": "Blog",
        "url": "/blog",
        "active": false,
        "attributes": [],
        "children": [
            { "title": "All posts", "url": "/blog", "active": false, "attributes": [], "children": [], "depth": 1 },
            { "title": "Topics", "url": "/blog/topics", "active": true, "attributes": [], "children": [], "depth": 1 }
        ],
        "depth": 0
    },
    {
        "title": "Admin",
        "url": "/admin",
        "active": false,
        "attributes": [],
        "children": [
            { "title": "Create post", "url": "/blog/create", "active": false, "attributes": [], "children": [], "depth": 1 }
        ],
        "depth": 0
    }
]
```

```php
// Append additional pages in your controller
Navigation::make()->activeSection()->add($topic->name, route('blog.topics.show', $topic));

// Render to breadcrumbs
Navigation::make()->breadcrumbs();
```

```json
[
    { "title": "Blog", "url": "/blog", "attributes": [] },
    { "title": "Topics", "url": "/blog/topics", "attributes": [] },
    { "title": "Laravel", "url": "/blog/topics/laravel", "attributes": [] }
]
```

```php
// Render the current section
Navigation::make()->current();
```

```json
{ "title": "Home", "url": "/", "attributes": [] }
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-navigation.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-navigation)

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

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you've found a bug regarding security please mail [security@spatie.be](mailto:security@spatie.be) instead of using the issue tracker.

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
