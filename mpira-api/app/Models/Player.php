<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'person_id',
        'player_code',
        'preferred_name',
        'preferred_foot',
        'height_cm',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
    public function code()
    {
        return $this->belongsTo(Code::class);
    }
}
