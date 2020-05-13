<?php

namespace Spatie\Navigation\Renderers;

use RuntimeException;
use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;

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

        $breadcrumbs = [$activeSection];

        while (!in_array($breadcrumbs[0], $this->navigation->children, true)) {

            $parent = $this->findParent($breadcrumbs[0], $this->navigation->children);

            if (!$parent) {
                throw new RuntimeException("Should never happen");
            }

            $breadcrumbs = array_merge([$parent], $breadcrumbs);
        }

        return array_map(function (Section $section) {
            return [
                'url' => $section->url,
                'title' => $section->title,
                'attributes' => $section->attributes,
            ];
        }, $breadcrumbs);
    }

    private function findParent(Section $section, array $ancestors): ?Section
    {
        foreach ($ancestors as $ancestor) {
            if (in_array($section, $ancestor->children, true)) {
                return $ancestor;
            }

            if ($parent = $this->findParent($section, $ancestor->children)) {
                return $parent;
            }
        }

        return null;
    }
}
