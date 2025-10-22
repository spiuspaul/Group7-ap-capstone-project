<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use App\Application\UseCases\Participant\CreateParticipantUseCase;
use App\Application\UseCases\Participant\UpdateParticipantUseCase;
use App\Application\UseCases\Participant\DeleteParticipantUseCase;
use App\Application\DTOs\ParticipantDTO;
use App\Domain\Repositories\ParticipantRepositoryInterface;
use App\Domain\Entities\Participant;
use App\Domain\Exceptions\ParticipantException;

class ParticipantUseCasesTest extends TestCase
{
    public function testCreatesParticipantSuccessfully(): void
    {
        // Arrange
        $this->assertTrue(true);
        $repo = $this->createMock(ParticipantRepositoryInterface::class);
        $repo->method('findByEmail')->willReturn(null);
        $repo->method('save')->willReturnCallback(function (Participant $p) {
            return new Participant(
                1,                          // id
                $p->getFullName(),          // fullName
                $p->getEmail(),             // email
                $p->getProjectId(),         // projectId
                $p->getAffiliation(),       // affiliation
                $p->getSpecialization(),    // specialization
                $p->isCrossSkillTrained(), // crossSkillTrained
                $p->getInstitution()        // institution
            );
        });

        $useCase = new CreateParticipantUseCase($repo);

        $dto = new ParticipantDTO(
            fullName: 'Alice',
            email: 'alice@example.com',
            projectId: 2,
            affiliation: 'Org A',
            specialization: 'Tech',
            crossSkillTrained: true,
            institution: 'University X'
        );

        // Act
        $participant = $useCase->execute($dto);

        // Assert
        $this->assertInstanceOf(Participant::class, $participant);
        $this->assertEquals(1, $participant->getParticipantId());
        $this->assertEquals('Alice', $participant->getFullName());
        $this->assertEquals(2, $participant->getProjectId());
        $this->assertEquals('Org A', $participant->getAffiliation());
        $this->assertEquals('Tech', $participant->getSpecialization());
        $this->assertTrue($participant->isCrossSkillTrained());
        $this->assertEquals('University X', $participant->getInstitution());
    }

    public function testPreventsDuplicateEmailOnCreate(): void
    {
        // Arrange
        $existing = new Participant(
            1,
            'Bob',
            'bob@example.com',
            2,
            'Org B',
            'Management',
            false,
            'Institute Y'
        );

        $repo = $this->createMock(ParticipantRepositoryInterface::class);
        $repo->method('findByEmail')->with('bob@example.com')->willReturn($existing);

        $useCase = new CreateParticipantUseCase($repo);

        $dto = new ParticipantDTO(
            fullName: 'Charlie',
            email: 'bob@example.com',
            projectId: 3,
            affiliation: 'Org C',
            specialization: 'Finance',
            crossSkillTrained: false,
            institution: 'Institute Z'
        );

        $this->expectException(ParticipantException::class);
        $this->expectExceptionMessage('Participant.Email already exists.');

        // Act
        $useCase->execute($dto);
    }

    public function testUpdatesParticipantSuccessfully(): void
    {
        // Arrange
        $existing = new Participant(
            3,
            'Old Name',
            'old@example.com',
            4,
            'Org Old',
            'Tech',
            false,
            'University Old'
        );

        $repo = $this->createMock(ParticipantRepositoryInterface::class);
        $repo->method('findByEmail')->willReturn(null);
        $repo->method('update')->willReturnCallback(function (Participant $p) {
            return new Participant(
                $p->getParticipantId(),
                $p->getFullName(),
                $p->getEmail(),
                $p->getProjectId(),
                $p->getAffiliation(),
                $p->getSpecialization(),
                $p->isCrossSkillTrained(),
                $p->getInstitution()
            );
        });
        $repo->method('findById')->with(3)->willReturn($existing);

        $useCase = new UpdateParticipantUseCase($repo);

        $dto = new ParticipantDTO(
            fullName: 'New Name',
            email: 'new@example.com',
            projectId: 5,
            affiliation: 'Org New',
            specialization: 'Tech',
            crossSkillTrained: true,
            institution: 'University New'
        );

        // Act
        $updated = $useCase->execute(3, $dto);

        // Assert
        $this->assertEquals(3, $updated->getParticipantId());
        $this->assertEquals('New Name', $updated->getFullName());
        $this->assertEquals(5, $updated->getProjectId());
        $this->assertEquals('Org New', $updated->getAffiliation());
        $this->assertEquals('Tech', $updated->getSpecialization());
        $this->assertTrue($updated->isCrossSkillTrained());
        $this->assertEquals('University New', $updated->getInstitution());
    }

    public function testUpdateThrowsWhenRepositorySignalsNotFound(): void
    {
        // Arrange
        $repo = $this->createMock(ParticipantRepositoryInterface::class);
        $repo->method('findByEmail')->willReturn(null);
        $repo->method('update')->will($this->throwException(new ParticipantException('Participant not found.')));

        $useCase = new UpdateParticipantUseCase($repo);

        $dto = new ParticipantDTO(
            fullName: 'Missing',
            email: 'missing@example.com',
            projectId: 6,
            affiliation: 'Org M',
            specialization: 'Unknown',
            crossSkillTrained: false,
            institution: 'Institute M'
        );

        $this->expectException(ParticipantException::class);
        $this->expectExceptionMessage('Participant not found.');

        // Act
        $useCase->execute(999, $dto);
    }

    public function testDeletesParticipantSuccessfully(): void
    {
        // Arrange
        $repo = $this->createMock(ParticipantRepositoryInterface::class);
        $repo->method('isReferencedByActiveProject')->with(5)->willReturn(false);
        $repo->method('delete')->with(5)->willReturn(true);

        $useCase = new DeleteParticipantUseCase($repo);

        // Act
        $result = $useCase->execute(5);

        // Assert
        $this->assertTrue($result);
    }

    public function testDeleteFailsWhenReferencedByActiveProject(): void
    {
        // Arrange
        $repo = $this->createMock(ParticipantRepositoryInterface::class);
        $repo->method('isReferencedByActiveProject')->with(7)->willReturn(true);

        $useCase = new DeleteParticipantUseCase($repo);

        $this->expectException(ParticipantException::class);
        $this->expectExceptionMessage('Participant referenced by active Project.');

        // Act
        $useCase->execute(7);
    }

    public function testDeleteReturnsFalseIfRepositoryReturnsFalse(): void
    {
        // Arrange
        $repo = $this->createMock(ParticipantRepositoryInterface::class);
        $repo->method('isReferencedByActiveProject')->with(8)->willReturn(false);
        $repo->method('delete')->with(8)->willReturn(false);

        $useCase = new DeleteParticipantUseCase($repo);

        // Act
        $result = $useCase->execute(8);

        // Assert
        $this->assertFalse($result);
    }
}
