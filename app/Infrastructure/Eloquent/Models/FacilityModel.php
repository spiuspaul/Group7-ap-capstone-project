<?php

namespace App\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityModel extends Model
{
    protected $table = 'facilities';
    // protected $primaryKey = 'facility_id';

    protected $fillable = [
        'name',
        'location',
        'description',
        'partner_organization',
        'facility_type',
        'capabilities',
    ];

    protected $casts = [
        'capabilities' => 'array',
    ];

    public function equipments()
    {
        return $this->hasMany(EquipmentModel::class, 'facility_id', 'facility_id');
    }

    public function services()
    {
        return $this->hasMany(ServiceModel::class, 'facility_id', 'facility_id');
    }

    public function projects()
    {
        return $this->hasMany(ProjectModel::class, 'facility_id', 'facility_id');
    }
}