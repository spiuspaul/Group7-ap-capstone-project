<?php

namespace Tests\Unit\Application\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Application\UseCases\Project\DeleteProjectUseCase as DeleteProject;
use App\Domain\Repositories\ProjectRepositoryInterface;

class DeleteProjectTest extends TestCase
{
    #[Test]
    public function it_deletes_a_project_successfully()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('delete')->with(1)->willReturn(true);

        $useCase = new DeleteProject($repo);

        // Act
        $result = $useCase->execute(1);

        // Assert
        $this->assertTrue($result);
    }

    #[Test]
    public function it_returns_false_when_project_does_not_exist()
    {
        // Arrange
        $repo = $this->createMock(ProjectRepositoryInterface::class);
        $repo->method('delete')->with(999)->willReturn(false);

        $useCase = new DeleteProject($repo);

        // Act
        $result = $useCase->execute(999);

        // Assert
        $this->assertFalse($result);
    }
}