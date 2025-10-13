<?php

namespace App\Domain\Entities;

use App\Domain\Exceptions\ProgramException;

class Program
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $description,
        private array $nationalAlignment = [],
        private array $focusAreas = [],
        private array $phases = []
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty(trim($this->name))) {
            throw new ProgramException("Program.Name is required.");
        }

        if (empty(trim($this->description))) {
            throw new ProgramException("Program.Description is required.");
        }

        if (!empty($this->focusAreas) && empty($this->nationalAlignment)) {
            throw new ProgramException(
                "Program.NationalAlignment must include at least one recognized alignment when FocusAreas are specified."
            );
        }

        if (!empty($this->nationalAlignment)) {
            $validTokens = ['NDPIII', 'DigitalRoadmap2023_2028', '4IR'];
            $invalidTokens = array_diff($this->nationalAlignment, $validTokens);
            
            if (!empty($invalidTokens)) {
                throw new ProgramException(
                    "Program.NationalAlignment contains invalid tokens: " . implode(', ', $invalidTokens)
                );
            }
        }
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getNationalAlignment(): array { return $this->nationalAlignment; }
    public function getFocusAreas(): array { return $this->focusAreas; }
    public function getPhases(): array { return $this->phases; }
}