<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participation extends Model
{
    
    use HasFactory;
    
    protected $fillable = [
        'season_id',
        'tournament_id',
        'team_id',
        'stadium_id',
        'sponsor_id',
        'is_active',
    ];
    
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
    
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    
    public function stadium()
    {
        return $this->belongsTo(Location::class, 'stadium_id');
    }
    

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
