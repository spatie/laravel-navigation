<?php

namespace Spatie\Navigation;

interface Node
{
    public function getParent(): ?Node;

    /** @return Node[] */
    public function getParents(): array;
}
