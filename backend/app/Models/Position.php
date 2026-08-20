<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    
    
    use HasFactory;
    
    protected $fillable = [
        'position_name',
        'position_code',
        'position_desc',
    ];

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }
    
    public function teamPlayers(): HasMany
    {
        return $this->hasMany(TeamPlayer::class);
    }

}
