<?php

namespace App\Application\DTOs;

class ProgramDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly array $nationalAlignment = [],
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
}