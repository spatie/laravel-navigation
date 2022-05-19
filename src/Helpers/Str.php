<?php

namespace Spatie\Navigation\Helpers;

class Str
{
    public static function removeFromStart(string $remove, string $subject): string
    {
        if (! str_starts_with($subject, $remove)) {
            return $subject;
        }

        return self::replaceFirst($remove, '', $subject);
    }

    public static function replaceFirst(string $search, string $replace, string $subject): string
    {
        $position = strpos($subject, $search);

        if ($position !== false) {
            return substr_replace($subject, $replace, $position, strlen($search));
        }

        return $subject;
    }

    public static function ensureLeft(string $pattern, string $subject): string
    {
        if (strpos($subject, $pattern) === 0) {
            return $subject;
        }

        return $pattern.$subject;
    }

    public static function ensureRight(string $pattern, string $subject): string
    {
        if (strrpos($subject, $pattern) === strlen($subject) - 1) {
            return $subject;
        }

        return $subject.$pattern;
    }
}
