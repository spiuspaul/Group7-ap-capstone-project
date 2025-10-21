<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Project;

interface ProjectRepositoryInterface
{
    
    public function findById(int $id): ?Project;
    public function findByTitleInProgram(string $title, int $programId): ?Project;
    public function save(Project $project): Project;
    public function delete(int $id): bool;
    public function countTeamMembers(int $projectId): int;
    public function countOutcomes(int $projectId): int;
    public function getFacilityCapabilities(int $facilityId): array;
}