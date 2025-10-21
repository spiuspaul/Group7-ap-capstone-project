<?php

namespace Tests\Unit\Domain\Entities;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Domain\Entities\Project;
use App\Domain\Exceptions\ProjectException;

class ProjectTest extends TestCase
{
   #[Test]
    public function it_creates_a_valid_project()
    {
        // Arrange & Act
        $project = new Project(
            id: null,
            programId: 1,
            facilityId: 1,
            title: 'IoT Innovation Project',
            status: 'Planning',
            description: 'A project about IoT',
            technicalRequirements: ['3D Printing', 'Electronics Lab']
        );

        // Assert
        $this->assertEquals('IoT Innovation Project', $project->getTitle());
        $this->assertEquals(1, $project->getProgramId());
        $this->assertEquals(1, $project->getFacilityId());
        $this->assertEquals('Planning', $project->getStatus());
        $this->assertCount(2, $project->getTechnicalRequirements());
    }

    #[Test]
    public function it_throws_exception_when_program_id_is_missing()
    {
        // Arrange & Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('Project.ProgramId is required.');

        // Act
        new Project(
            id: null,
            programId: 0,
            facilityId: 1,
            title: 'Test Project'
        );
    }

    #[Test]
    public function it_throws_exception_when_facility_id_is_missing()
    {
        // Arrange & Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('Project.FacilityId is required.');

        // Act
        new Project(
            id: null,
            programId: 1,
            facilityId: 0,
            title: 'Test Project'
        );
    }

    #[Test]
    public function it_throws_exception_when_title_is_empty()
    {
        // Arrange & Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('Project.Title is required.');

        // Act
        new Project(
            id: null,
            programId: 1,
            facilityId: 1,
            title: ''
        );
    }

    #[Test]
    public function it_throws_exception_for_invalid_status()
    {
        // Arrange & Assert
        $this->expectException(ProjectException::class);
        $this->expectExceptionMessage('Invalid status');

        // Act
        new Project(
            id: null,
            programId: 1,
            facilityId: 1,
            title: 'Test Project',
            status: 'InvalidStatus'
        );
    }

    #[Test]
    public function it_accepts_all_valid_statuses()
    {
        $validStatuses = ['Planning', 'Active', 'Completed', 'On Hold'];

        foreach ($validStatuses as $status) {
            // Act
            $project = new Project(
                id: null,
                programId: 1,
                facilityId: 1,
                title: 'Test Project',
                status: $status
            );

            // Assert
            $this->assertEquals($status, $project->getStatus());
        }
    }

    #[Test]
    public function it_defaults_to_planning_status()
    {
        // Arrange & Act
        $project = new Project(
            id: null,
            programId: 1,
            facilityId: 1,
            title: 'Test Project'
        );

        // Assert
        $this->assertEquals('Planning', $project->getStatus());
    }

    #[Test]
    public function it_checks_if_project_is_completed()
    {
        // Arrange
        $completedProject = new Project(
            id: null,
            programId: 1,
            facilityId: 1,
            title: 'Completed Project',
            status: 'Completed'
        );

        $activeProject = new Project(
            id: null,
            programId: 1,
            facilityId: 1,
            title: 'Active Project',
            status: 'Active'
        );

        // Assert
        $this->assertTrue($completedProject->isCompleted());
        $this->assertFalse($activeProject->isCompleted());
    }

    // #[Test]
    // public function it_trims_whitespace_in_validation()
    // {
    //     // Arrange & Assert
    //     $this->expectException(ProjectException::class);

    //     // Act - whitespace-only string should fail
    //     new Project(
    //         id: null,
    //         programId: 1,
    //         facilityId: 1,
    //         title: '   '
    //     );
    // }
}