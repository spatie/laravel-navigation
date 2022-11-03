<?php

namespace Spatie\Navigation\Tests;

use Orchestra\Testbench\TestCase;
use Pest\Expectation;
use Spatie\Navigation\Helpers\Str;

it('can check if string starts with')
    ->expect(Str::startsWith('startEnd', 'start'))->toBeTrue()
    ->and(Str::startsWith('startEnd', 'end'))->toBeFalse()
    ->and(Str::startsWith('/', '/foo'))->toBeFalse()
    ->and(Str::startsWith('/foo', '/'))->toBeTrue();

it('can remove from start')
    ->expect(Str::removeFromStart('start', 'startEnd'))->toBe('End')
    ->and(Str::removeFromStart('start', 'endEnd'))->toBe('endEnd');

it('can replace first occurence')
    ->expect(Str::replaceFirst('start', '', 'startstartEnd'))->toBe('startEnd')
    ->expect(Str::replaceFirst('start', '', 'endEnd'))->toBe('endEnd');

it('can ensure left')
    ->expect([
        Str::ensureLeft('/', 'url'),
        Str::ensureLeft('/', '/url')
    ])->each->toBe('/url');

it('can ensure right')
    ->expect([
        Str::ensureRight('/', 'url'),
        Str::ensureRight('/', 'url/')
    ])->each->toBe('url/');
