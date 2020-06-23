<?php

namespace Spatie\Navigation\Renderers;

use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;

class TreeRenderer
{
    private Navigation $navigation;

    public function __construct(Navigation $navigation)
    {
        $this->navigation = $navigation;
    }

    public function render(): array
    {
        return $this->renderSections($this->navigation->children);
    }

    /**
     * @param Section[] $sections
     */
    private function renderSections(array $sections): array
    {
        $visibleSections = array_values(array_filter($sections, function (Section $section) {
            return $section->visible;
        }));

        return array_map(function (Section $section) {
            return [
                'url' => $section->url,
                'title' => $section->title,
                'active' => $this->navigation->isActive($section),
                'attributes' => $section->attributes,
                'children' => $this->renderSections($section->children),
            ];
        }, $visibleSections);
    }
}
