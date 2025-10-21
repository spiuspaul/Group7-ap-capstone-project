<?php

namespace App\Application\DTOs;

class ParticipantDTO
{
    public function __construct(
        public readonly int $projectId,
        public readonly string $fullName,
        public readonly string $email,
        public readonly string $affiliation,
        public readonly ?string $specialization = null,
        public readonly bool $crossSkillTrained = false,
        public readonly ?string $institution = null
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            projectId: $data['project_id'],
            fullName: $data['full_name'],
            email: $data['email'],
            affiliation: $data['affiliation'],
            specialization: $data['specialization'] ?? null,
            crossSkillTrained: $data['cross_skill_trained'] ?? false,
            institution: $data['institution'] ?? null
        );
    }
}
