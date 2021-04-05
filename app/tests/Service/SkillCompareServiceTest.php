<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\SkillCompareService;
use PHPUnit\Framework\TestCase;

class SkillCompareServiceTest extends TestCase
{
    /**
     * @dataProvider provideTrimData
     * @param array<array<string|int>> $input
     */
    public function testSkillIntersectionPercents(float $expectedResult, array $input): void
    {
        $service = new SkillCompareService();
        self::assertEquals($expectedResult, $service->getIntersectionPresent($input[0], $input[1]));
    }

    /**
     * @return array<array<int|array<array<string>>>>
     */
    public function provideTrimData(): array
    {
        return [
            '100_percent_intersection' => [
                100,
                [['aa', 'bb'], ['bb', 'aa']],
            ],
            '50_percent_intersection' => [
                50,
                [['aa', 'bb'], ['bb', 'aa1']],
            ],
            '0_percent_intersection' => [
                0,
                [['aa', 'bb'], ['bb1', 'aa1']],
            ],
            '0_percent_intersection_empty_original' => [
                0,
                [[], ['ddd']],
            ],
            '0_percent_intersection_empty_compare' => [
                0,
                [['ddd'], []],
            ],
            '0_percent_intersection_empty' => [
                0,
                [[], []],
            ],
            '0_percent_intersection_empty_strings' => [
                0,
                [[''], ['']],
            ],
            '0_percent_intersection_null' => [
                0,
                [[null], [null]],
            ],
            '100_percent_intersection_with_null' => [
                100,
                [['q', null], ['q', null]],
            ],
            '50_percent_intersection_with_null' => [
                50,
                [['q', null], ['q', 'w', null]],
            ],
            '50_percent_intersection_with_empty' => [
                50,
                [['q', ''], ['q', 'w', '']],
            ],
            '22_percent_intersection_with_empty' => [
                33.33,
                [['q', 'd', 's'], ['q', 'w', '2']],
            ],
            '100_percent_intersection_with_int' => [
                100,
                [[1], [1]],
            ],
        ];
    }
}
