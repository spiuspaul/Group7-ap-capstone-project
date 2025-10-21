<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\ProjectRepositoryInterface;

class DeleteProject
{
    public function __construct(
        private ProjectRepositoryInterface $repository
    ) {}

    public function execute(int $id): bool
    {
        // No special deletion rules for projects
        return $this->repository->delete($id);
    }
}