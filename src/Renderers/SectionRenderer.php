<?php

namespace Spatie\Navigation\Renderers;

use Spatie\Navigation\Section;

class SectionRenderer
{
    public function __construct(
        protected ?Section $section
    ) {
    }

    public function render(): ?array
    {
        if (!$this->section) {
            return null;
        }
        
        return [
            'url' => $this->section->url,
            'title' => $this->section->title,
            'attributes' => $this->section->attributes,
        ];
    }
}
