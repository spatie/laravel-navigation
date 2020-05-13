<?php

namespace Spatie\Navigation;

class Section
{
    use HasChildren;

    public string $url;

    public string $title;

    /** @var string[] */
    public array $attributes;

    public function __construct(string $title = '', string $url = '')
    {
        $this->title = $title;
        $this->url = $url;

        $this->children = [];
        $this->attributes = [];
    }

    public function attributes(array $attributes): self
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }
}
