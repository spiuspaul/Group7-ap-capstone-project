<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    Use HasFactory;

    protected $fillable = ['name','description', 'facility-id'];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
        
    }
}
