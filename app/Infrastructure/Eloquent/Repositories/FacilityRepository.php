<?php

namespace App\Infrastructure\Eloquent\Repositories;

use App\Domain\Entities\Facility;
use App\Domain\Repositories\FacilityRepositoryInterface;
use App\Infrastructure\Eloquent\Models\FacilityModel;

class FacilityRepository implements FacilityRepositoryInterface
{
    private function toDomain(FacilityModel $model): Facility
    {
        return new Facility(
            id: $model->facility_id,
            name: $model->name,
            location: $model->location,
            facilityType: $model->facility_type,
            description: $model->description,
            partnerOrganization: $model->partner_organization,
            capabilities: $model->capabilities ?? []
        );
    }

    public function findById(int $id): ?Facility
    {
        $model = FacilityModel::find($id);
        return $model ? $this->toDomain($model) : null;
    }

    public function findByNameAndLocation(string $name, string $location): ?Facility
    {
        $model = FacilityModel::whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->whereRaw('LOWER(location) = ?', [strtolower($location)])
            ->first();
        
        return $model ? $this->toDomain($model) : null;
    }

    public function save(Facility $facility): Facility
    {
        if ($facility->getId()) {
            // Update existing
            $model = FacilityModel::findOrFail($facility->getId());
            $model->update([
                'name' => $facility->getName(),
                'location' => $facility->getLocation(),
                'facility_type' => $facility->getFacilityType(),
                'description' => $facility->getDescription(),
                'partner_organization' => $facility->getPartnerOrganization(),
                'capabilities' => $facility->getCapabilities(),
            ]);
        } else {
            // Create new
            $model = FacilityModel::create([
                'name' => $facility->getName(),
                'location' => $facility->getLocation(),
                'facility_type' => $facility->getFacilityType(),
                'description' => $facility->getDescription(),
                'partner_organization' => $facility->getPartnerOrganization(),
                'capabilities' => $facility->getCapabilities(),
            ]);
        }

        return $this->toDomain($model);
    }

    public function delete(int $id): bool
    {
        return FacilityModel::destroy($id) > 0;
    }

    public function hasServices(int $facilityId): bool
    {
        $model = FacilityModel::find($facilityId);
        return $model ? $model->services()->exists() : false;
    }

    public function hasEquipment(int $facilityId): bool
    {
        $model = FacilityModel::find($facilityId);
        return $model ? $model->equipments()->exists() : false;
    }

    public function hasProjects(int $facilityId): bool
    {
        $model = FacilityModel::find($facilityId);
        return $model ? $model->projects()->exists() : false;
    }
}