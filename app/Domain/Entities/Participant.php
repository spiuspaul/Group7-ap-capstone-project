<?php

namespace App\Domain\Entities;

use App\Domain\Exceptions\ParticipantException;

class Participant
{
    public function __construct(
        private ?int $participantId,
        private int $projectId,
        private string $fullName,
        private string $email,
        private string $affiliation,
        private ?string $specialization = null,
        private bool $crossSkillTrained = false,
        private ?string $institution = null
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        // Required Fields
        if (empty(trim($this->fullName))) {
            throw new ParticipantException("Participant.FullName is required.");
        }
        if (empty(trim($this->email))) {
            throw new ParticipantException("Participant.Email is required.");
        }
        if (empty(trim($this->affiliation))) {
            throw new ParticipantException("Participant.Affiliation is required.");
        }

        // CrossSkill validation
        if ($this->crossSkillTrained && empty(trim($this->specialization))) {
            throw new ParticipantException("Cross-skill flag requires Specialization.");
        }
    }

    // Getters
    public function getParticipantId(): ?int { return $this->participantId; }
    public function getProjectId(): int { return $this->projectId; }
    public function getFullName(): string { return $this->fullName; }
    public function getEmail(): string { return $this->email; }
    public function getAffiliation(): string { return $this->affiliation; }
    public function getSpecialization(): ?string { return $this->specialization; }
    public function isCrossSkillTrained(): bool { return $this->crossSkillTrained; }
    public function getInstitution(): ?string { return $this->institution; }
}
