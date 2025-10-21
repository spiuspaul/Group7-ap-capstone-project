<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Entities\Service;
use App\Domain\Repositories\ServiceRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\ServiceModel;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function findById(int $serviceId): ?Service
    {
        $model = ServiceModel::find($serviceId);
        return $model ? $this->mapToEntity($model) : null;
    }

    public function findByNameAndFacility(string $name, int $facilityId): ?Service
    {
        $model = ServiceModel::where('name', $name)
            ->where('facility_id', $facilityId)
            ->first();

        return $model ? $this->mapToEntity($model) : null;
    }

    public function save(Service $service): Service
    {
        $data = [
            'facility_id' => $service->getFacilityId(),
            'name' => $service->getName(),
            'category' => $service->getCategory(),
            'skill_type' => $service->getSkillType(),
            'description' => $service->getDescription(),
        ];

        if ($service->getServiceId()) {
            $model = ServiceModel::find($service->getServiceId());
            $model->update($data);
        } else {
            $model = ServiceModel::create($data);
        }

        return $this->mapToEntity($model);
    }

    public function delete(int $serviceId): bool
    {
        $model = ServiceModel::find($serviceId);
        if (!$model) return false;
        return $model->delete();
    }

    public function isReferencedByProjectCategory(int $serviceId): bool
    {
        $service = ServiceModel::find($serviceId);
        if (!$service) return false;

        // Example check: assumes a Project model exists with testing_requirements column as JSON/CSV
        return \App\Infrastructure\Persistence\Eloquent\Models\Project::where('facility_id', $service->facility_id)
            ->whereJsonContains('testing_requirements', $service->category)
            ->exists();
    }

    private function mapToEntity(ServiceModel $model): Service
    {
        return new Service(
            serviceId: $model->service_id,
            facilityId: $model->facility_id,
            name: $model->name,
            category: $model->category,
            skillType: $model->skill_type,
            description: $model->description
        );
    }
}
