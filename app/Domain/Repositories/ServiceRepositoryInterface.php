<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Service;

interface ServiceRepositoryInterface
{
    public function findById(int $serviceId): ?Service;
    public function findByNameAndFacility(string $name, int $facilityId): ?Service;
    public function save(Service $service): Service;
    public function delete(int $serviceId): bool;
    public function isReferencedByProjectCategory(int $serviceId): bool;
}


