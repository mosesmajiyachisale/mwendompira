<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function code(): BelongsTo
    {
        return $this->belongsTo(Code::class,'player_code');
    }
    
    public function teamPlayers(): HasMany
    {
        return $this->hasMany(TeamPlayer::class);
    }

    
}