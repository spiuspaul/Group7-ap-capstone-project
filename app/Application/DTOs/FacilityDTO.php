<?php

namespace App\Application\DTOs;

class FacilityDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $location,
        public readonly string $facilityType,
        public readonly ?string $description = null,
        public readonly ?string $partnerOrganization = null,
        public readonly array $capabilities = []
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            location: $data['location'],
            facilityType: $data['facility_type'],
            description: $data['description'] ?? null,
            partnerOrganization: $data['partner_organization'] ?? null,
            capabilities: $data['capabilities'] ?? []
        );
    }
}