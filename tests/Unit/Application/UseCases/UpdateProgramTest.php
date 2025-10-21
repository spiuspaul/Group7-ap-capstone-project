<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Application\UseCases\Program\UpdateProgramUseCase;
use App\Application\DTOs\ProgramDTO;
use App\Domain\Entities\Program;
use App\Domain\Repositories\ProgramRepositoryInterface;
use App\Domain\Exceptions\ProgramException;

class UpdateProgramTest extends TestCase
{
    private ProgramRepositoryInterface $repository;
        private UpdateProgramUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Fake repository
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
                if ($program->getId()) {
                    $this->programs[$program->getId()] = $program;
                } else {
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
                return $program;
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
        
        $this->useCase = new UpdateProgramUseCase($this->repository);
        
        // Seed with an existing program
        $this->repository->save(new Program(
            id: null,
            name: 'Existing Program',
            description: 'Original description',
            nationalAlignment: 'NDPIII',
            focusAreas: ['IoT'],
            phases: ['Planning']
        ));
    }

    #[Test]
    public function it_updates_a_program_successfully()
    {
        // Arrange
        $dto = new ProgramDTO(
            name: 'Updated Program',
            description: 'Updated description',
            nationalAlignment: 'NDPIII',
            focusAreas: ['IoT'],
            phases: ['Planning']
        );

        // Act
        $program = $this->useCase->execute(1, $dto);

        // Assert
        $this->assertEquals('Updated Program', $program->getName());
        $this->assertEquals('Updated description', $program->getDescription());
    }

    #[Test]
    public function it_allows_keeping_the_same_name_when_updating()
    {
        // Arrange
        $dto = new ProgramDTO(
            name: 'Existing Program',
            description: 'Updated description',
            nationalAlignment: 'NDPIII',
            focusAreas: ['IoT'],
            phases: ['Planning']
        );

        // Act
        $program = $this->useCase->execute(1, $dto);

        // Assert
        $this->assertEquals('Existing Program', $program->getName());
        $this->assertEquals('Updated description', $program->getDescription());
    }

    #[Test]
    public function it_prevents_updating_to_an_existing_program_name()
    {
        // Arrange - Create another program
        $this->repository->save(new Program(
            id: null,
            name: 'Another Program',
            description: 'Another description',
            nationalAlignment: 'NDPIII',
            focusAreas: ['IoT'],
            phases: ['Planning']
        ));
        
        $dto = new ProgramDTO(
            name: 'Another Program',
            description: 'Trying to use existing name',
            nationalAlignment: 'NDPIII',
            focusAreas: ['IoT'],
            phases: ['Planning']
        );

        // Assert
        $this->expectException(ProgramException::class);
        $this->expectExceptionMessage('Program.Name already exists.');

        // Act
        $this->useCase->execute(1, $dto);
    }
}