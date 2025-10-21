<?php

namespace App\Application\DTOs;

class ServiceDTO
{
    public function __construct(
        public readonly int $facilityId,
        public readonly string $name,
        public readonly string $category,
        public readonly string $skillType,
        public readonly ?string $description = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            facilityId: $data['facility_id'],
            name: $data['name'],
            category: $data['category'],
            skillType: $data['skill_type'],
            description: $data['description'] ?? null
        );
    }
}
