<?php

namespace App\Application\UseCases\Facility;

use App\Domain\Entities\Facility;
use App\Domain\Repositories\FacilityRepositoryInterface;
use App\Domain\Exceptions\FacilityException;
use App\Application\DTOs\FacilityDTO;

class UpdateFacilityUseCase
{
    public function __construct(
        private FacilityRepositoryInterface $repository
    ) {}

    public function execute(int $id, FacilityDTO $dto): Facility
    {
        // Business Rule: Uniqueness
        // Check if name+location combination exists (excluding current facility)
        $existing = $this->repository->findByNameAndLocation($dto->name, $dto->location);
        if ($existing && $existing->getId() !== $id) {
            throw new FacilityException("A facility with this name already exists at this location.");
        }

        // Business Rule: Capabilities
        // Capabilities must contain at least one capability if any Services or Equipment exist
        if (empty($dto->capabilities)) {
            if ($this->repository->hasServices($id) || $this->repository->hasEquipment($id)) {
                throw new FacilityException("Facility.Capabilities must be populated when Services/Equipment exist.");
            }
        }

        $facility = new Facility(
            id: $id,
            name: $dto->name,
            location: $dto->location,
            facilityType: $dto->facilityType,
            description: $dto->description,
            partnerOrganization: $dto->partnerOrganization,
            capabilities: $dto->capabilities
        );

        return $this->repository->save($facility);
    }
}