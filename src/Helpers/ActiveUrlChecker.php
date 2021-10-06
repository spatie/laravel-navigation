<?php

namespace Spatie\Navigation\Helpers;

use Spatie\Url\Url;

class ActiveUrlChecker
{
    private string $requestUrl;

    private string $rootPath;

    public function __construct(string $requestUrl, string $rootPath = '/')
    {
        $this->requestUrl = $requestUrl;
        $this->rootPath = $rootPath;
    }

    public function check(string $url): bool
    {
        $url = Url::fromString($url);
        $requestUrl = Url::fromString($this->requestUrl);

        // If the hosts don't match, this url isn't active.
        if ($url->getHost() !== $requestUrl->getHost()) {
            return false;
        }

        $rootPath = Str::ensureLeft('/', $this->rootPath);

        // All paths used in this method should be terminated by a /
        // otherwise startsWith at the end will be too greedy and
        // also matches items which are on the same level
        $rootPath = Str::ensureRight('/', $rootPath);

        $itemPath = Str::ensureRight('/', $url->getPath());

        // If this url doesn't start with the rootPath, it's inactive.
        if (! Str::startsWith($itemPath, $rootPath)) {
            return false;
        }

        $matchPath = Str::ensureRight('/', $requestUrl->getPath());

        // For the next comparisons we just need the paths, and we'll remove
        // the rootPath first.
        $itemPath = Str::removeFromStart($rootPath, $itemPath);
        $matchPath = Str::removeFromStart($rootPath, $matchPath);

        // If this url starts with the url we're matching with, it's active.
        if ($matchPath === $itemPath || Str::startsWith($matchPath, $itemPath)) {

            // Compare section if set
            if ($requestUrl->getQueryParameter('section')) {
                return $url->getQueryParameter('section') === $requestUrl->getQueryParameter('section');
            }

            return true;
        }

        return false;
    }
}
