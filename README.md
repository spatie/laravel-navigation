# Manage menus, breadcrums, and other navigational elements in Laravel apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-navigation.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-navigation)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/laravel-navigation/run-tests?label=tests)](https://github.com/spatie/laravel-navigation/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-navigation.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-navigation)

Work in progress.

## Support us

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-navigation
```

## Usage

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
