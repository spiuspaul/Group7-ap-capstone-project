<?php

namespace App\Application\UseCases\Facility;

use App\Domain\Entities\Facility;
use App\Domain\Repositories\FacilityRepositoryInterface;
use App\Domain\Exceptions\FacilityException;
use App\Application\DTOs\FacilityDTO;

class CreateFacilityUseCase
{
    public function __construct(
        private FacilityRepositoryInterface $repository
    ) {}

    public function execute(FacilityDTO $dto): Facility
    {
        // Business Rule: Uniqueness
        // The combination of Name and Location must be unique
        $existing = $this->repository->findByNameAndLocation($dto->name, $dto->location);
        if ($existing) {
            throw new FacilityException("A facility with this name already exists at this location.");
        }

        // Business Rule: Capabilities (not applicable for new facility without services/equipment yet)
        // We only check this on update when services/equipment might exist

        $facility = new Facility(
            id: null,
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