<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Entity\Vacancy;

interface VacanciesProviderInterface
{
    public function getById(int $id): ?Vacancy;

    /**
     * @param array<string, string> $filters
     * @return array<Vacancy>
     */
    public function getByFilters(array $filters = []): array;

    /**
     * @param array<string> $skills
     */
    public function getVacancyBySkillSet(array $skills): ?Vacancy;
}
