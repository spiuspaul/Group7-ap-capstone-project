<?php

namespace App\Infrastructure\Eloquent\Repositories;

use App\Domain\Entities\Program;
use App\Domain\Repositories\ProgramRepositoryInterface;
use App\Infrastructure\Eloquent\Models\ProgramModel;

class ProgramRepository implements ProgramRepositoryInterface
{
    private function toDomain(ProgramModel $model): Program
    {
        return new Program(
            id: $model->program_id,
            name: $model->name,
            description: $model->description ?? '',
            nationalAlignment: $model->national_alignment ?? [],
            focusAreas: $model->focus_areas ?? [],
            phases: $model->phases ?? []
        );
    }

    public function findById(int $id): ?Program
    {
        $model = ProgramModel::find($id);
        return $model ? $this->toDomain($model) : null;
    }

    public function findByName(string $name): ?Program
    {
        $model = ProgramModel::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();
        return $model ? $this->toDomain($model) : null;
    }

    public function save(Program $program): Program
    {
        if ($program->getId()) {
            // Update existing
            $model = ProgramModel::findOrFail($program->getId());
            $model->update([
                'name' => $program->getName(),
                'description' => $program->getDescription(),
                'national_alignment' => $program->getNationalAlignment(),
                'focus_areas' => $program->getFocusAreas(),
                'phases' => $program->getPhases(),
            ]);
        } else {
            // Create new
            $model = ProgramModel::create([
                'name' => $program->getName(),
                'description' => $program->getDescription(),
                'national_alignment' => $program->getNationalAlignment(),
                'focus_areas' => $program->getFocusAreas(),
                'phases' => $program->getPhases(),
            ]);
        }

        return $this->toDomain($model);
    }

    public function delete(int $id): bool
    {
        return ProgramModel::destroy($id) > 0;
    }

    public function hasProjects(int $programId): bool
    {
        $model = ProgramModel::find($programId);
        return $model ? $model->projects()->exists() : false;
    }
}