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

it('can strictly check if an url is active', function (string $currentUrl, string $urlToCheck, bool $result) {
    $checker = new class ($urlToCheck, '/') extends ActiveUrlChecker {
        protected function isActive(string $matchPath, string $itemPath): bool
        {
            return $matchPath === $itemPath;
        }
    };

    expect($checker->check($currentUrl))->toBe($result);
})->with([
    ['/', '/', true],
    ['/foo', '/foo/bar', false],
]);
