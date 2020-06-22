<?php

namespace Spatie\Navigation;

class Section
{
    use HasChildren;

    public string $url;

    public string $title;

    public bool $visible;

    /** @var string[] */
    public array $attributes;

    public function __construct(string $title = '', string $url = '')
    {
        $this->title = $title;
        $this->url = $url;

        $this->visible = true;
        $this->attributes = [];

        $this->children = [];
    }

    public function attributes(array $attributes): self
    {
        $this->attributes = array_merge($this->attributes, $attributes);

        return $this;
    }

    public function show(bool $visible = true): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function hide(bool $hidden = true): self
    {
        $this->visible = ! $hidden;

        return $this;
    }
}
