<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Season extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'season_name',
        'start_date',
        'end_date',
        'is_active',
    ];
    
    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }
    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
    
    public function teamPlayers(): HasMany
    {
        return $this->hasMany(TeamPlayer::class);
    }

}
