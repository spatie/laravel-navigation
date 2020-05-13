<?php

namespace Spatie\Navigation;

trait HasChildren
{
    /** @var Section[] */
    public array $children;

    public function add(string $title = '', string $url = '', ?callable $configure = null): self
    {
        $section = new Section($title, $url);

        if ($configure) {
            $configure($section);
        }

        $this->children[] = $section;

        return $this;
    }
}
