<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Participant;

interface ParticipantRepositoryInterface
{
    public function findById(int $id): ?Participant;
    public function findByFullName(string $full_name): ?Participant;
    public function save(Participant $participant): Participant;
    public function delete(int $id): bool;
}

