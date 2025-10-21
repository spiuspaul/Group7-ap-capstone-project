<?php

namespace App\Domain\Entities;

use App\Domain\Exceptions\ProjectException;

class Project
{
    public function __construct(
        private ?int $id,
        private int $programId,
        private int $facilityId,
        private string $title,
        private string $status = 'Planning',
        private ?string $natureOfProject = null,
        private ?string $description = null,
        private ?string $innovationFocus = null,
        private ?string $prototypeStage = null,
        private ?string $testingRequirements = null,
        private ?string $commercializationPlan = null,
        private array $technicalRequirements = []
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        // Business Rule: Required Associations
        if (empty($this->programId)) {
            throw new ProjectException("Project.ProgramId is required.");
        }

        if (empty($this->facilityId)) {
            throw new ProjectException("Project.FacilityId is required.");
        }

        if (empty(trim($this->title))) {
            throw new ProjectException("Project.Title is required.");
        }

        // Validate status
        $validStatuses = ['Planning', 'Active', 'Completed', 'On Hold'];
        if (!in_array($this->status, $validStatuses)) {
            throw new ProjectException("Invalid status. Must be one of: " . implode(', ', $validStatuses));
        }
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getProgramId(): int { return $this->programId; }
    public function getFacilityId(): int { return $this->facilityId; }
    public function getTitle(): string { return $this->title; }
    public function getStatus(): string { return $this->status; }
    public function getNatureOfProject(): ?string { return $this->natureOfProject; }
    public function getDescription(): ?string { return $this->description; }
    public function getInnovationFocus(): ?string { return $this->innovationFocus; }
    public function getPrototypeStage(): ?string { return $this->prototypeStage; }
    public function getTestingRequirements(): ?string { return $this->testingRequirements; }
    public function getCommercializationPlan(): ?string { return $this->commercializationPlan; }
    public function getTechnicalRequirements(): array { return $this->technicalRequirements; }
    
    public function isCompleted(): bool
    {
        return $this->status === 'Completed';
    }
}