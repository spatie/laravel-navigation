<?php

namespace Spatie\Navigation\Renderers;

use RuntimeException;
use Spatie\Navigation\Navigation;

class BreadcrumbsRenderer
{
    private Navigation $navigation;

    public function __construct(Navigation $navigation)
    {
        $this->navigation = $navigation;
    }

    public function render(): array
    {
        try {
            $activeSection = $this->navigation->activeSection();
        } catch (RuntimeException $exception) {
            return [];
        }

        return [];
    }
}
