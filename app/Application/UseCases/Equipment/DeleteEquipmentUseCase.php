<?php

namespace App\Application\UseCases\Equipment;

use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Domain\Exceptions\EquipmentException;

class DeleteEquipmentUseCase
{
public function __construct(
private EquipmentRepositoryInterface $repository
) {}


public function execute(int $equipmentId): bool
{
// Business Rule: Delete Guard
if ($this->repository->isReferencedByActiveProject($equipmentId)) {
throw new EquipmentException("Equipment referenced by active Project.");
}


return $this->repository->delete($equipmentId);
}
}