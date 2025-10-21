<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Application\UseCases\Project\UpdateProjectUseCase as UpdateProject;
use App\Application\DTOs\ProjectDTO;
use App\Domain\Entities\Project;
use App\Domain\Repositories\ProjectRepositoryInterface;
use App\Domain\Exceptions\ProjectException;

class UpdateProjectTest extends TestCase
{
    #[Test]
    public function it_updates_a_project_successfully()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('countTeamMembers')->with(1)->willReturn(2);
        $repo->method('countOutcomes')->willReturn(0);
        $repo->method('getFacilityCapabilities')->willReturn([]);
        $repo->method('save')->willReturnCallback(function (Project $p) {
            return new Project(
                id: $p->getId(),
                programId: $p->getProgramId(),
                facilityId: $p->getFacilityId(),
                title: $p->getTitle(),
                status: $p->getStatus(),
                description: $p->getDescription(),
                technicalRequirements: $p->getTechnicalRequirements()
            );
        });

        $useCase = new UpdateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Updated Project Title',
            status: 'Active',
            description: 'Updated description'
        );

        // Act
        $project = $useCase->execute(1, $dto);

        // Assert
        $this->assertEquals('Updated Project Title', $project->getTitle());
        $this->assertEquals('Active', $project->getStatus());
    }

    #[Test]
    public function it_allows_keeping_same_title_when_updating()
    {
        // Arrange
        $existing = new Project(
            id: 1,
            programId: 1,
            facilityId: 1,
            title: 'Existing Project'
        );

        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')
            ->with('Existing Project', 1)
            ->willReturn($existing);
        $repo->method('countTeamMembers')->with(1)->willReturn(1);
        $repo->method('countOutcomes')->willReturn(0);
        $repo->method('getFacilityCapabilities')->willReturn([]);
        $repo->method('save')->willReturnCallback(function (Project $p) {
            return $p;
        });

        $useCase = new UpdateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Existing Project',
            status: 'Active'
        );

        // Act
        $project = $useCase->execute(1, $dto);

        // Assert
        $this->assertEquals('Existing Project', $project->getTitle());
        $this->assertEquals('Active', $project->getStatus());
    }

    #[Test]
    public function it_prevents_updating_to_existing_title_in_same_program()
    {
        // Arrange
        $otherProject = new Project(
            id: 2,
            programId: 1,
            facilityId: 1,
            title: 'Another Project'
        );

        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')
            ->with('Another Project', 1)
            ->willReturn($otherProject);

        $useCase = new UpdateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Another Project'
        );

        // Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('A project with this name already exists in this program.');

        // Act
        $useCase->execute(1, $dto);
    }

    #[Test]
    public function it_enforces_team_tracking_rule()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('countTeamMembers')->with(1)->willReturn(0); // No team members

        $useCase = new UpdateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Project Without Team'
        );

        // Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('Project must have at least one team member assigned.');

        // Act
        $useCase->execute(1, $dto);
    }

    #[Test]
    public function it_allows_update_with_team_members_assigned()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('countTeamMembers')->with(1)->willReturn(3); // Has team
        $repo->method('countOutcomes')->willReturn(0);
        $repo->method('getFacilityCapabilities')->willReturn([]);
        $repo->method('save')->willReturnCallback(function (Project $p) {
            return $p;
        });

        $useCase = new UpdateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Project With Team',
            status: 'Active'
        );

        // Act
        $project = $useCase->execute(1, $dto);

        // Assert
        $this->assertEquals('Project With Team', $project->getTitle());
    }

    #[Test]
    public function it_enforces_outcome_validation_for_completed_projects()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('countTeamMembers')->with(1)->willReturn(1);
        $repo->method('countOutcomes')->with(1)->willReturn(0); // No outcomes

        $useCase = new UpdateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Completed Without Outcomes',
            status: 'Completed'
        );

        // Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('Completed projects must have at least one documented outcome.');

        // Act
        $useCase->execute(1, $dto);
    }

    #[Test]
    public function it_allows_completion_with_outcomes()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('countTeamMembers')->with(1)->willReturn(1);
        $repo->method('countOutcomes')->with(1)->willReturn(2); // Has outcomes
        $repo->method('getFacilityCapabilities')->willReturn([]);
        $repo->method('save')->willReturnCallback(function (Project $p) {
            return $p;
        });

        $useCase = new UpdateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Properly Completed Project',
            status: 'Completed'
        );

        // Act
        $project = $useCase->execute(1, $dto);

        // Assert
        $this->assertEquals('Completed', $project->getStatus());
    }

    #[Test]
    public function it_does_not_require_outcomes_for_non_completed_statuses()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('countTeamMembers')->with(1)->willReturn(1);
        $repo->method('countOutcomes')->with(1)->willReturn(0); // No outcomes OK
        $repo->method('getFacilityCapabilities')->willReturn([]);
        $repo->method('save')->willReturnCallback(function (Project $p) {
            return $p;
        });

        $useCase = new UpdateProject($repo);

        $statuses = ['Planning', 'Active', 'On Hold'];
        
        foreach ($statuses as $status) {
            $dto = new ProjectDTO(
                programId: 1,
                facilityId: 1,
                title: 'Project in ' . $status,
                status: $status
            );

            // Act
            $project = $useCase->execute(1, $dto);

            // Assert
            $this->assertEquals($status, $project->getStatus());
        }
    }

    #[Test]
    public function it_validates_facility_compatibility_on_update()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('countTeamMembers')->with(1)->willReturn(1);
        $repo->method('countOutcomes')->willReturn(0);
        $repo->method('getFacilityCapabilities')
            ->with(1)
            ->willReturn(['3D Printing']);

        $useCase = new UpdateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Updated Project',
            technicalRequirements: ['3D Printing', 'Nonexistent Tech']
        );

        // Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('Project requirements not compatible with facility capabilities');

        // Act
        $useCase->execute(1, $dto);
    }

    #[Test]
    public function it_allows_compatible_facility_requirements_on_update()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('findByTitleInProgram')->willReturn(null);
        $repo->method('countTeamMembers')->with(1)->willReturn(1);
        $repo->method('countOutcomes')->willReturn(0);
        $repo->method('getFacilityCapabilities')
            ->with(1)
            ->willReturn(['3D Printing', 'Electronics Lab', 'Robotics']);
        $repo->method('save')->willReturnCallback(function (Project $p) {
            return $p;
        });

        $useCase = new UpdateProject($repo);

        $dto = new ProjectDTO(
            programId: 1,
            facilityId: 1,
            title: 'Updated Project',
            technicalRequirements: ['3D Printing', 'Electronics Lab']
        );

        // Act
        $project = $useCase->execute(1, $dto);

        // Assert
        $this->assertCount(2, $project->getTechnicalRequirements());
    }
}