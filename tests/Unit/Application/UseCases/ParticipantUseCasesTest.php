<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\UseCases\Participant\CreateParticipantUseCase;
use App\Application\UseCases\Participant\UpdateParticipantUseCase;
use App\Application\UseCases\Participant\DeleteParticipantUseCase;
use App\Application\DTOs\ParticipantDTO;
use App\Domain\Entities\Participant;
use App\Domain\Exceptions\ParticipantException;
use App\Domain\Repositories\ParticipantRepositoryInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ParticipantUseCasesTest extends TestCase
{
    #[Test]
    public function it_creates_participant_successfully()
    {
        $repository = $this->createMock(ParticipantRepositoryInterface::class);
        $repository->method('findByEmail')->willReturn(null);
        $repository->method('save')->willReturnCallback(fn(Participant $p) => $p);

        $useCase = new CreateParticipantUseCase($repository);

        $dto = new ParticipantDTO(
            projectId: 1,
            fullName: 'Alice Doe',
            email: 'alice@example.com',
            affiliation: 'TechLabs',
            specialization: 'ML'
        );

        $participant = $useCase->execute($dto);

        $this->assertEquals('Alice Doe', $participant->getFullName());
    }

    #[Test]
    public function it_prevents_duplicate_email()
    {
        $existing = new Participant(
            id: 1,
            projectId: 1,
            fullName: 'Alice Doe',
            email: 'alice@example.com',
            affiliation: 'TechLabs'
        );

        $repository = $this->createMock(ParticipantRepositoryInterface::class);
        $repository->method('findByEmail')->willReturn($existing);

        $useCase = new CreateParticipantUseCase($repository);

        $dto = new ParticipantDTO(
            projectId: 1,
            fullName: 'Alice Doe',
            email: 'alice@example.com',
            affiliation: 'TechLabs'
        );

        $this->expectException(ParticipantException::class);
        $useCase->execute($dto);
    }

    #[Test]
    public function it_updates_participant_successfully()
    {
        $participant = new Participant(
            id: 1,
            projectId: 1,
            fullName: 'Old Name',
            email: 'old@example.com',
            affiliation: 'TechLabs'
        );

        $repository = $this->createMock(ParticipantRepositoryInterface::class);
        $repository->method('findById')->willReturn($participant);
        $repository->method('save')->willReturnCallback(fn(Participant $p) => $p);

        $useCase = new UpdateParticipantUseCase($repository);

        $dto = new ParticipantDTO(
            projectId: 1,
            fullName: 'New Name',
            email: 'old@example.com',
            affiliation: 'InnovateX'
        );

        $updated = $useCase->execute(1, $dto);

        $this->assertEquals('New Name', $updated->getFullName());
        $this->assertEquals('InnovateX', $updated->getAffiliation());
    }

    #[Test]
    public function it_prevents_deleting_if_linked_to_active_project()
    {
        $repository = $this->createMock(ParticipantRepositoryInterface::class);
        $repository->method('isLinkedToActiveProject')->willReturn(true);

        $useCase = new DeleteParticipantUseCase($repository);

        $this->expectException(ParticipantException::class);
        $useCase->execute(1);
    }

    #[Test]
    public function it_deletes_participant_if_not_linked_to_active_project()
    {
        $repository = $this->createMock(ParticipantRepositoryInterface::class);
        $repository->method('isLinkedToActiveProject')->willReturn(false);
        $repository->method('delete')->willReturn(true);

        $useCase = new DeleteParticipantUseCase($repository);

        $result = $useCase->execute(1);

        $this->assertTrue($result);
    }
}
