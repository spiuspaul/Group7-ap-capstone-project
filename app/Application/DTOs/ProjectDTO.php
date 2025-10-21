<?php

namespace App\Application\DTOs;

class ProjectDTO
{
    public function __construct(
        public readonly int $programId,
        public readonly int $facilityId,
        public readonly string $title,
        public readonly string $status = 'Planning',
        public readonly ?string $natureOfProject = null,
        public readonly ?string $description = null,
        public readonly ?string $innovationFocus = null,
        public readonly ?string $prototypeStage = null,
        public readonly ?string $testingRequirements = null,
        public readonly ?string $commercializationPlan = null,
        public readonly array $technicalRequirements = []
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            programId: (int) $data['program_id'],
            facilityId: (int) $data['facility_id'],
            title: $data['title'],
            status: $data['status'] ?? 'Planning',
            natureOfProject: $data['nature_of_project'] ?? null,
            description: $data['description'] ?? null,
            innovationFocus: $data['innovation_focus'] ?? null,
            prototypeStage: $data['prototype_stage'] ?? null,
            testingRequirements: $data['testing_requirements'] ?? null,
            commercializationPlan: $data['commercialization_plan'] ?? null,
            technicalRequirements: $data['technical_requirements'] ?? []
        );
    }
}