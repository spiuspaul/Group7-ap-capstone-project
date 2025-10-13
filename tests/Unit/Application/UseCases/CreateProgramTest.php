<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Application\UseCases\Program\CreateProgramUseCase;
use App\Application\DTOs\ProgramDTO;
use App\Domain\Entities\Program;
use App\Domain\Repositories\ProgramRepositoryInterface;
use App\Domain\Exceptions\ProgramException;

class CreateProgramTest extends TestCase
{
    private ProgramRepositoryInterface $repository;
    private CreateProgramUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a fake repository (Test Double)
        $this->repository = new class implements ProgramRepositoryInterface {
            private array $programs = [];
            
            public function findById(int $id): ?Program
            {
                return $this->programs[$id] ?? null;
            }
            
            public function findByName(string $name): ?Program
            {
                foreach ($this->programs as $program) {
                    if (strtolower($program->getName()) === strtolower($name)) {
                        return $program;
                    }
                }
                return null;
            }
            
            public function save(Program $program): Program
            {
                $id = count($this->programs) + 1;
                $savedProgram = new Program(
                    id: $id,
                    name: $program->getName(),
                    description: $program->getDescription(),
                    nationalAlignment: $program->getNationalAlignment(),
                    focusAreas: $program->getFocusAreas(),
                    phases: $program->getPhases()
                );
                $this->programs[$id] = $savedProgram;
                return $savedProgram;
            }
            
            public function delete(int $id): bool
            {
                if (isset($this->programs[$id])) {
                    unset($this->programs[$id]);
                    return true;
                }
                return false;
            }
            
            public function hasProjects(int $programId): bool
            {
                return false;
            }
        };
        
        $this->useCase = new CreateProgramUseCase($this->repository);
    }

    #[Test]
    public function it_creates_a_program_successfully()
    {
        // Arrange
        $dto = new ProgramDTO(
            name: 'Innovation Program',
            description: 'A test program',
            nationalAlignment: ['NDPIII'],
            focusAreas: ['IoT'],
            phases: ['Planning']
        );

        // Act
        $program = $this->useCase->execute($dto);

        // Assert
        $this->assertInstanceOf(Program::class, $program);
        $this->assertEquals('Innovation Program', $program->getName());
        $this->assertEquals('A test program', $program->getDescription());
        $this->assertNotNull($program->getId());
    }

    #[Test]
    public function it_prevents_duplicate_program_names()
    {
        // Arrange
        $dto1 = new ProgramDTO(
            name: 'Duplicate Program',
            description: 'First program'
        );
        
        $dto2 = new ProgramDTO(
            name: 'Duplicate Program',
            description: 'Second program'
        );

        // Act
        $this->useCase->execute($dto1);

        // Assert
        $this->expectException(ProgramException::class);
        $this->expectExceptionMessage('Program.Name already exists.');
        
        $this->useCase->execute($dto2);
    }

    #[Test]
    public function it_prevents_duplicate_program_names_case_insensitive()
    {
        // Arrange
        $dto1 = new ProgramDTO(
            name: 'Test Program',
            description: 'First program'
        );
        
        $dto2 = new ProgramDTO(
            name: 'test program',
            description: 'Second program'
        );

        // Act
        $this->useCase->execute($dto1);

        // Assert
        $this->expectException(ProgramException::class);
        $this->expectExceptionMessage('Program.Name already exists.');
        
        $this->useCase->execute($dto2);
    }
}