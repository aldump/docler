<?php

declare(strict_types=1);

namespace App\Service;

class SkillCompareService implements SkillCompareInterface
{
    /**
     * @param array<string> $original
     * @param array<string> $compare
     */
    public function getIntersectionPresent(array $original, array $compare): float
    {
        $original = array_filter($original, static fn($value) => !is_null($value) && $value !== '');
        $compare = array_filter($compare, static fn($value) => !is_null($value) && $value !== '');

        $size = count($compare);

        if ($size === 0) {
            return 0;
        }

        return round(count(array_intersect($original, $compare)) * 100 / $size, 2);
    }
}
