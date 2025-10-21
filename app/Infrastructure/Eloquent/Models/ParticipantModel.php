<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParticipantModel extends Model
{
    use HasFactory;

    protected $table = 'participants';
    protected $primaryKey = 'participant_id';

    protected $fillable = [
        'project_id',
        'full_name',
        'email',
        'affiliation',
        'specialization',
        'cross_skill_trained',
        'institution'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }
}
