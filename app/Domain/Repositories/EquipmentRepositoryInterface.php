<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Equipment;

interface EquipmentRepositoryInterface
{
    public function findById(int $equipmentId): ?Equipment;
    public function findByInventoryCode(string $inventoryCode): ?Equipment;
    public function save(Equipment $equipment): Equipment;
    public function update(Equipment $equipment): Equipment;
    public function delete(int $equipmentId): bool;
    public function isReferencedByActiveProject(int $equipmentId): bool;
}

