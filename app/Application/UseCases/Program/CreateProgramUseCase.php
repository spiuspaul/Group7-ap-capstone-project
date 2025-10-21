<?php

namespace App\Application\UseCases\Program;

use App\Domain\Entities\Program;
use App\Domain\Repositories\ProgramRepositoryInterface;
use App\Domain\Exceptions\ProgramException;
use App\Application\DTOs\ProgramDTO;

class CreateProgramUseCase
{
    public function __construct(
        private ProgramRepositoryInterface $repository
    ) {}

    public function execute(ProgramDTO $dto): Program
    {
        // Check uniqueness
        if ($this->repository->findByName($dto->name)) {
            throw new ProgramException("Program.Name already exists.");
        }

        $program = new Program(
            id: null,  // Let the repository assign the ID
            name: $dto->name,
            description: $dto->description,
            nationalAlignment: $dto->nationalAlignment,  // Remove the extra array wrapping
            focusAreas: $dto->focusAreas,
            phases: $dto->phases    
        );

        return $this->repository->save($program);
    }
}