<?php

namespace App\Application\UseCases\Participant;

use App\Domain\Repositories\ParticipantRepositoryInterface;
use App\Domain\Exceptions\ParticipantException;

class DeleteParticipantUseCase
{
    public function __construct(private ParticipantRepositoryInterface $repository) {}

    public function execute(int $participantId): bool
    {
        // Optional: prevent deletion if participant is linked to active project
        if ($this->repository->isLinkedToActiveProject($participantId)) {
            throw new ParticipantException("Participant is linked to an active project.");
        }

        return $this->repository->delete($participantId);
    }
}
