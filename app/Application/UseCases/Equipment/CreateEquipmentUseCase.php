<?php

namespace App\Application\UseCases\Equipment;

use App\Domain\Entities\Equipment;
use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Domain\Exceptions\EquipmentException;
use App\Application\DTOs\EquipmentDTO;


class CreateEquipmentUseCase
{
    public function __construct(
        private EquipmentRepositoryInterface $repository
    ) {}


    public function execute(EquipmentDTO $dto): Equipment
    {
        // Business Rule: Uniqueness
        $existing = $this->repository->findByInventoryCode($dto->inventoryCode);
        if ($existing) {
          throw new EquipmentException("Equipment.InventoryCode already exists.");
       }


        $equipment = new Equipment(
            equipmentId: null,
            facilityId: $dto->facilityId,
            name: $dto->name,
            inventoryCode: $dto->inventoryCode,
            capabilities: $dto->capabilities,
            description: $dto->description,
            usageDomain: $dto->usageDomain,
            supportPhase: $dto->supportPhase
        );


        return $this->repository->save($equipment);
    }
}