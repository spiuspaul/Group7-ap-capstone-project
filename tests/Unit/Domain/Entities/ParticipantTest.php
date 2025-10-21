<?php

namespace Tests\Unit\Domain\Entities;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Domain\Entities\Participant;
use App\Domain\Exceptions\ParticipantException;



class ParticipantTest extends TestCase
{
    #[Test]
    public function it_requires_full_name_email_and_affiliation()
    {
        $this->expectException(ParticipantException::class);
        new Participant(
            id: 1,
            projectId: 1,
            fullName: '',
            email: '',
            affiliation: '',
        );
    }

    #[Test]
    public function it_requires_specialization_if_cross_skill_trained()
    {
        $this->expectException(ParticipantException::class);
        new Participant(
            id: 1,
            projectId: 1,
            fullName: 'Jane Doe',
            email: 'jane@example.com',
            affiliation: 'TechLabs',
            crossSkillTrained: true,
            specialization: '',
        );
    }

    #[Test]
    public function it_creates_valid_participant()
    {
        $participant = new Participant(
            id: null,
            projectId: 1,
            fullName: 'John Doe',
            email: 'john@example.com',
            affiliation: 'TechLabs',
            specialization: 'AI',
            crossSkillTrained: true,
            institution: 'MIT'
        );

        $this->assertEquals('John Doe', $participant->getFullName());
        $this->assertTrue($participant->isCrossSkillTrained());
        $this->assertEquals('AI', $participant->getSpecialization());
    }
}
