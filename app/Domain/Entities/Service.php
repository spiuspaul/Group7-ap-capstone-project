<?php

namespace App\Domain\Entities;

use App\Domain\Exceptions\ServiceException;

class Service
{
    public function __construct(
        private ?int $serviceId,
        private int $facilityId,
        private string $name,
        private string $category,
        private string $skillType,
        private ?string $description = null
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->facilityId)) {
            throw new ServiceException("Service.FacilityId is required.");
        }

        if (empty(trim($this->name))) {
            throw new ServiceException("Service.Name is required.");
        }

        if (empty(trim($this->category))) {
            throw new ServiceException("Service.Category is required.");
        }

        if (empty(trim($this->skillType))) {
            throw new ServiceException("Service.SkillType is required.");
        }
    }

    // Getters
    public function getServiceId(): ?int { return $this->serviceId; }
    public function getFacilityId(): int { return $this->facilityId; }
    public function getName(): string { return $this->name; }
    public function getCategory(): string { return $this->category; }
    public function getSkillType(): string { return $this->skillType; }
    public function getDescription(): ?string { return $this->description; }
}
