<?php

namespace App\Application\DTOs;

class ProgramDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $nationalAlignment,
        public readonly array $focusAreas = [],
        public readonly array $phases = []
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            nationalAlignment: $data['national_alignment'] ?? [],
            focusAreas: $data['focus_areas'] ?? [],
            phases: $data['phases'] ?? []
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            nationalAlignment: $data['nationalAlignment'] ?? [],
            focusAreas: $data['focusAreas'] ?? [],
            phases: $data['phases'] ?? []
        );
    }
}