<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Program;

interface ProgramRepositoryInterface
{
    public function findById(int $id): ?Program;
    public function findByName(string $name): ?Program;
    public function save(Program $program): Program;
    public function delete(int $id): bool;
    public function hasProjects(int $programId): bool;
}