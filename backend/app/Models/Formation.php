<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formation extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'formation_name',
        'formation_desc',
    ];

    
    public function slots()
    {
        return $this->belongsToMany(
            Slot::class,
            'formation_slots',
            'formation_id',
            'slot_id'
        )->withTimestamps();
    }
}
