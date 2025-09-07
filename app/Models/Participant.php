<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'project_id',
        'full_name',
        'email',
        'affiliation',
        'specialization',
        'cross_skill_trained',
        'institution',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
