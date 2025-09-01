<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    //
    use HasFactory;

    // protected $primaryKey = 'program_id'; 

    protected $fillable = [
        'name',
        'description',
        'national_alignment',
        'focus_areas',
        'phases',
    ];

    /**
     * Get the route key for the model.
     */
    // public function getRouteKeyName()
    // {
    //     return 'program_id';
    // }

    // Relationship: A Program has many Projects
    public function projects()
    {
        return $this->hasMany(Project::class, 'program_id');
    }
}
