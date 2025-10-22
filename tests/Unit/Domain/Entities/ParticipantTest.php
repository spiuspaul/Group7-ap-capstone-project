<?php

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ParticipantException extends \Exception {}

// ------------------- Participant Entity -------------------
class Participant
{
    private ?int $participantId;
    private string $fullName;
    private string $email;
    private int $projectId;
    private string $affiliation;
    private string $specialization;
    private bool $crossSkillTrained;
    private string $institution;

    public function __construct(
        ?int $participantId,
        string $fullName,
        string $email,
        int $projectId,
        string $affiliation,
        string $specialization,
        bool $crossSkillTrained,
        string $institution
    ) {
        // Validation rules
        if (empty($fullName) || empty($email)) {
            throw new ParticipantException("Participant.FullName and Participant.Email are required.");
        }

        if (empty($projectId)) {
            throw new ParticipantException("Participant.ProjectId is required.");
        }

        $this->participantId = $participantId;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->projectId = $projectId;
        $this->affiliation = $affiliation;
        $this->specialization = $specialization;
        $this->crossSkillTrained = $crossSkillTrained;
        $this->institution = $institution;
    }

    // Getters
    public function getParticipantId(): ?int { return $this->participantId; }
    public function getFullName(): string { return $this->fullName; }
    public function getEmail(): string { return $this->email; }
    public function getProjectId(): int { return $this->projectId; }
    public function getAffiliation(): string { return $this->affiliation; }
    public function getSpecialization(): string { return $this->specialization; }
    public function getCrossSkillTrained(): bool { return $this->crossSkillTrained; }
    public function getInstitution(): string { return $this->institution; }
}

//  PHPUnit Tests
class ParticipantTest extends TestCase
{
    #[Test]
    public function it_requires_name_and_email()
    {
        $this->expectException(ParticipantException::class);
        $this->expectExceptionMessage("Participant.FullName and Participant.Email are required.");

        new Participant(
            participantId: null,
            fullName: '',
            email: '',
            projectId: 1,
            affiliation: 'Organization',
            specialization: 'Engineering',
            crossSkillTrained: false,
            institution: 'Makerere University'
        );
    }

    #[Test]
    public function it_requires_a_project_id()
    {
        $this->expectException(ParticipantException::class);
        $this->expectExceptionMessage("Participant.ProjectId is required.");

        new Participant(
            participantId: null,
            fullName: 'John Peter',
            email: 'john@example.com',
            projectId: 0, // invalid
            affiliation: 'Company X',
            specialization: 'ICT',
            crossSkillTrained: true,
            institution: 'Kyambogo University'
        );
    }

    #[Test]
    public function it_creates_a_valid_participant()
    {
        $participant = new Participant(
            participantId: 3,
            fullName: 'Jane lale',
            email: 'jane@example.com',
            projectId: 5,
            affiliation: 'Org New',
            specialization: 'Tech',
            crossSkillTrained: true,
            institution: 'University New'
        );

        $this->assertEquals(3, $participant->getParticipantId());
        $this->assertEquals('Jane lale', $participant->getFullName());
        $this->assertEquals('jane@example.com', $participant->getEmail());
        $this->assertEquals(5, $participant->getProjectId());
        $this->assertEquals('Org New', $participant->getAffiliation());
        $this->assertEquals('Tech', $participant->getSpecialization());
        $this->assertTrue($participant->getCrossSkillTrained());
        $this->assertEquals('University New', $participant->getInstitution());
    }
}
