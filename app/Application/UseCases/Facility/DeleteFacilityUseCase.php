<?php

namespace App\Application\UseCases\Facility;

use App\Domain\Repositories\FacilityRepositoryInterface;
use App\Domain\Exceptions\FacilityException;

class DeleteFacilityUseCase
{
    public function __construct(
        private FacilityRepositoryInterface $repository
    ) {}

    public function execute(int $id): bool
    {
        // Business Rule: Deletion Constraints
        // Facilities cannot be deleted if they have any related Services, Equipment, or Projects
        if ($this->repository->hasServices($id) || 
            $this->repository->hasEquipment($id) || 
            $this->repository->hasProjects($id)) {
            throw new FacilityException("Facility has dependent records (Services/Equipment/Projects).");
        }

        return $this->repository->delete($id);
    }
}