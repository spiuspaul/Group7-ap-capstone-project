<?php

namespace App\Application\UseCases\Service;

use App\Domain\Repositories\ServiceRepositoryInterface;
use App\Domain\Exceptions\ServiceException;

class DeleteServiceUseCase
{
    public function __construct(private ServiceRepositoryInterface $repository) {}

    public function execute(int $serviceId): bool
    {
        // Business Rule: Delete Guard
        if ($this->repository->isReferencedByProjectCategory($serviceId)) {
            throw new ServiceException("Service in use by Project testing requirements.");
        }

        return $this->repository->delete($serviceId);
    }
}
