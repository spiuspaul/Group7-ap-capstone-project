<?php

namespace App\Infrastructure\Eloquent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentModel extends Model
{
    use HasFactory;

    protected $table = 'equipment';
    protected $primaryKey = 'equipment_id';

    protected $fillable = [
        'facility_id',
        'name',
        'capabilities',
        'description',
        'inventory_code',
        'usage_domain',
        'support_phase'
    ];

    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class);
    }
}