<?php

namespace App\Infrastructure\Eloquent\Repositories;

use App\Domain\Entities\Project;
use App\Domain\Repositories\ProjectRepositoryInterface;
use App\Infrastructure\Eloquent\Models\ProjectModel;
use App\Infrastructure\Eloquent\Models\FacilityModel;

class ProjectRepository implements ProjectRepositoryInterface
{
    private function toDomain(ProjectModel $model): Project
    {
        return new Project(
            id: $model->project_id,
            programId: $model->program_id,
            facilityId: $model->facility_id,
            title: $model->title,
            status: $model->status ?? 'Planning',
            natureOfProject: $model->nature_of_project,
            description: $model->description,
            innovationFocus: $model->innovation_focus,
            prototypeStage: $model->prototype_stage,
            testingRequirements: $model->testing_requirements,
            commercializationPlan: $model->commercialization_plan,
            technicalRequirements: $model->technical_requirements ?? []
        );
    }

    public function findById(int $id): ?Project
    {
        $model = ProjectModel::find($id);
        return $model ? $this->toDomain($model) : null;
    }

    public function findByTitleInProgram(string $title, int $programId): ?Project
    {
        $model = ProjectModel::where('program_id', $programId)
            ->whereRaw('LOWER(title) = ?', [strtolower($title)])
            ->first();
        
        return $model ? $this->toDomain($model) : null;
    }

    public function save(Project $project): Project
    {
        if ($project->getId()) {
            // Update existing
            $model = ProjectModel::findOrFail($project->getId());
            $model->update([
                'program_id' => $project->getProgramId(),
                'facility_id' => $project->getFacilityId(),
                'title' => $project->getTitle(),
                'status' => $project->getStatus(),
                'nature_of_project' => $project->getNatureOfProject(),
                'description' => $project->getDescription(),
                'innovation_focus' => $project->getInnovationFocus(),
                'prototype_stage' => $project->getPrototypeStage(),
                'testing_requirements' => $project->getTestingRequirements(),
                'commercialization_plan' => $project->getCommercializationPlan(),
                'technical_requirements' => $project->getTechnicalRequirements(),
            ]);
        } else {
            // Create new
            $model = ProjectModel::create([
                'program_id' => $project->getProgramId(),
                'facility_id' => $project->getFacilityId(),
                'title' => $project->getTitle(),
                'status' => $project->getStatus(),
                'nature_of_project' => $project->getNatureOfProject(),
                'description' => $project->getDescription(),
                'innovation_focus' => $project->getInnovationFocus(),
                'prototype_stage' => $project->getPrototypeStage(),
                'testing_requirements' => $project->getTestingRequirements(),
                'commercialization_plan' => $project->getCommercializationPlan(),
                'technical_requirements' => $project->getTechnicalRequirements(),
            ]);
        }

        return $this->toDomain($model);
    }

    public function delete(int $id): bool
    {
        return ProjectModel::destroy($id) > 0;
    }

    public function countTeamMembers(int $projectId): int
    {
        $model = ProjectModel::find($projectId);
        return $model ? $model->participants()->count() : 0;
    }

    public function countOutcomes(int $projectId): int
    {
        $model = ProjectModel::find($projectId);
        return $model ? $model->outcomes()->count() : 0;
    }

    public function getFacilityCapabilities(int $facilityId): array
    {
        $facility = FacilityModel::find($facilityId);
        return $facility ? ($facility->capabilities ?? []) : [];
    }
}