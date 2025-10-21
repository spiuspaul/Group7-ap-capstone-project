<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Facility;

interface FacilityRepositoryInterface
{
    
    public function findById(int $id): ?Facility;
    public function findByNameAndLocation(string $name, string $location): ?Facility;
    public function save(Facility $facility): Facility;
    public function delete(int $id): bool;
    public function hasServices(int $facilityId): bool;
    public function hasEquipment(int $facilityId): bool;
    public function hasProjects(int $facilityId): bool;
}

