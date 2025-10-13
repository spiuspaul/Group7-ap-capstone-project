<?php

namespace App\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramModel extends Model
{
    protected $table = 'programs';
    // protected $primaryKey = 'program_id';

    protected $fillable = [
        'name',
        'description',
        'national_alignment',
        'focus_areas',
        'phases',
    ];

    protected $casts = [
        'national_alignment' => 'array',
        'focus_areas' => 'array',
        'phases' => 'array',
    ];

    public function projects()
    {
        return $this->hasMany(ProjectModel::class, 'program_id', 'program_id');
    }
}