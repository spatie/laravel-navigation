<?php

namespace Spatie\Navigation\Helpers;

use Spatie\Url\Url;

class ActiveUrlChecker
{
    private string $requestUrl;

    private string $rootUrl;

    public function __construct(string $requestUrl, string $rootUrl)
    {
        $this->requestUrl = $requestUrl;
        $this->rootUrl = $rootUrl;
    }

    public function check(string $url): bool
    {
        $url = Url::fromString($url);
        $requestUrl = Url::fromString($this->requestUrl);

        // If the hosts don't match, this url isn't active.
        if ($url->getHost() !== $requestUrl->getHost()) {
            return false;
        }

        $rootUrl = Str::ensureLeft('/', $this->rootUrl);

        // All paths used in this method should be terminated by a /
        // otherwise startsWith at the end will be too greedy and
        // also matches items which are on the same level
        $rootUrl = Str::ensureRight('/', $rootUrl);

        $itemPath = Str::ensureRight('/', $url->getPath());

        // If this url doesn't start with the rootUrl, it's inactive.
        if (! Str::startsWith($itemPath, $rootUrl)) {
            return false;
        }

        $matchPath = Str::ensureRight('/', $requestUrl->getPath());

        // For the next comparisons we just need the paths, and we'll remove
        // the rootUrl first.
        $itemPath = Str::removeFromStart($rootUrl, $itemPath);
        $matchPath = Str::removeFromStart($rootUrl, $matchPath);

        // If this url starts with the url we're matching with, it's active.
        if ($matchPath === $itemPath || Str::startsWith($matchPath, $itemPath)) {
            return true;
        }

        return false;
    }
}
