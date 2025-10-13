<?php

namespace App\Application\UseCases\Program;

use App\Domain\Entities\Program;
use App\Domain\Repositories\ProgramRepositoryInterface;
use App\Domain\Exceptions\ProgramException;
use App\Application\DTOs\ProgramDTO;

class UpdateProgramUseCase
{
    public function __construct(
        private ProgramRepositoryInterface $repository
    ) {}

    public function execute(int $id, ProgramDTO $dto): Program
    {
        // Check uniqueness (excluding current program)
        $existing = $this->repository->findByName($dto->name);
        if ($existing && $existing->getId() !== $id) {
            throw new ProgramException("Program.Name already exists.");
        }

        $program = new Program(
            id: $id,
            name: $dto->name,
            description: $dto->description,
            nationalAlignment: $dto->nationalAlignment,
            focusAreas: $dto->focusAreas,
            phases: $dto->phases
        );

        return $this->repository->save($program);
    }
}