<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Application\UseCases\Program\DeleteProgramUseCase;
use App\Domain\Entities\Program;
use App\Domain\Repositories\ProgramRepositoryInterface;
use App\Domain\Exceptions\ProgramException;

class DeleteProgramTest extends TestCase
{
    #[Test]
    public function it_deletes_a_program_without_projects()
    {
        // Arrange
        $repository = new class implements ProgramRepositoryInterface {
            public function findById(int $id): ?Program { return null; }
            public function findByName(string $name): ?Program { return null; }
            public function save(Program $program): Program { return $program; }
            
            public function delete(int $id): bool
            {
                return true;
            }
            
            public function hasProjects(int $programId): bool
            {
                return false; // No projects
            }
        };
        
        $useCase = new DeleteProgramUseCase($repository);

        // Act
        $result = $useCase->execute(1);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function it_prevents_deleting_program_with_projects()
    {
        // Arrange
        $repository = new class implements ProgramRepositoryInterface {
            public function findById(int $id): ?Program { return null; }
            public function findByName(string $name): ?Program { return null; }
            public function save(Program $program): Program { return $program; }
            public function delete(int $id): bool { return true; }
            
            public function hasProjects(int $programId): bool
            {
                return true; // Has projects
            }
        };
        
        $useCase = new DeleteProgramUseCase($repository);

        // Assert
        $this->expectException(ProgramException::class);
        $this->expectExceptionMessage('Program has Projects; archive or reassign before delete.');

        // Act
        $useCase->execute(1);
    }
}