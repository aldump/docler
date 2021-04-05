<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Entity\Vacancy;
use App\Service\SkillCompareInterface;
use InvalidArgumentException;
use Symfony\Component\Serializer\SerializerInterface;

class VacanciesProvider implements VacanciesProviderInterface
{
    private string $filename;
    private SerializerInterface $serializer;
    private SkillCompareInterface $skillCompareService;

    public function __construct(
        string $filename,
        SerializerInterface $serializer,
        SkillCompareInterface $skillCompareService
    ) {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new InvalidArgumentException(sprintf('File "%s" doesn\'t exist or readable', $filename));
        }

        $this->filename = $filename;
        $this->serializer = $serializer;
        $this->skillCompareService = $skillCompareService;
    }

    public function getById(int $id): ?Vacancy
    {
        $entity = current($this->getByFilters(['id' => $id]));

        if (!$entity) {
            $entity = null;
        }

        return $entity;
    }

    /**
     * @param array<string, string> $filters
     * @return array<Vacancy>
     */
    public function getByFilters(array $filters = []): array
    {
        $results = [];

        foreach ($this->readData() as $vacancy) {
            $filtratedOut = false;

            foreach ($filters as $filter => $value) {
                $getter = 'get' . ucfirst($filter);

                if (method_exists(Vacancy::class, $getter)) {
                    $filtratedOut |= $vacancy->$getter() !== $value;
                }
            }

            if (!$filtratedOut) {
                $results[] = $vacancy;
            }
        }

        if (isset($filters['order_by'])) {
            $getter = 'get' . ucfirst($filters['order_by']);

            if (method_exists(Vacancy::class, $getter)) {
                usort($results, fn($item1, $item2) => $item1->$getter() <=> $item2->$getter());
            }
        }

        return $results;
    }

    /**
     * @param array<string> $skills
     */
    public function getVacancyBySkillSet(array $skills): ?Vacancy
    {
        $interestingVacancy = null;
        $currentPercent = 0;

        foreach ($this->readData() as $vacancy) {
            $requiredSkills = explode(', ', $vacancy->getRequiredSkills());
            $percent = $this->skillCompareService->getIntersectionPresent($requiredSkills, $skills);

            if ($percent > $currentPercent) {
                $interestingVacancy = $vacancy;
                $currentPercent = $percent;
            }
        }

        return $interestingVacancy;
    }

    /**
     * @return array<Vacancy>
     */
    private function readData(): array
    {
        $data = file_get_contents($this->filename);

        return $this->serializer->deserialize($data, Vacancy::class . '[]', 'csv');
    }
}
