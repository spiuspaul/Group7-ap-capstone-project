<?php

namespace App\Application\UseCases\Service;

use App\Domain\Entities\Service;
use App\Domain\Repositories\ServiceRepositoryInterface;
use App\Domain\Exceptions\ServiceException;
use App\Application\DTOs\ServiceDTO;

class CreateServiceUseCase
{
    public function __construct(private ServiceRepositoryInterface $repository) {}

    public function execute(ServiceDTO $dto): Service
    {
        // Business Rule: Scoped Uniqueness
        $existing = $this->repository->findByNameAndFacility($dto->name, $dto->facilityId);
        if ($existing) {
            throw new ServiceException("A service with this name already exists in this facility.");
        }

        $service = new Service(
            serviceId: null,
            facilityId: $dto->facilityId,
            name: $dto->name,
            category: $dto->category,
            skillType: $dto->skillType,
            description: $dto->description
        );

        return $this->repository->save($service);
    }
}
