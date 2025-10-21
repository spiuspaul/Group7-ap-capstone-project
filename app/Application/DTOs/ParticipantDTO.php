<?php

namespace App\Application\DTOs;

class ParticipantDTO
{
    public function __construct(
        public readonly string $full_name,
        public readonly string $email,
        public readonly string $affiliation,
        public readonly ?string $specialization = null,
        public readonly ?bool $cross_skilled_trained = null,
        public readonly ?string $institution = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            full_name: $data['full_name'],
            email: $data['email'],
            affiliation: $data['affiliation'],
            specialization: $data['specialization'] ?? null,
            cross_skilled_trained: $data['cross_skilled_trained'] ?? null,
            institution: $data['institution'] ?? null
        );
    }
}