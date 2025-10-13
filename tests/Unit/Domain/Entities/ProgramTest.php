<?php

namespace Tests\Unit\Domain\Entities;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Domain\Entities\Program;
use App\Domain\Exceptions\ProgramException;

class ProgramTest extends TestCase
{
    #[Test]
    public function it_creates_a_valid_program()
    {
        // Arrange & Act
        $program = new Program(
            id: null,
            name: 'Test Program',
            description: 'Test Description',
            nationalAlignment: ['NDPIII'],
            focusAreas: ['IoT'],
            phases: ['Planning']
        );

        // Assert
        $this->assertEquals('Test Program', $program->getName());
        $this->assertEquals('Test Description', $program->getDescription());
    }

    #[Test]
    public function it_throws_exception_when_name_is_empty()
    {
        // Arrange & Assert
        $this->expectException(ProgramException::class);
        $this->expectExceptionMessage('Program.Name is required.');

        // Act
        new Program(
            id: null,
            name: '',
            description: 'Test Description'
        );
    }

    #[Test]
    public function it_throws_exception_when_description_is_empty()
    {
        // Arrange & Assert
        $this->expectException(ProgramException::class);
        $this->expectExceptionMessage('Program.Description is required.');

        // Act
        new Program(
            id: null,
            name: 'Test Program',
            description: ''
        );
    }

    #[Test]
    public function it_throws_exception_when_focus_areas_exist_without_national_alignment()
    {
        // Arrange & Assert
        $this->expectException(ProgramException::class);
        $this->expectExceptionMessage('Program.NationalAlignment must include at least one recognized alignment when FocusAreas are specified.');

        // Act
        new Program(
            id: null,
            name: 'Test Program',
            description: 'Test Description',
            nationalAlignment: [],
            focusAreas: ['IoT']
        );
    }

    #[Test]
    public function it_throws_exception_when_national_alignment_has_invalid_token()
    {
        // Arrange & Assert
        $this->expectException(ProgramException::class);
        $this->expectExceptionMessage('Program.NationalAlignment contains invalid tokens: InvalidToken');

        // Act
        new Program(
            id: null,
            name: 'Test Program',
            description: 'Test Description',
            nationalAlignment: ['InvalidToken']
        );
    }

    #[Test]
    public function it_accepts_valid_national_alignment_tokens()
    {
        // Arrange & Act
        $program = new Program(
            id: null,
            name: 'Test Program',
            description: 'Test Description',
            nationalAlignment: ['NDPIII', 'DigitalRoadmap2023_2028', '4IR']
        );

        // Assert
        $this->assertCount(3, $program->getNationalAlignment());
    }
}