<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','facility_id'];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
