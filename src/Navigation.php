<?php

namespace Spatie\Navigation;

use Spatie\Navigation\Helpers\ActiveUrlChecker;
use Spatie\Navigation\Renderers\BreadcrumbsRenderer;
use Spatie\Navigation\Renderers\TreeRenderer;
use Spatie\Navigation\Traits\Conditions as ConditionsTrait;

class Navigation implements Node
{
    use ConditionsTrait;

    private ActiveUrlChecker $activeUrlChecker;

    /** @var Section[] */
    public array $children;

    public function __construct(ActiveUrlChecker $activeUrlChecker)
    {
        $this->activeUrlChecker = $activeUrlChecker;

        $this->children = [];
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function add(string $title = '', string $url = '', ?callable $configure = null): self
    {
        $section = new Section($this, $title, $url);

        if ($configure) {
            $configure($section);
        }

        $this->children[] = $section;

        return $this;
    }

    public function addIf($condition, string $title = '', string $url = '', ?callable $configure = null): self
    {
        if ($this->resolveCondition($condition)) {
            $this->add($title, $url, $configure);
        }

        return $this;
    }

    public function isActive(Section $section): bool
    {
        $activeSection = $this->activeSection();

        if (! $activeSection) {
            return false;
        }

        return in_array($section, array_merge([$activeSection], $activeSection->getParents()), true);
    }

    public function activeSection(): ?Section
    {
        $activeSections = $this->filter(function (Section $section) {
            return $this->activeUrlChecker->check($section->url);
        });

        return collect($activeSections)
            ->sortByDesc(function (Section $section) {
                return count($section->getParents());
            })
            ->first();
    }

    public function filter(callable $callback): array
    {
        return $this->filterSections($this->children, $callback);
    }

    private function filterSections(array $sections, callable $callback): array
    {
        $filtered = [];

        foreach ($sections as $section) {
            if ($callback($section)) {
                $filtered[] = $section;
            }

            foreach ($this->filterSections($section->children, $callback) as $section) {
                $filtered[] = $section;
            }
        }

        return $filtered;
    }

    public function tree(): array
    {
        return (new TreeRenderer($this))->render();
    }

    public function breadcrumbs(): array
    {
        return (new BreadcrumbsRenderer($this))->render();
    }

    public function getParent(): ?Node
    {
        return null;
    }

    /** @return Node[] */
    public function getParents(): array
    {
        return [];
    }
}
