<?php

namespace App\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'project_id';

    protected $fillable = [
        'program_id',
        'facility_id',
        'title',
        'status',
        'nature_of_project',
        'description',
        'innovation_focus',
        'prototype_stage',
        'testing_requirements',
        'commercialization_plan',
        'technical_requirements',
    ];

    protected $casts = [
        'technical_requirements' => 'array',
    ];

    public function program()
    {
        return $this->belongsTo(ProgramModel::class, 'program_id', 'program_id');
    }

    public function facility()
    {
        return $this->belongsTo(FacilityModel::class, 'facility_id', 'facility_id');
    }

    public function participants()
    {
        return $this->hasMany(ParticipantModel::class, 'project_id', 'project_id');
    }

    public function outcomes()
    {
        return $this->hasMany(OutcomeModel::class, 'project_id', 'project_id');
    }
}