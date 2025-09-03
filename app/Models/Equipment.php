<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    // Mass assignable fields
    protected $fillable = [
        'name',
        'facility_id',
        'capabilities',
        'description',
        'inventory_code',
        'usage_domain',
        'support_phase'
    ];

    // Relationship to Facility
    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
