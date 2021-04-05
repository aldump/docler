<?php

declare(strict_types=1);

namespace App\Entity;

class Vacancy
{
    private int $id;
    private string $jobTitle;
    private string $seniorityLevel;
    private string $country;
    private string $city;
    private int $salary;
    private string $currency;
    private string $requiredSkills;
    private string $companySize;
    private string $companyDomain;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): void
    {
        $this->jobTitle = $jobTitle;
    }

    public function getSeniorityLevel(): string
    {
        return $this->seniorityLevel;
    }

    public function setSeniorityLevel(string $seniorityLevel): void
    {
        $this->seniorityLevel = $seniorityLevel;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): void
    {
        $this->salary = $salary;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getRequiredSkills(): string
    {
        return $this->requiredSkills;
    }

    public function setRequiredSkills(string $requiredSkills): void
    {
        $this->requiredSkills = $requiredSkills;
    }

    public function getCompanySize(): string
    {
        return $this->companySize;
    }

    public function setCompanySize(string $companySize): void
    {
        $this->companySize = $companySize;
    }

    public function getCompanyDomain(): string
    {
        return $this->companyDomain;
    }

    public function setCompanyDomain(string $companyDomain): void
    {
        $this->companyDomain = $companyDomain;
    }
}
