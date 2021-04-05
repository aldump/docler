<?php

declare(strict_types=1);

namespace App\Service;

interface SkillCompareInterface
{
    /**
     * @param array<string> $original
     * @param array<string> $compare
     */
    public function getIntersectionPresent(array $original, array $compare): float;
}
