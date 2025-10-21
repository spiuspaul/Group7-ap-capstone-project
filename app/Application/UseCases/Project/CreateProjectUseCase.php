<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Project;
use App\Domain\Repositories\ProjectRepositoryInterface;
use App\Domain\Exceptions\ProjectException;
use App\Application\DTOs\ProjectDTO;

class CreateProject
{
    public function __construct(
        private ProjectRepositoryInterface $repository
    ) {}

    public function execute(ProjectDTO $dto): Project
    {
        // Business Rule: Name Uniqueness
        // Project Name must be unique within a Program
        $existing = $this->repository->findByTitleInProgram($dto->title, $dto->programId);
        if ($existing) {
            throw new ProjectException("A project with this name already exists in this program.");
        }

        // Business Rule: Facility Compatibility
        // Project's technical requirements must be compatible with facility capabilities
        if (!empty($dto->technicalRequirements)) {
            $facilityCapabilities = $this->repository->getFacilityCapabilities($dto->facilityId);
            
            $incompatible = array_diff($dto->technicalRequirements, $facilityCapabilities);
            if (!empty($incompatible)) {
                throw new ProjectException(
                    "Project requirements not compatible with facility capabilities. Missing: " . 
                    implode(', ', $incompatible)
                );
            }
        }

        // Note: Team Tracking validation happens after project is created (when participants are added)
        // Note: Outcome Validation happens on update when status changes to 'Completed'

        $project = new Project(
            id: null,
            programId: $dto->programId,
            facilityId: $dto->facilityId,
            title: $dto->title,
            status: $dto->status,
            natureOfProject: $dto->natureOfProject,
            description: $dto->description,
            innovationFocus: $dto->innovationFocus,
            prototypeStage: $dto->prototypeStage,
            testingRequirements: $dto->testingRequirements,
            commercializationPlan: $dto->commercializationPlan,
            technicalRequirements: $dto->technicalRequirements
        );

        return $this->repository->save($project);
    }
}