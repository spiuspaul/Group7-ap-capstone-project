<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Project;
use App\Domain\Repositories\ProjectRepositoryInterface;
use App\Domain\Exceptions\ProjectException;
use App\Application\DTOs\ProjectDTO;

class UpdateProject
{
    public function __construct(
        private ProjectRepositoryInterface $repository
    ) {}

    public function execute(int $id, ProjectDTO $dto): Project
    {
        // Business Rule: Name Uniqueness
        // Check if title exists in the same program (excluding current project)
        $existing = $this->repository->findByTitleInProgram($dto->title, $dto->programId);
        if ($existing && $existing->getId() !== $id) {
            throw new ProjectException("A project with this name already exists in this program.");
        }

        // Business Rule: Team Tracking
        // Each Project must have at least one Team member assigned
        $teamCount = $this->repository->countTeamMembers($id);
        if ($teamCount === 0) {
            throw new ProjectException("Project must have at least one team member assigned.");
        }

        // Business Rule: Outcome Validation
        // If Status is 'Completed', at least one Outcome must be attached
        if ($dto->status === 'Completed') {
            $outcomeCount = $this->repository->countOutcomes($id);
            if ($outcomeCount === 0) {
                throw new ProjectException("Completed projects must have at least one documented outcome.");
            }
        }

        // Business Rule: Facility Compatibility
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

        $project = new Project(
            id: $id,
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