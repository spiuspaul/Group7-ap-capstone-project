<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Entities\Participant;
use App\Domain\Repositories\ParticipantRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\ParticipantModel;

class ParticipantRepository implements ParticipantRepositoryInterface
{
    public function findById(int $participantId): ?Participant
    {
        $model = ParticipantModel::find($participantId);
        return $model ? $this->mapToEntity($model) : null;
    }

    public function findByEmail(string $email): ?Participant
    {
        $model = ParticipantModel::whereRaw('LOWER(email) = ?', [strtolower($email)])->first();
        return $model ? $this->mapToEntity($model) : null;
    }

    public function save(Participant $participant): Participant
    {
        $data = [
            'project_id' => $participant->getProjectId(),
            'full_name' => $participant->getFullName(),
            'email' => $participant->getEmail(),
            'affiliation' => $participant->getAffiliation(),
            'specialization' => $participant->getSpecialization(),
            'cross_skill_trained' => $participant->isCrossSkillTrained(),
            'institution' => $participant->getInstitution(),
        ];

        if ($participant->getParticipantId()) {
            $model = ParticipantModel::find($participant->getParticipantId());
            $model->update($data);
        } else {
            $model = ParticipantModel::create($data);
        }

        return $this->mapToEntity($model);
    }

    public function delete(int $participantId): bool
    {
        $model = ParticipantModel::find($participantId);
        if (!$model) return false;
        return $model->delete();
    }

    public function isLinkedToActiveProject(int $participantId): bool
    {
        $participant = ParticipantModel::find($participantId);
        if (!$participant) return false;

        return \App\Infrastructure\Persistence\Eloquent\Models\Project::where('project_id', $participant->project_id)
            ->where('status', 'active')
            ->exists();
    }

    private function mapToEntity(ParticipantModel $model): Participant
    {
        return new Participant(
            participantId: $model->participant_id,
            projectId: $model->project_id,
            fullName: $model->full_name,
            email: $model->email,
            affiliation: $model->affiliation,
            specialization: $model->specialization,
            crossSkillTrained: $model->cross_skill_trained,
            institution: $model->institution
        );
    }
}
