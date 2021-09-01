<?php

namespace Spatie\Navigation\Traits;

trait Conditions
{
    protected function resolveCondition($conditional)
    {
        return is_callable($conditional) ? $conditional() : $conditional;
    }
}

