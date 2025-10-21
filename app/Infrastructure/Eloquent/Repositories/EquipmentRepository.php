<?php

namespace App\Infrastructure\Eloquent\Repositories;

use App\Domain\Entities\Equipment;
use App\Domain\Repositories\EquipmentRepositoryInterface;
use App\Domain\Exceptions\EquipmentException;
use App\Infrastructure\Persistence\Eloquent\Models\EquipmentModel;

class EquipmentRepository implements EquipmentRepositoryInterface
{
    public function findById(int $equipmentId): ?Equipment
    {
        $model = EquipmentModel::find($equipmentId);
        return $model ? $this->mapToDomain($model) : null;
    }

    public function findByInventoryCode(string $inventoryCode): ?Equipment
    {
        $model = EquipmentModel::where('inventory_code', $inventoryCode)->first();
        return $model ? $this->mapToDomain($model) : null;
    }

    public function save(Equipment $equipment): Equipment
    {
        $model = new EquipmentModel([
            'facility_id' => $equipment->getFacilityId(),
            'name' => $equipment->getName(),
            'inventory_code' => $equipment->getInventoryCode(),
            'capabilities' => $equipment->getCapabilities(),
            'description' => $equipment->getDescription(),
            'usage_domain' => $equipment->getUsageDomain(),
            'support_phase' => $equipment->getSupportPhase(),
        ]);
        $model->save();

        return $this->mapToDomain($model);
    }

    public function update(Equipment $equipment): Equipment
    {
        $model = EquipmentModel::find($equipment->getEquipmentId());
        if (!$model) {
            throw new EquipmentException("Equipment not found.");
        }

        $model->update([
            'facility_id' => $equipment->getFacilityId(),
            'name' => $equipment->getName(),
            'inventory_code' => $equipment->getInventoryCode(),
            'capabilities' => $equipment->getCapabilities(),
            'description' => $equipment->getDescription(),
            'usage_domain' => $equipment->getUsageDomain(),
            'support_phase' => $equipment->getSupportPhase(),
        ]);

        return $this->mapToDomain($model);
    }

    public function delete(int $equipmentId): bool
    {
        $model = EquipmentModel::find($equipmentId);
        if (!$model) {
            throw new EquipmentException("Equipment not found.");
        }
        return $model->delete();
    }

    public function isReferencedByActiveProject(int $equipmentId): bool
    {
        // Placeholder: implement actual check for active projects
        return false;
    }

    private function mapToDomain(EquipmentModel $model): Equipment
    {
        return new Equipment(
            equipmentId: $model->equipment_id,
            facilityId: $model->facility_id,
            name: $model->name,
            inventoryCode: $model->inventory_code,
            capabilities: $model->capabilities,
            description: $model->description,
            usageDomain: $model->usage_domain,
            supportPhase: $model->support_phase
        );
    }
}