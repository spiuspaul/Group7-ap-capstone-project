<?php

namespace App\Application\UseCases\Program;

use App\Domain\Repositories\ProgramRepositoryInterface;
use App\Domain\Exceptions\ProgramException;

class DeleteProgramUseCase
{
    public function __construct(
        private ProgramRepositoryInterface $repository
    ) {}

    public function execute(int $id): bool
    {
        if ($this->repository->hasProjects($id)) {
            throw new ProgramException("Program has Projects; archive or reassign before delete.");
        }

        return $this->repository->delete($id);
    }
}