<?php

namespace App\Domain\Entities;

use App\Domain\Exceptions\FacilityException;

class Facility
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $location,
        private string $facilityType,
        private ?string $description = null,
        private ?string $partnerOrganization = null,
        private array $capabilities = []
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        // Business Rule: Required Fields
        if (empty(trim($this->name))) {
            throw new FacilityException("Facility.Name is required.");
        }

        if (empty(trim($this->location))) {
            throw new FacilityException("Facility.Location is required.");
        }

        if (empty(trim($this->facilityType))) {
            throw new FacilityException("Facility.FacilityType is required.");
        }
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getLocation(): string { return $this->location; }
    public function getFacilityType(): string { return $this->facilityType; }
    public function getDescription(): ?string { return $this->description; }
    public function getPartnerOrganization(): ?string { return $this->partnerOrganization; }
    public function getCapabilities(): array { return $this->capabilities; }
}