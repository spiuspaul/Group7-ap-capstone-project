<?php

namespace App\Application\UseCases\Equipment;

use App\Domain\Entities\Equipment;
use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Domain\Exceptions\EquipmentException;
use App\Application\DTOs\EquipmentDTO;

class UpdateEquipmentUseCase
{
public function __construct(
private EquipmentRepositoryInterface $repository
) {}


public function execute(int $equipmentId, EquipmentDTO $dto): Equipment
{
// Business Rule: Uniqueness
$existing = $this->repository->findByInventoryCode($dto->inventoryCode);
if ($existing && $existing->getEquipmentId() !== $equipmentId) {
throw new EquipmentException("Equipment.InventoryCode already exists.");
}


$equipment = new Equipment(
equipmentId: $equipmentId,
facilityId: $dto->facilityId,
name: $dto->name,
inventoryCode: $dto->inventoryCode,
capabilities: $dto->capabilities,
description: $dto->description,
usageDomain: $dto->usageDomain,
supportPhase: $dto->supportPhase
);


return $this->repository->update($equipment);
}
}