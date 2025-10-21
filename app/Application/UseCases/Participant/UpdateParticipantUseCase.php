<?php

namespace App\Application\UseCases\Participant;

use App\Domain\Entities\Participant;
use App\Domain\Repositories\ParticipantRepositoryInterface;
use App\Domain\Exceptions\ParticipantException;
use App\Application\DTOs\ParticipantDTO;

class UpdateParticipantUseCase
{
    public function __construct(private ParticipantRepositoryInterface $repository) {}

    public function execute(int $participantId, ParticipantDTO $dto): Participant
    {
        // Email uniqueness (exclude current participant)
        $existing = $this->repository->findByEmail(strtolower($dto->email));
        if ($existing && $existing->getParticipantId() !== $participantId) {
            throw new ParticipantException("Participant.Email already exists.");
        }

        $participant = new Participant(
            participantId: $participantId,
            projectId: $dto->projectId,
            fullName: $dto->fullName,
            email: $dto->email,
            affiliation: $dto->affiliation,
            specialization: $dto->specialization,
            crossSkillTrained: $dto->crossSkillTrained,
            institution: $dto->institution
        );

        return $this->repository->save($participant);
    }
}
