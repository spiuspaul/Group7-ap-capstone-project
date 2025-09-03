<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    //
    protected $fillable = [
        'name',
        'location',
        'description',
        'partner_organization',
        'facility_type',
        'capabilities',
    ];

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }
    
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
