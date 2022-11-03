<?php

use Spatie\Navigation\Helpers\ActiveUrlChecker;

it('can check if an url is active', function (string $currentUrl, string $urlToCheck, bool $result) {
    $checker = new ActiveUrlChecker($urlToCheck, '/');

    expect($checker->check($currentUrl))->toBe($result);
})->with([
    ['/', '/', true],
    ['https://example.com/', 'https://another-example.com/', false], // hosts don't match
    ['/foo', '/foo/bar', true],
    ['/bar', '/foo/bar', false],
    ['bar', 'bar', false], // Does not start with '/' which is the root path
]);
