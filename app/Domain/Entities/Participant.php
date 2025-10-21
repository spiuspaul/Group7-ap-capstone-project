<?php

namespace App\Domain\Entities;

use App\Domain\Exceptions\ParticipantException;

class Participant
{
    public function __construct(
        private ?int $id,
        private string $full_name,
        private string $email,
        private string $affiliation,
        private string $specialization,
        private bool $cross_skill_trained,
        private string $institution
    ) {
        $this->validate();
    }

    private function validate():void
    {
        if (empty(trim($this->full_name))) {
            throw new ParticipantException("Participant.FullName is required.");
        }

        if (empty(trim($this->email))) {
            throw new ParticipantException("Participant.Email is required.");
        }

        if (empty(trim($this->affiliation))) {
            throw new ParticipantException("Participant.Affiliation is required.");
        }
    }

    #Getters
    public function getId(): ?int { return $this->id; }
    public function getFullName(): string { return $this->full_name; }
    public function getEmail(): string { return $this->email; }
    public function getAffiliation(): string { return $this->affiliation; }
    public function getSpecialization(): string { return $this->specialization; }
    public function isCrossSkillTrained(): bool { return $this->cross_skill_trained; }
    public function getInstitution(): string { return $this->institution; }
}

