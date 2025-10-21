<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Application\UseCases\Project\CreateProjectUseCase as CreateProject;
use App\Application\DTOs\ProjectDTO;
use App\Domain\Entities\Project;
use App\Domain\Repositories\ProjectRepositoryInterface;
use App\Domain\Exceptions\ProjectException;

class CreateProjectTest extends TestCase
{
    #[Test]
    public function it_creates_a_project_successfully()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null); // No duplicate
        $repo->method('getFacilityCapabilities')->willReturn(['3D Printing', 'Electronics Lab']);
        $repo->method('save')->willReturnCallback(function (Project $p) {
            return new Project(
                id: 1,
                programId: $p->getProgramId(),
                facilityId: $p->getFacilityId(),
                title: $p->getTitle(),
                status: $p->getStatus(),
                natureOfProject: $p->getNatureOfProject(),
                description: $p->getDescription(),
                innovationFocus: $p->getInnovationFocus(),
                prototypeStage: $p->getPrototypeStage(),
                testingRequirements: $p->getTestingRequirements(),
                commercializationPlan: $p->getCommercializationPlan(),
                technicalRequirements: $p->getTechnicalRequirements()
            );
        });

        $useCase = new CreateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'IoT Innovation Project',
            status: 'Planning',
            description: 'Test project',
            technicalRequirements: ['3D Printing']
        );

        // Act
        $project = $useCase->execute($dto);

        // Assert
        $this->assertInstanceOf(Project::class, $project);
        $this->assertEquals('IoT Innovation Project', $project->getTitle());
        $this->assertEquals(1, $project->getProgramId());
        $this->assertEquals(1, $project->getId());
    }

    #[Test]
    public function it_prevents_duplicate_title_within_same_program()
    {
        // Arrange
        $existing = new Project(
            id: 1,
            programId: 1,
            facilityId: 1,
            title: 'Duplicate Project'
        );

        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')
            ->with('Duplicate Project', 1)
            ->willReturn($existing);

        $useCase = new CreateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Duplicate Project'
        );

        // Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('A project with this name already exists in this program.');

        // Act
        $useCase->execute($dto);
    }

    #[Test]
    public function it_prevents_duplicate_title_case_insensitive()
    {
        // Arrange
        $existing = new Project(
            id: 1,
            programId: 1,
            facilityId: 1,
            title: 'Test Project'
        );

        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')
            ->with('TEST PROJECT', 1)
            ->willReturn($existing);

        $useCase = new CreateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'TEST PROJECT'
        );

        // Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('A project with this name already exists in this program.');

        // Act
        $useCase->execute($dto);
    }

    #[Test]
    public function it_allows_same_title_in_different_programs()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        
        // First call returns null (no conflict in program 1)
        // Second call returns null (no conflict in program 2)
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('getFacilityCapabilities')->willReturn([]);
        
        $repo->method('save')->willReturnCallback(function (Project $p) {
            static $id = 0;
            $id++;
            return new Project(
                id: $id,
                programId: $p->getProgramId(),
                facilityId: $p->getFacilityId(),
                title: $p->getTitle(),
                status: $p->getStatus(),
                technicalRequirements: $p->getTechnicalRequirements()
            );
        });

        $useCase = new CreateProject($repo);

        $dto1 = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Shared Title Project'
        );
        
        $dto2 = new ProjectDTO(
            programId: 2,
            facilityId: 1,
            title: 'Shared Title Project'
        );

        // Act
        $project1 = $useCase->execute($dto1);
        $project2 = $useCase->execute($dto2);

        // Assert - Both should be created successfully
        $this->assertEquals('Shared Title Project', $project1->getTitle());
        $this->assertEquals(1, $project1->getProgramId());
        
        $this->assertEquals('Shared Title Project', $project2->getTitle());
        $this->assertEquals(2, $project2->getProgramId());
    }

    #[Test]
    public function it_validates_facility_compatibility_with_technical_requirements()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('getFacilityCapabilities')
            ->with(1)
            ->willReturn(['3D Printing', 'Electronics Lab', 'Robotics']);
        $repo->method('save')->willReturnCallback(function (Project $p) {
            return new Project(
                id: 1,
                programId: $p->getProgramId(),
                facilityId: $p->getFacilityId(),
                title: $p->getTitle(),
                status: $p->getStatus(),
                technicalRequirements: $p->getTechnicalRequirements()
            );
        });

        $useCase = new CreateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Compatible Project',
            technicalRequirements: ['3D Printing', 'Electronics Lab']
        );

        // Act
        $project = $useCase->execute($dto);

        // Assert
        $this->assertEquals('Compatible Project', $project->getTitle());
        $this->assertCount(2, $project->getTechnicalRequirements());
    }

    #[Test]
    public function it_rejects_incompatible_facility_requirements()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('getFacilityCapabilities')
            ->with(1)
            ->willReturn(['3D Printing', 'Electronics Lab']);

        $useCase = new CreateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Incompatible Project',
            technicalRequirements: ['3D Printing', 'Quantum Computing']
        );

        // Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('Project requirements not compatible with facility capabilities');

        // Act
        $useCase->execute($dto);
    }

    #[Test]
    public function it_allows_project_without_technical_requirements()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('getFacilityCapabilities')->willReturn([]);
        $repo->method('save')->willReturnCallback(function (Project $p) {
            return new Project(
                id: 1,
                programId: $p->getProgramId(),
                facilityId: $p->getFacilityId(),
                title: $p->getTitle(),
                status: $p->getStatus(),
                technicalRequirements: $p->getTechnicalRequirements()
            );
        });

        $useCase = new CreateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Simple Project',
            technicalRequirements: []
        );

        // Act
        $project = $useCase->execute($dto);

        // Assert
        $this->assertEquals('Simple Project', $project->getTitle());
        $this->assertEmpty($project->getTechnicalRequirements());
    }

    // #[Test]
    // public function it_checks_multiple_incompatible_requirements()
    // {
    //     // Arrange
    //     $repo = $this->createMock(ProjectRepositoryInterface::class);
    //     $repo->method('findByTitleInProgram')->willReturn(null);
    //     $repo->method('getFacilityCapabilities')
    //         ->with(2)
    //         ->willReturn(['Woodworking']);

    //     $useCase = new CreateProject($repo);

    //     $dto = new ProjectDTO(
    //         programId: 1,
    //         facilityId: 2,
    //         title: 'Many Requirements',
    //         technicalRequirements: ['3D Printing', 'Electronics Lab', 'Woodworking']
    //     );

    //     // Assert
    //     $this->expectException(ProjectException::class);
    //     $this->expectExceptionMessage('Missing: 3D Printing, Electronics Lab');

        // Act
        // $useCase->execute($dto);
    // }
}